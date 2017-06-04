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
<div class="row snippets-index">

    <div class="col-xs-12"><h1><?= Html::encode($this->title) ?></h1></div>
  
    <div class="col-md-10">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,  
        'layout' => "{summary}\n{items}\n<div align='center'>{pager}</div>",
        'columns' => [
                   
            [
                      'label' => 'Language',
                      'attribute' => 'id_language',                        
                      'value' => 'idLanguage.name',                      
            ],
            
            's_title',               
            [
                'attribute' => 's_description',
                'value'     => function ($model) {
                if(mb_strlen($model->s_description)>50)
                return mb_substr($model->s_description, 0, 50).'...';
                return $model->s_description;
                }
            ],
            's_date',
            [
                      'label' => 'User',
                      'attribute' => 'id_user',                        
                      'value' => 'idUser.username',                      
            ],     
          
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

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>
    </div>
    <div class="col-md-2 ">
    <?= $this->render('_search', ['model' => $searchModel]) ?>
    <p style="margin-top:50px;">
        <?= Html::a('Create Snippets', ['create'], ['class' => 'btn btn-default']) ?>
    </p>
    </div>
</div>
