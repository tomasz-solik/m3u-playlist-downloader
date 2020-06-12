<?php
/**
 * m3u_downloader - ParseService.php
 *
 * Initial version by: Toamsz Solik
 * Initial version created on: 12.06.20 / 13:01
 */

namespace App\Services\M3u;

use App\Services\Logger\MonologService;
use M3uParser\M3uData;
use M3uParser\M3uEntry;
use M3uParser\M3uParser;
use M3uParser\Tag\ExtInf;

class ParseService
{
    /**
     * @var M3uParser
     */
    private $m3UParser;
    /**
     * @var
     */
    private $m3uEntry;
    /**
     * @var M3uData
     */
    private $m3uData;
    /**
     * @var MonologService
     */
    private $logger;

    public function __construct()
    {
        $this->m3UParser = new M3uParser();
        $this->m3uData = new M3uData();
        $this->logger = new MonologService();
    }

    /**
     * @param string $pathToM3uFile
     * @param array $groups
     */
    public function parse(string $pathToM3uFile, array $groups = [])
    {
        try {

            $this->m3UParser->addDefaultTags();
            $data = $this->m3UParser->parseFile($pathToM3uFile);

            /** @var M3uEntry $entry */
            foreach ($data as $entry) {

                /** @var ExtInf $extInf */
                $extInf = $entry->getExtTags()[0];

                if(!in_array($extInf->getAttribute('group-title'), $groups)){
                    continue;
                }

                $this->addToPlaylist($entry);

            }

            $pathToFile = __DIR__.'/../../../storage/playlist/raw/out/out_file_pl.m3u';
            $file = file_put_contents($pathToFile, $this->m3uData);
            if ($file === false) {
                throw new Exception('Failed to save file to: ', $pathToFile);
            }

            echo 'OK';


        } catch (\Exception $ex) {
            $this->logger->addCritical(__METHOD__, ['ex' => $ex->getMessage()]);
        }
    }

    /**
     * @param M3uEntry $entry
     */
    public function addToPlaylist(M3uEntry $entry)
    {
        try {

            $this->m3uEntry = new M3uEntry();
            $this->m3uEntry->setPath($entry->getPath());

            /** @var ExtInf $extInf */
            $extInf = $entry->getExtTags()[0];
            $tag = (new ExtInf())
                ->setTitle($extInf->getTitle())
                ->setDuration($extInf->getDuration())
                ->setAttributes($extInf->getAttributes());
            $this->m3uEntry->addExtTag($tag);
            $this->m3uData->append($this->m3uEntry);

        } catch (\Exception $ex) {
            $this->logger->addCritical(__METHOD__, ['ex' => $ex->getMessage()]);
        }
    }



}