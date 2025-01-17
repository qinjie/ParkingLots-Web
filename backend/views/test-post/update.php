<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\test\TestPost */

$this->title = 'Update Test Post: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Test Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="test-post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
