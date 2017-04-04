<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\test\TestPost */

$this->title = 'Create Test Post';
$this->params['breadcrumbs'][] = ['label' => 'Test Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
