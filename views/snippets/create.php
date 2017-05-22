<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Snippets */

$this->title = 'Create Snippets';
$this->params['breadcrumbs'][] = ['label' => 'Snippets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages        
    ]) ?>

</div>
