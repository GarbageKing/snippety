<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Snippets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="snippets-form row">

   <div class="col-md-offset-3 col-md-6">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_language')->dropDownList(
        ArrayHelper::map($languages, 'id', 'name')
    )->label('Language') ?>

    

    <?= $form->field($model, 's_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 's_description')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 's_code')->textArea(['maxlength' => true, 'class' => 'codearea form-control'])->label('Code') ?>   

    <?= $form->field($model, 'is_public')->radioList([ 1=>'Public', 0=>'Private']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
   </div>

</div>
