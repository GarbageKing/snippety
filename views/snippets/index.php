<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Languages;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SnippetsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Snippets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippets-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="col-md-10">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
                             
            [
                      'label' => 'Language',
                      'attribute' => 'id_language',                        
                      'value' => 'idLanguage.name',
                      //'filter'=>ArrayHelper::map(Languages::find()->asArray()->all(), 'id', 'name'),
            ],
            
            's_title',
            's_description',            
            's_date',
            

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>
    </div>
    <div class="col-md-2 ">
    <?= $this->render('_search', ['model' => $searchModel]) ?>
    <p style="margin-top:50px;">
        <?= Html::a('Create Snippets', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    </div>
</div>
