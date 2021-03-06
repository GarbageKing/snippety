<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Snippets */

$this->title = 'Update Snippets: ' . $model->s_title;
$this->params['breadcrumbs'][] = ['label' => 'Snippets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->s_title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="snippets-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages
    ]) ?>

</div>
