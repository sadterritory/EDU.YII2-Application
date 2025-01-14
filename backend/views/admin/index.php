<?php

/** @var yii\web\View $this */
/** @var $data */
/** @var $filterModel \backend\models\UrlStatusFilter */
/** @var $sort \yii\data\Sort */

$this->title = 'Admin panel';

?>

<div class="site-admin">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Url_status table</h1>
    </div>

<!--    <p><a class="btn btn-lg btn-success" onclick="" ">Get started with Yii</a></p>-->

    <?php $form = \yii\widgets\ActiveForm::begin([
        'method' => 'get',
        'action' => ['admin/index'],
    ]); ?>

    <?= $form->field($filterModel, 'url')->textInput() ?>
    <?= $form->field($filterModel, 'status_code')->textInput() ?>

    <div class="form-group myButton">
        <?= \yii\helpers\Html::submitButton('Search ', ['class' => 'btn btn-primary']) ?>
        <?= \yii\helpers\Html::a('Last Day', ['admin/index', 'lastDay' => true], ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

    <div class="body-content">
        <table class="table">
            <thead>
            <tr>
                <th>hash_string</th>
                <th><?= $sort->link('created_at') ?></th>
                <th><?= $sort->link('updated_at') ?></th>
                <th>url</th>
                <th>status_code</th>
                <th>query_count</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $item): ?>
                <tr>
                    <td><?= $item->hash_string ?></td>
                    <td><?= $item->created_at ?></td>
                    <td><?= $item->updated_at ?></td>
                    <td><?= $item->url ?></td>
                    <td><?= $item->status_code ?></td>
                    <td><?= $item->query_count ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
