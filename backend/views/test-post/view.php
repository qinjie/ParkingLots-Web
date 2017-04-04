<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\test\TestPost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Test Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-post-view">

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
            'title',
            'content:ntext',
            'tags:ntext',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
            'user_id',
        ],
    ]) ?>

</div>
