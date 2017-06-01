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

    <div class="form-group row">
        <div class="col-xs-12"><h3>Title</h3></div>
        <div class="col-xs-9"><?= $form->field($model, 's_title')->label(false) ?></div>  
        <div class="col-xs-3"><?= Html::submitButton('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', ['class' => 'btn btn-default btn-block langsearch']) ?></div>       
    </div>
    <div class="form-group">
        <h3>Languages</h3> 
        <label><input type="radio" name="SnippetsSearch[id_language]" value="" checked="checked">All</label>
        <?= $form->field($model, 'id_language')->radioList(ArrayHelper::map(Languages::find()->asArray()->all(), 'id', 'name') )->label(false) ?>
    </div>    

    <?php ActiveForm::end(); ?>

</div>
