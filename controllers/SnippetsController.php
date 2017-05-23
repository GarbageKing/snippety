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
        $model2 = new Comments();
        
        //$comments = Comments::find()->leftJoin('commentlikes', 'commentlikes.id_comment = comments.id')->where(['id_snippet' => $id])->all(); 
        //$comments = Comments::find()->where(['id_snippet' => $id])->all();
                
        /*$likedislike = [];
        foreach($comments as $comment)
        {
            $commentlikes = Commentlikes::find()->where(['id_comment' => $comment['id'], 'is_like' => 1])->all();
            $countlikes = count($commentlikes);
            $likedislike['likes'][] = $countlikes;
            
            $commentdislikes = Commentlikes::find()->where(['id_comment' => $comment['id'], 'is_like' => 0])->all();
            $countdislikes = count($commentdislikes);
            $likedislike['dislikes'][] = $countdislikes;
        }*/
        
        $query = (new \yii\db\Query())
       ->select(['comments.*', 'COUNT(case is_like when 1 then 1 else null end) AS countlike, '
           . 'COUNT(case is_like when 0 then 1 else null end) AS countdislike from comments'])
       ->join('LEFT JOIN', Commentlikes::tableName(), 'commentlikes.id_comment = comments.id')
       ->where('comments.id_snippet='.$id)
       ->groupBy('comments.id');       
        $comments = $query->all();
        
        //print_r($comments);die;        
                
        $model3 = new Snippetlikes();
        
        $snippetlikes = Snippetlikes::find()->where(['id_snippet' => $id, 'is_like' => 1])->all();
        $snippetlikes = count($snippetlikes);
        
        $snippetdislikes = Snippetlikes::find()->where(['id_snippet' => $id, 'is_like' => 0])->all();
        $snippetdislikes = count($snippetdislikes);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model2' => $model2,
            'comments' => $comments,
            'model3' => $model3,
            'snippetlikes' => $snippetlikes,
            'snippetdislikes' => $snippetdislikes,            
        ]);
    }

    /**
     * Creates a new Snippets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    public function actionLike($id, $is_like)
    {
        //$model = new Snippetlikes();
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
        //$model = new Snippetlikes();
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
