<?php

namespace common\services;

use backend\models\UrlStatusFilter;
use common\models\UrlStatus;
use Yii;
use yii\data\Sort;


class CsvService
{

    /**
     * Generates a CSV file based on the provided filter and sorting parameters.
     * If `lastDay` is true, retrieves data for the last day; otherwise, applies filtering and sorting.
     *
     * @param string $url The URL filter value.
     * @param int $statusCode The status code filter value.
     * @param mixed $sortAttribute The sorting attribute.
     * @param bool $lastDay Whether to filter data for the last day.
     * @return void
     */
    public static function saveCsv(string $url, int $statusCode, $sortAttribute, bool $lastDay = false) : void
    {
        $filterModel = new UrlStatusFilter();
        $filterModel->url = $url;
        $filterModel->status_code = $statusCode;
        $sort = new Sort([
            'attributes' => [
                'created_at' => [
                    'label' => 'Created At',
                    'default' => SORT_ASC,
                ],
                'updated_at' => [
                    'label' => 'Updated At',
                    'default' => SORT_ASC,
                ],
            ],
        ]);

        if ($sortAttribute) {
            $sort->params = ['sort' => $sortAttribute];
        }

        if ($lastDay) {
            $data = UrlStatistics::getUrlsByLastDay();
        } else {
            $data = UrlStatus::getFilteredData($filterModel, $sort);
        }

        self::generateCsv($data);
    }

    /**
     * Generates a CSV file from the provided data and sends it to the user for download.
     * The file is temporarily saved on the server and deleted after sending.
     *
     * @param array $data The data to be exported to the CSV file.
     * @return void
     */
    private static function generateCsv(array $data) : void
    {
        date_default_timezone_set('Asia/Krasnoyarsk');
        $fileName = 'export_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = Yii::getAlias('@webroot/' . $fileName);

        $file = fopen($filePath, 'w');

        fputcsv($file, ['hash_string', 'created_at', 'updated_at', 'url', 'status_code', 'query_count']);

        foreach ($data as $item) {
            fputcsv($file, [
                $item->hash_string,
                $item->created_at,
                $item->updated_at,
                $item->url,
                $item->status_code,
                $item->query_count,
            ]);
        }

        fclose($file);

        Yii::$app->response->sendFile($filePath)->send();

        unlink($filePath);
    }
}