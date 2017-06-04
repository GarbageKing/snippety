<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comments */

$this->title = 'Update Comment: ';
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
