<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

use app\models\Languages;
use app\models\Snippetlikes;
use app\models\Users;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $languages = Languages::find()->all(); 
        
        $query = (new \yii\db\Query())
       ->select(['snippets.*', '(COUNT(case is_like when 1 then 1 else null end) - '
           . 'COUNT(case is_like when 0 then 1 else null end)) AS countrating, users.username from snippets'])
       ->join('LEFT JOIN', Snippetlikes::tableName(), 'snippetlikes.id_snippet = snippets.id')
       ->join('LEFT JOIN', Users::tableName(), 'users.id = snippets.id_user')
       ->where('snippets.is_public=1')
       ->groupBy('snippets.id')
       ->orderBy('countrating DESC')
       ->limit(10);       
        $ratedsnips = $query->all();
                
        return $this->render('index',
        ['languages' => $languages,
         'top_snippets' => $ratedsnips]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionMysnippets()
    {
        if(!Yii::$app->user->getId())
            return $this->redirect('?r=site/login');
        
        $query = (new \yii\db\Query())
       ->select('*')
       ->from('snippets')
       ->where('id_user='.Yii::$app->user->getId());         
        $snippets = $query->all();
        
        return $this->render('mysnippets', 
        ['snippets' => $snippets]);
    }
}
