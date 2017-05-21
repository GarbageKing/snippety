<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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

</div>
