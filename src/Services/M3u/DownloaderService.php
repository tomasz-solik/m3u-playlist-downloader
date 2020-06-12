<?php
/**
 * m3u_downloader - downloaderService.php
 *
 * Initial version by: Toamsz Solik
 * Initial version created on: 12.06.20 / 12:07
 */

namespace App\Services\M3u;

use App\Exceptions\M3u\DownloaderGetDataException;
use App\Interfaces\M3u\PluginInterface;
use App\Services\Logger\MonologService;
use GuzzleHttp\Client;

class DownloaderService
{
    /**
     * @var Client
     */
    public $clientGuzzle;
    /**
     * @var PluginInterface
     */
    private $plugin;
    /**
     * @var MonologService
     */
    private $logger;

    /**
     * DownloaderService constructor.
     * @param PluginInterface $plugin
     */
    public function __construct(PluginInterface $plugin)
    {
        $this->clientGuzzle = new Client([
            'exceptions' => false,
        ]);
        $this->plugin = $plugin;
        $this->logger = new MonologService();

    }

    /**
     * @return string|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download(): ?string
    {
        $pathToM3uFile = null;
        try {
            $response = $this->clientGuzzle->request(
                $this->plugin->getMethod(),
                $this->plugin->getUrl(),
                array_merge($this->plugin->getHeader(), $this->plugin->getBody())
            );
            $responseHttpStatusCode = $response->getStatusCode();
            $responseBody = (string)$response->getBody();
            if ($responseHttpStatusCode !== 200) {
                throw new DownloaderGetDataException('Failed to get response, http status :'.$responseHttpStatusCode.' body: '.$responseBody);
            }
            $urlToM3u = $this->plugin->getUrlToM3u($responseBody);
            $pathToM3uFile = $this->downloadContent($urlToM3u);
        } catch (\Exception $ex) {
            $this->logger->addCritical(__METHOD__, ['ex' => $ex->getMessage()]);
        }

        return $pathToM3uFile;
    }

    /**
     * @param string $url
     * @return string|null
     */
    public function downloadContent(string $url): ?string
    {
        $result = null;
        try {
            $content = file_get_contents($url);
            if ($content === false) {
                throw new DownloaderGetDataException('Failed to download m3u file at: '.$url);
            }
            $fileName = 'playlist_'.time().'.m3u';
            $pathToFile = __DIR__.'/../../../storage/playlist/raw/in/'.$fileName;
            $file = file_put_contents($pathToFile, $content);
            if ($file === false) {
                throw new DownloaderGetDataException('Failed to save file to: ', $pathToFile);
            }
            $result = $pathToFile;
        } catch (\Exception $ex) {
            $this->logger->addCritical(__METHOD__, ['ex' => $ex->getMessage()]);
        }

        return $result;
    }
}