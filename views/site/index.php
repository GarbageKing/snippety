<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

        <h2>Go to the Snippets by clicking one of the tabs below!</h2>

    <div class="body-content">

        <div class="row">
            <?php foreach ($languages as $lang){?>
            <div class="col-lg-4">
                <a href=<?php echo "?r=snippets%2Findex&SnippetsSearch%5Bid_language%5D=&SnippetsSearch%5Bid_language%5D=".$lang['id']."&SnippetsSearch%5B"; ?>>
                <?php echo $lang['name']; ?>
                </a>
            </div>
            <?php } ?>
        </div>

    </div>
</div>
