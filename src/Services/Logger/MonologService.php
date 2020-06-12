<?php
/**
 * m3u_downloader - MonologService.php
 *
 * Initial version by: Toamsz Solik
 * Initial version created on: 12.06.20 / 14:02
 */

namespace App\Services\Logger;


use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MonologService
{
    /**
     * @param string $message
     * @param array $context
     * @param string $method
     */
    public function addCritical(string $message = '', array $context = [], string $method = 'App')
    {
        $this->addLog($message, $context, $method, Logger::DEBUG);
    }

    /**
     * @param string $message
     * @param array $context
     * @param string $method
     * @param int $level
     */
    public function addLog(string $message, array $context, string $method, int $level)
    {
        $logger = new Logger($method);
        $logger->pushHandler(new StreamHandler(self::DIR.date('Y-m-d').'.log', $level));
        $logger->pushHandler(new FirePHPHandler());
        $logger->info($message, $context);
    }

    public const DIR = __DIR__.'/../../../var/logs/';
}