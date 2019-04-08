<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\bootstrap\ActiveForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
		
		$model = new \app\models\LinkForm();

        return $this->render('index', [
            'model' => $model,
        ]);
    }
	
	/**
	 * Validates data from create link form located on main page
	 * 
	 * @return string
	 */
	public function actionCreatelinkvalidate() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$model=  new \app\models\LinkForm;
		
		$model->load(Yii::$app->request->post());
		
        
		return ActiveForm::validate($model);
	}
	
	
	/**
	 * Creates or loads link
	 * 
	 * @return string Return a string in JSON format
	 */
	public function actionCreatelink() {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$model=  new \app\models\LinkForm;
		
		//load and check if request contains post data for LinkForm model. If not, returns error
		if(!$model->load(Yii::$app->request->post())) {
			return [
				'message'=>'Post data error',
			];
		}
		
		//validating form data
		if($model->validate()) {
			//load link
			$link=$model->loadLink();
			
			if($link) {
				return [
					'message'=>'',
					'link'=>$link
				];
			} else {
				return [
					'message'=>'Something has happend on creating link',
				];
			}
			
		} else {
			return [
				'message'=>'Validation error',
			];
		}
		
	}
	
	/**
	 * Redirects to real link 
	 * 
	 * @param type $link Link parameter
	 * @return Response
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionRedirect($link) {
		$linkModel= \app\models\Link::find()->where(['link'=>$link])->one();
		if($linkModel) {
			return $this->redirect($linkModel->source_link);
		}
		
		throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
	}

    /**
     * Login action.
     *
     * @return Response|string
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

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
