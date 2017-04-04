<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tokens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-token-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Generate Token', ['generate'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'token',
            'ipAddress',
            'expire',
            'created',
            ['attribute' => 'isActive',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    return Html::checkbox('isActive', $model->isActive, ['value' => $index, 'disabled' => true]);
                },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',],
        ],
    ]); ?>

</div>
