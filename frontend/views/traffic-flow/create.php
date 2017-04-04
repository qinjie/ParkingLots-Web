<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TrafficFlow */

$this->title = 'Create Traffic Flow';
$this->params['breadcrumbs'][] = ['label' => 'Traffic Flows', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traffic-flow-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
