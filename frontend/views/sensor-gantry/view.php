<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SensorGantry */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sensor Gantries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sensor-gantry-view">

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
            'serial',
            'exit_count',
            'entry_count',
            'car_park_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <br>
    <h2>Latest Traffic Flow</h2>
    <?php if ($model->getLatestTrafficFlow()) { ?>
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
    <?php } else {
        echo "Not available";
    } ?>
</div>
