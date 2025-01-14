<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Sort;
use common\models\UrlStatus;
use backend\models\UrlStatusFilter;
use common\services\UrlStatistics;

/**
 * Admin panel controller
 */
class AdminController extends Controller
{
    /**
     * An action to display the main page of the admin panel.
     * Handles data filtering and sorting.
     *
     * @return string The result of rendering the view.
     */
    public function actionIndex(): string
    {
        $filterModel = new UrlStatusFilter();
        $data = [];

        $lastDay = Yii::$app->request->get('lastDay', false);
        if ($lastDay) {
            $data = UrlStatistics::getUrlsByLastDay();
        } else {
            if ($filterModel->load(Yii::$app->request->get()) && $filterModel->validate()) {
                $data = UrlStatus::getFilteredData($filterModel, $this->getSort());
            } else {
                $data = UrlStatus::getAllData($this->getSort());
            }
        }

        return $this->render('index', [
            'data' => $data,
            'filterModel' => $filterModel,
            'sort' => $this->getSort(),
        ]);
    }

    /**
     * Creates and returns a Sort object to configure data sorting.
     *
     * @return Sort The Sort object with the sorting settings.
     */
    protected function getSort() : Sort
    {
        return new Sort([
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
    }
}