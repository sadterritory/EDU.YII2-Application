<?php

namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;
use common\services\UrlStatistics;

class CheckStatusController extends Controller
{

    /**
     * Processes a console command to output URL statistics for the last day.
     *
     * The method receives data about URLs and their status codes for the last 24 hours using
     * the `UrlStatistics' method::getUrlsByLastDay()`. If the data is found, it is output to the console
     * in the "URL status code" format. If no data is available, a message is displayed stating
     * that URLs have not been found.
     *
     * The output is formatted using colors:
     * - Green for successful data retrieval.
     * - Red color for the case when no data is found.
     */
    public function actionStatistics(): void
    {
        $data = UrlStatistics::getUrlsByLastDay();
        if ($data) {
            $this->stdout("[+] Found urls:\n", Console::BOLD, Console::FG_GREEN);
            foreach ($data as $url) {
                $this->stdout("Url: {$url->url} | {$url->status_code}\n");
            }
        } else {
            $this->stdout("[-] Urls not found\n", Console::BOLD, Console::FG_RED);
        }
    }
}