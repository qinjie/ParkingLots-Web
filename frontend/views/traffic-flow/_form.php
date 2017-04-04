<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TrafficFlow */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="traffic-flow-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sensor_gantry_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entry_count')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'exit_count')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'car_park_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'car_count')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'empty_lot')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
