<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\UrlStatusFilter;

class AdminController extends Controller
{

    /**
     * Handles the index action for the controller.
     * This action is responsible for displaying filtered and sorted data in the view.
     * It retrieves filter parameters from the GET request, applies filtering and sorting,
     * and renders the index view with the processed data.
     *
     * @return string The rendered view with filtered and sorted data.
     */
    public function actionIndex(): string
    {
        $filterModel = new UrlStatusFilter();
        $lastDay = Yii::$app->request->get('lastDay', false);

        $filterModel->load(Yii::$app->request->get());

        $data = $filterModel->getFilteredData($lastDay, $filterModel->getSort());

        return $this->render('index', [
            'data' => $data,
            'filterModel' => $filterModel,
            'sort' => $filterModel->getSort(),
        ]);
    }
}