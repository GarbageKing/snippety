<?php

namespace app\controllers;

use Yii;
use app\models\Comments;
use app\models\CommentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentsController implements the CRUD actions for Comments model.
 */
class CommentsController extends Controller
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
     * Creates a new Comments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Comments();
        if ($model->load(Yii::$app->request->post())){
            $model->id_user = Yii::$app->user->getId();
            if($model->id_user == '')
                return $this->redirect('?r=site/login');
            
            $model->id_snippet = explode('id=', Yii::$app->request->referrer)[1];
            
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }        
    }

    /**
     * Updates an existing Comments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $exists = Comments::find()->where( [ 'id' => $id, 'id_user' => Yii::$app->user->getId() ] )->exists();
        if(!$exists)
            throw new NotFoundHttpException('The requested page does not exist.');
        
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
     * Deletes an existing Comments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $exists = Comments::find()->where( [ 'id' => $id, 'id_user' => Yii::$app->user->getId() ] )->exists();
        if(!$exists)
        throw new NotFoundHttpException('The requested page does not exist.');
        
        Yii::$app->db->createCommand()->delete('commentlikes', ['id_comment' => $id])->execute();
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Comments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Comments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
