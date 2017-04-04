<?php

use common\models\SensorGantry;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CarPark */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Car Parks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-park-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'label',
            'lot_capacity',
            'car_count',
            'serial',
            'status',
            'remark',
            'user_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>


    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => SensorGantry::find()->where(['car_park_id' => $model->id]),
    ]);
    ?>

    <br>
    <h2>Gantries</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'label',
            'serial',
            'exit_count',
            'entry_count',
            // 'car_park_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'controller' => 'sensor-gantry'],
        ],
    ]); ?>

    <br>
    <h2>Latest Traffic Flow</h2>
    <?= DetailView::widget([
        'model' => $model->getLatestTrafficFlow(),
        'attributes' => [
            'id',
            'sensor_gantry_id',
            'direction',
            'entry_count',
            'exit_count',
            'car_park_id',
            'car_count',
            'empty_lot',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
