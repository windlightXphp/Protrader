<?php

namespace app\controllers;

use app\models\Message;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;


class SiteController extends Controller
{
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

    public function actionIndex()
    {
        $url = Yii::getAlias('@app') . '/web/data/data.txt';

        $messages = json_decode(file_get_contents($url), true);

        $model = new Message();//дя валидации формы

        return $this->render('index', [ //передаю во вьюху новый объкт massages
            'model' => $model,
            'messages' => $messages,
        ]);

    }

    public function actionSaveMasseges()
    {
        $message = $_POST['Message']['message'];

        $url = Yii::getAlias('@app') . '/web/data/data.txt';
        $time = time();
        //date('U')
        //time();
        $arr = [
            [
                'user_id' => '1',
                'messages' => $message,
                'created_at' => $time,
            ],
        ];

        $content = file_get_contents($url);

        if(empty($content)){
            file_put_contents($url, json_encode($arr));
        }else{

            $arr = json_decode($content, true);
            $arr[] = [
                'user_id' => '1',
                'messages' => $message,
                'created_at' => $time,
            ];
            file_put_contents($url, json_encode($arr));

        }
        return $this->redirect('/site/index');

    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
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

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

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

    public function actionAbout()
    {
        return $this->render('about');
    }
}










//        $a = [
//            0 => 1
//        ];
//        $a[] = 2;
//        var_dump($a);



//        {
//            [
//                "user_id" : "1",
//                "messages" : "ffgcfgcycvygvy",
//                "created_at" : "12312312313131"
//            ],
//            [
//                "user_id" : "1",
//                "messages" : "hjbhhjb",
//                "created_at" : "34"
//            ],
//        }




//        $arr = [
//            [
//                'user_id' => '1',
//                'messages' => 'ffgcfgcycvygvy',
//            ],
//            [
//                'user_id' => '21',
//                'messages' => 'fgdg',
//            ],
//        ];





//        echo '<pre>';
//        var_dump(json_encode($arr));die();

//        $str = '[{"user_id":"1","messages":"ffgcfgcycvygvy"},{"user_id":"21","messages":"fgdg"}]';
//
//        var_dump( json_decode($str, true) );die();

// записывать в текстовый файл в формате json