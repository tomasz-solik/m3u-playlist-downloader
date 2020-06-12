<?php
/**
 * m3u_downloader - OttplusPlugin.php
 *
 * Initial version by: Toamsz Solik
 * Initial version created on: 12.06.20 / 12:09
 */
namespace App\Services\M3u\Plugins;

use App\Interfaces\M3u\PluginInterface;
use Symfony\Component\Yaml\Parser;

class ExamplePlugin implements PluginInterface
{
    /**
     * @var Parser
     */
    private $yaml;
    /**
     * @var array
     */
    private $config;

    public function __construct()
    {
        $this->yaml = new Parser();
        $this->config = $this->yaml->parseFile(self::CONFIG_FILE);

    }

    public function getUrl(): string
    {
        return $this->config['url'];
    }

    public function getMethod(): string
    {
        return $this->config['method'];
    }

    public function getHeader(): array
    {
        return ['headers' => $this->config['headers']];
    }

    public function getBody(): array
    {
        return ['form_params' => $this->config['form_params']];
    }

    public function getUrlToM3u($responseBody): string
    {
        // example parse
        $body = explode($this->config['explode_by'], $responseBody);
        $body = str_replace('<br>', '', $body[1]);

        return trim($body);
    }

    public const CONFIG_FILE = __DIR__.'/../../../../config/m3u_plugin_example.yaml';
}