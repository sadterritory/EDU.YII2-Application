<?php

namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use Yii;

class UrlController extends ActiveController
{
    public $modelClass = 'common\models\UrlStatus';

    /**
     * @return responses array of urls and statuses
     * We turn to the model to check for the url and perform actions with the data provided by the endpoint
     * /checkStatus call.
     */
    public function actionCheckStatus() : array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $urls = Yii::$app->request->post('url');
        $responses = [];
        foreach ($urls as $url) {
            $responses[] = $this->modelClass::validateUrl($url);
        }
        return $responses;
    }
}