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

    <h1><?= Html::encode($this->title) ?></h1> <span class="user-snippet">By <?php echo $user; ?></span>

    <div id="snip-content">
        <section><?php echo $model->s_description; ?></section>
        <pre><code><?php echo str_replace(['<', '>'], ['&lt;', '&gt;'], $model->s_code); ?></code></pre>
        <time><?php echo $model->s_date; ?></time>
    </div>
    
    <div id='likeshare' class="row">
        <div id="likes" class="col-md-6">
                
            <p>Like <?= Html::a('<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>', ['like', 'id' => $model->id, 'is_like' => 1], ['class' => 'btn btn-success']) ?> [<?php echo $snippetlikes; ?>] 
             Dislike <?= Html::a('<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>', ['like', 'id' => $model->id, 'is_like' => 0], ['class' => 'btn btn-danger']) ?> [<?php echo $snippetdislikes; ?>]</p>

        </div>
        
        <div id='sharing' class="col-md-6 text-right">
            <div class="addthis_inline_share_toolbox"></div>
        </div>        
    </div>
    
    <div id="comments">
        <h3>Comments</h3>
        <?php if($comments == []) echo 'None yet'; ?>
        <?php foreach ($comments as $comment){ ?>
        <div class="comment">
            <p><span class="user-snippet"><?php echo $comment['username']; ?> says:</span></p>
            <div><?php echo str_replace(['<', '>'], ['&lt;', '&gt;'], $comment['c_text']); ?>
            <p><?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['commentlike', 'id' => $comment['id'], 'is_like' => 1], ['class' => 'btn btn-success btn-xs']) ?> 
                [<?php echo  $comment['countlike'];?>] <?= Html::a('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>', ['commentlike', 'id' => $comment['id'], 'is_like' => 0], ['class' => 'btn btn-danger btn-xs']) ?> 
                [<?php echo  $comment['countdislike'];?>] <?= $comment['id_user'] == Yii::$app->user->getId() ? 
                        "<a href='index.php/?r=comments%2Fupdate&id=".$comment['id']."'>"
                        . "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> "
                        . "<a href='index.php/?r=comments%2Fdelete&id=".$comment['id']."' data-method='post' data-confirm = 'Are you sure you want to delete this item?'>"
                        . "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>" : '' ?></p>            
            </div>
        </div>
        <?php } ?>
    </div>
    
    
    <div id="commentform">
        <h3>Write a comment</h3>
        
        <?php $form = ActiveForm::begin(['action' =>['/comments/create']]); ?>    

    <?= $form->field($model2, 'c_text')->textArea(['maxlength' => true])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Write', ['class' => $model2->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>


