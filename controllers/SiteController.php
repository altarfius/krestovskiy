<?php

namespace app\controllers;

use app\models\Category;
use app\models\CategoryType;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
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

    public function actionGeneratehash()
    {
        $password = 'vsenotrusova';
        $hash = \Yii::$app->security->generatePasswordHash($password);
        echo $hash . ' is ' . \Yii::$app->security->validatePassword($password, $hash);
    }

    public function actionDate() {
        echo date(\DateTime::ISO8601);
    }
}
