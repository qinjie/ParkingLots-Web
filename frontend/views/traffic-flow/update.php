<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TrafficFlow */

$this->title = 'Update Traffic Flow: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Traffic Flows', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="traffic-flow-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
