<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $admin = $auth->createRole('admin');
        $supervisor = $auth->createRole('supervisor');
        $manager = $auth->createRole('manager');

        $auth->add($admin);
        $auth->add($supervisor);
        $auth->add($manager);

        $auth->addChild($admin, $supervisor);
        $auth->addChild($supervisor, $manager);

        $auth->assign($supervisor, 1);
        $auth->assign($supervisor, 5);
        $auth->assign($supervisor, 6);
        $auth->assign($manager, 7);
        $auth->assign($manager, 10);
        $auth->assign($manager, 11);
        $auth->assign($manager, 12);

    }
}