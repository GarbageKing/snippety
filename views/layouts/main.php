<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html> 
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Snippety[ ]',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            Yii::$app->user->getId() ? ['label' => 'My Snippets', 'url' => ['/site/mysnippets']] : '',       
            Yii::$app->user->isGuest ? (
                ['label' => 'Register', 'url' => ['/users/create']]
            ) : (                
                '<li><a href="?r=users/update&id='.Yii::$app->user->getId().'">Update Info</a><li>'
            ),
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="text-center">&copy; Garbage_kinG <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
    
    <link rel="stylesheet" href="assets/highlight.js/styles/ocean.css">
<script src="assets/highlight.js/highlight.pack.js"></script>
<script>//hljs.initHighlightingOnLoad();
$(document).ready(function() {
  $('code, .codearea').each(function(i, block) {
    hljs.highlightBlock(block);
  });
  $('.snippets-search label').click(function(){
        $('.langsearch').click();
    });   
    
  $('.snippets-search label').removeClass('active');
   
  $('.snippets-search input[checked]').parent().addClass('active');  
  
});

</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59295b40b71e9eab"></script> 
</body>
</html>
<?php $this->endPage() ?>
