<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CarPark */

$this->title = 'Create Car Park';
$this->params['breadcrumbs'][] = ['label' => 'Car Parks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-park-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
