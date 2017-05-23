<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Snippets */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Snippets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippets-view">

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
            'id_language',
            'id_user',
            's_title',
            's_description',
            's_code',
            's_date',
            'is_public',
        ],
    ]) ?>
    <div id="likes">
                
        <p>Like<?= Html::a('Like', ['like', 'id' => $model->id, 'is_like' => 1], ['class' => 'btn btn-primary']) ?> {<?php echo $snippetlikes; ?>} Dislike <?= Html::a('Dislike', ['like', 'id' => $model->id, 'is_like' => 0], ['class' => 'btn btn-danger']) ?> {<?php echo $snippetdislikes; ?>}</p>

    </div>
    
    <div id="comments">
        <?php foreach ($comments as $comment){ ?>
        
            <div><?php echo $comment['c_text']; ?>
            <p>Like<?= Html::a('Like', ['commentlike', 'id' => $comment['id'], 'is_like' => 1], ['class' => 'btn btn-primary']) ?> 
                {<?php echo  $comment['countlike'];?>} Dislike <?= Html::a('Dislike', ['commentlike', 'id' => $comment['id'], 'is_like' => 0], ['class' => 'btn btn-danger']) ?> 
                {<?php echo  $comment['countdislike'];?>}</p>
            </div>
        
        <?php } ?>
    </div>
    
    
    <div id="commentform">
        <?php $form = ActiveForm::begin(['action' =>['/comments/create']]); ?>    

    <?= $form->field($model2, 'c_text')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model2->isNewRecord ? 'Create' : 'Update', ['class' => $model2->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
