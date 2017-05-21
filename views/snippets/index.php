<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SnippetsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Snippets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippets-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Snippets', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_language',
            'id_user',
            's_title',
            's_description',
            // 's_code',
            // 's_date',
            // 'is_public',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
