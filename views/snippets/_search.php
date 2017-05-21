<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SnippetsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="snippets-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_language') ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 's_title') ?>

    <?= $form->field($model, 's_description') ?>

    <?php // echo $form->field($model, 's_code') ?>

    <?php // echo $form->field($model, 's_date') ?>

    <?php // echo $form->field($model, 'is_public') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
