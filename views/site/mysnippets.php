<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'My Snippets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-snippets">
    <div class="row">
        <div class="col-md-10">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-md-2" style="margin-top:50px;">   
            <?= Html::a('Create Snippets', ['create'], ['class' => 'btn btn-default']) ?>       
        </div>
    </div>
    
   <div class="row">  
    <div class="col-md-12">
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
            [             
             'label' => 'Comments',
             'attribute'=>'commentsCount',
             'value' => 'commentsCount',
            ],            
            [             
             'label' => 'Rating',
             'attribute'=>'snippetLikesCount',
             'value' => 'snippetLikesCount',
            ],

            ['class' => 'yii\grid\ActionColumn',
                
                'template' => '{snippetView} {snippetUpdate} {snippetDelete}',
                
                'buttons'  => [
    'snippetView'   => function ($url, $model) {
        $url = Url::to(['snippets/view', 'id' => $model->id]);
        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => 'view']);
    },
    'snippetUpdate' => function ($url, $model) {
        $url = Url::to(['snippets/update', 'id' => $model->id]);
        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => 'update']);
    },
    'snippetDelete' => function ($url, $model) {
        $url = Url::to(['snippets/delete', 'id' => $model->id]);
        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
            'title'        => 'delete',
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method'  => 'post',
        ]);
    },  
                
                
                ],
                ],
        ],
    ]); ?>
    </div>
               
   </div>     
        
</div>
