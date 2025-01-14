<?php

namespace backend\controllers;

use common\services\CsvService;
use Yii;
use yii\web\Controller;

/**
 * Download csv-file controller
 */
class CsvController extends Controller
{

    /**
     * Handles the CSV export request.
     * Retrieves filter and sorting parameters from the POST request,
     * processes them, and triggers the CSV generation.
     *
     * @return void
     */
    public function actionDischarge() : void
    {
        $url = Yii::$app->request->post('url', '');
        $statusCode = Yii::$app->request->post('status_code', '');
        $sortAttribute = Yii::$app->request->post('sort', '');
        $lastDay = Yii::$app->request->post('lastDay', false);
        CsvService::saveCsv($url, intval($statusCode), $sortAttribute, filter_var($lastDay, FILTER_VALIDATE_BOOLEAN));
    }

}