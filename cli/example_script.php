<?php
/**
 * m3u_downloader - get_list.php
 *
 * Initial version by: Toamsz Solik
 * Initial version created on: 12.06.20 / 11:17
 */


use App\Services\M3u\DownloaderService;
use App\Services\M3u\ParseService;

require __DIR__ . '/../vendor/autoload.php';

$downloaderService= new DownloaderService(new \App\Services\M3u\Plugins\ExamplePlugin());
$pathToM3uFile = $downloaderService->download();
// if parse to new playlist
$parserService = new ParseService();
$parserService->parse($pathToM3uFile, ['group1', 'group2']);