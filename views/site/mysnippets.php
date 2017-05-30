<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'My Snippets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-snippets">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php foreach($snippets as $snippet) { ?>
    
        <div>
            <h3><?php echo $snippet['s_title']; ?></h3>
            <p><?php echo $snippet['s_description']; ?></p>
            <time><?php echo $snippet['s_date']; ?></time>
            <?php echo "<a href='index.php/?r=snippets%2Fupdate&id=".$snippet['id']."'>"
                        . "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a> "
                        . "<a href='index.php/?r=snippets%2Fdelete&id=".$snippet['id']."' data-method='post' data-confirm = 'Are you sure you want to delete this item?'>"
                        . "<span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
            ?>
        </div>
    
    <?php } ?>    
    
</div>
