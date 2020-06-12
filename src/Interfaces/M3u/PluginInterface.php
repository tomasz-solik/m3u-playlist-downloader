<?php
/**
 * m3u_downloader - PluginInterface.php
 *
 * Initial version by: Toamsz Solik
 * Initial version created on: 12.06.20 / 12:11
 */
namespace App\Interfaces\M3u;

interface PluginInterface
{
    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @return array
     */
    public function getHeader(): array;

    /**
     * @return array
     */
    public function getBody(): array;

    /**
     * @param $responseBody
     * @return string
     */
    public function getUrlToM3u($responseBody): string;
}