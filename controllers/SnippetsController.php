<?php

namespace app\controllers;

use Yii;
use app\models\Snippets;
use app\models\SnippetsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Languages;

use app\models\Comments;
use app\models\Snippetlikes;
use app\models\Commentlikes;
use app\models\Users;

/**
 * SnippetsController implements the CRUD actions for Snippets model.
 */
class SnippetsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Snippets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SnippetsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Snippets model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        $exists = Snippets::find()->where( [ 'id' => $id, 'is_public' => 1 ] )->exists();
        $exists2 = Snippets::find()->where( [ 'id' => $id, 'id_user' => Yii::$app->user->getId() ] )->exists();
        
        if(!$exists && !$exists2)
            throw new NotFoundHttpException('The requested page does not exist.');
        
        $model2 = new Comments();
        
        $query = (new \yii\db\Query())
       ->select(['comments.*', 'COUNT(case is_like when 1 then 1 else null end) AS countlike, '
           . 'COUNT(case is_like when 0 then 1 else null end) AS countdislike, users.username from comments'])
       ->join('LEFT JOIN', Commentlikes::tableName(), 'commentlikes.id_comment = comments.id')
       ->join('LEFT JOIN', Users::tableName(), 'users.id = comments.id_user')
       ->where('comments.id_snippet='.$id)
       ->groupBy('comments.id');       
        $comments = $query->all();
        
        $model3 = new Snippetlikes();
        
        $snippetlikes = Snippetlikes::find()->where(['id_snippet' => $id, 'is_like' => 1])->all();
        $snippetlikes = count($snippetlikes);
        
        $snippetdislikes = Snippetlikes::find()->where(['id_snippet' => $id, 'is_like' => 0])->all();
        $snippetdislikes = count($snippetdislikes);
        
        $usersnippet = Users::find()->where(['id' => $this->findModel($id)->id_user])->one()['username'];
                
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model2' => $model2,
            'comments' => $comments,
            'model3' => $model3,
            'snippetlikes' => $snippetlikes,
            'snippetdislikes' => $snippetdislikes,              
            'user' => $usersnippet,
        ]);
    }

    /**
     * Creates a new Snippets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->getId())
            return $this->redirect('?r=site/login');
        
        $model = new Snippets();        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
                  
            return $this->render('create', [
                'model' => $model,
                'languages' => Languages::find()->all()                
            ]);
        }
    }

    /**
     * Updates an existing Snippets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {      
        $exists = Snippets::find()->where( [ 'id' => $id, 'id_user' => Yii::$app->user->getId() ] )->exists();
        if(!$exists)
            throw new NotFoundHttpException('The requested page does not exist.');
        
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'languages' => Languages::find()->all()
            ]);
        }
    }

    /**
     * Deletes an existing Snippets model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        $exists = Snippets::find()->where( [ 'id' => $id, 'id_user' => Yii::$app->user->getId() ] )->exists();
        if(!$exists)
            throw new NotFoundHttpException('The requested page does not exist.');
        
        $Comments = Comments::find()->where(['id_snippet' => $id])->all();
        
        foreach ($Comments as $comment)
        {
            Yii::$app->db->createCommand()->delete('commentlikes', ['id_comment' => $comment['id']])->execute();       
            
            Yii::$app->db->createCommand()->delete('comments', ['id' => $comment['id']])->execute();
        }
        
        Yii::$app->db->createCommand()->delete('snippetlikes', ['id_snippet' => $id])->execute();        
                 
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    public function actionLike($id, $is_like)
    {
        if(!Yii::$app->user->getId())
            return $this->redirect('?r=site/login');
        
        $exists = Snippetlikes::find()->where(['id_snippet' => $id, 'id_user' => Yii::$app->user->getId()])->all();
        
        if($exists)
        {
            $uid = Yii::$app->user->getId();
            Yii::$app->db->createCommand()->update('snippetlikes', ['id_snippet' => $id,
                'id_user' => $uid, 'is_like' => $is_like], "id_snippet=$id and id_user=$uid")->execute();            
        }
        else
        {
            Yii::$app->db->createCommand()->insert('snippetlikes', ['id_snippet' => $id,
                'id_user' => Yii::$app->user->getId(), 'is_like' => $is_like])->execute();
        }
        
        return $this->redirect(['view', 'id' => $id]); 
        
    }
    
    public function actionCommentlike($id, $is_like)
    {
        if(!Yii::$app->user->getId())
            return $this->redirect('?r=site/login');
        
        $exists = Commentlikes::find()->where(['id_comment' => $id, 'id_user' => Yii::$app->user->getId()])->all();
        
        if($exists)
        {
            $uid = Yii::$app->user->getId();
            Yii::$app->db->createCommand()->update('commentlikes', ['id_comment' => $id,
                'id_user' => $uid, 'is_like' => $is_like], "id_comment=$id and id_user=$uid")->execute();
        }
        else
        {
            Yii::$app->db->createCommand()->insert('commentlikes', ['id_comment' => $id,
                'id_user' => Yii::$app->user->getId(), 'is_like' => $is_like])->execute();
        }
        
        return $this->redirect(Yii::$app->request->referrer); 
        
    }    

    /**
     * Finds the Snippets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Snippets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {        
        if (($model = Snippets::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
