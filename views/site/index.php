<?php

/* @var $this yii\web\View */

$this->title = 'Snippety[ ]';
?>
<div class="site-index row">
    <div class="col-xs-12">

        <h2>Go to the Snippets by clicking one of the tabs below!</h2>

    <div class="body-content row">
        
            <div class="col-md-10">
                <div class="row langrid">
                    <div class="col-xs-4">
                        <a href="?r=snippets%2Findex">
                        All
                        </a>
                    </div>            
                    <?php foreach ($languages as $lang){?>
                    <div class="col-xs-4">
                        <a href=<?php echo "?r=snippets%2Findex&SnippetsSearch%5Bid_language%5D=&SnippetsSearch%5Bid_language%5D=".$lang['id']."&SnippetsSearch%5B"; ?>>
                        <?php echo $lang['name']; ?>
                        </a>
                    </div>
                    <?php } ?>
                </div>
        </div>
            
        <div class="col-md-2">
            <h3>Top Snippets</h3>
            <ol class="rsnippet">
            <?php foreach ($top_snippets as $snip){?>
                        <li>
                        <a href=<?php echo "?r=snippets%2Fview&id=".$snip['id']; ?>>
                        <?php echo $snip['s_title']; ?>
                        </a>
                        <p>Rating: <?php echo $snip['countrating']; ?></p>
                        <p>By: <strong><?php echo $snip['username']; ?></strong></p>
                        </li>
            <?php } ?>
            </ol>
        </div>
        
    </div>
        
  </div>
</div>
