<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Languages;

/* @var $this yii\web\View */
/* @var $model app\models\SnippetsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="snippets-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <h3>Languages</h3>
    <label><input type="radio" name="SnippetsSearch[id_language]" value="" checked="checked">All</label>
    <?= $form->field($model, 'id_language')->radioList(ArrayHelper::map(Languages::find()->asArray()->all(), 'id', 'name') )->label(false) ?>

    <h3>Title</h3>
    <?= $form->field($model, 's_title')->label(false) ?>    

    <?php // echo $form->field($model, 's_code') ?>

    <?php // echo $form->field($model, 's_date') ?>

    <?php // echo $form->field($model, 'is_public') ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', ['class' => 'btn btn-default btn-block']) ?>       
    </div>

    <?php ActiveForm::end(); ?>

</div>
