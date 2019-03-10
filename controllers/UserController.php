<?php
/**
 * Created by PhpStorm.
 * User: altar
 * Date: 06.03.2019
 * Time: 9:37
 */

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = new User();
        if ($user->load(Yii::$app->request->post()) && $user->login()) {
            Yii::$app->session->setFlash('info', 'Добро пожаловать, ' . Yii::$app->user->identity->name . '!');
            return $this->goBack();
        }

        return $this->render('signin', [
            'user' => $user,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}