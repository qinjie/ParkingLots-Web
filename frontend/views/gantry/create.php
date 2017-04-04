<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SensorGantry */

$this->title = 'Create Gantry';
$this->params['breadcrumbs'][] = ['label' => 'Gantries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gantry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
