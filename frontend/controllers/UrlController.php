<?php

namespace frontend\controllers;

use yii\rest\ActiveController;

class UrlController extends ActiveController
{
    public $modelClass = 'common\models\UrlStatus';
    public function actionHello(): string
    {
        return $this->render('hello-world');
    }
    public function checkUrlStatus(){
        $request =  \Yii::$app->request;
        //$data = $this->request->post();
        $params = $request->bodyParams;
        return $params;
        /*foreach ($data as $url){
            if($entity = UrlStatus::findUrl($url)){

            } else {

            }
        }*/
    }
}