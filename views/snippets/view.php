<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Snippets */

$this->title = $model->s_title;
$this->params['breadcrumbs'][] = ['label' => 'Snippets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippets-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="snip-content">
        <section><?php echo $model->s_description; ?></section>
        <code><?php echo $model->s_code; ?></code>
        <time><?php echo $model->s_date; ?></time>
    </div>
    
    
    <div id="likes">
                
        <p>Like <?= Html::a('<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>', ['like', 'id' => $model->id, 'is_like' => 1], ['class' => 'btn btn-primary']) ?> {<?php echo $snippetlikes; ?>} 
           Dislike <?= Html::a('<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>', ['like', 'id' => $model->id, 'is_like' => 0], ['class' => 'btn btn-danger']) ?> {<?php echo $snippetdislikes; ?>}</p>

    </div>
    
    <div id="comments">
        <h3>Comments</h3>
        
        <?php foreach ($comments as $comment){ ?>
        
            <div><?php echo $comment['c_text']; ?>
            <p>Like <?= Html::a('+', ['commentlike', 'id' => $comment['id'], 'is_like' => 1], ['class' => 'btn btn-primary']) ?> 
                {<?php echo  $comment['countlike'];?>} Dislike <?= Html::a('-', ['commentlike', 'id' => $comment['id'], 'is_like' => 0], ['class' => 'btn btn-danger']) ?> 
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
