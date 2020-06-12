<?php
/**
 * m3u_downloader - DownloaderGetDataException.php
 *
 * Initial version by: Toamsz Solik
 * Initial version created on: 12.06.20 / 13:54
 */
namespace App\Exceptions\M3u;

use Throwable;

class DownloaderGetDataException extends \RuntimeException
{
    public function __construct(string $exceptionMessage = "", int $code = 0, Throwable $previous = null)
    {
        $message = '[M3u][Downloader][GetData]: '.$exceptionMessage;
        parent::__construct($message, $code, $previous);
    }

}