<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Snippets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="snippets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_language')->dropDownList(
        ArrayHelper::map($languages, 'id', 'name')
    ) ?>

    

    <?= $form->field($model, 's_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 's_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 's_code')->textInput(['maxlength' => true]) ?>

   

    <?= $form->field($model, 'is_public')->radioList([ 1=>'Public', 0=>'Private']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    

</div>
