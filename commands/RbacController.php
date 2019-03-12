<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

//        // добавляем разрешение "createPost"
//        $createPost = $auth->createPermission('createPost');
//        $createPost->description = 'Create a post';
//        $auth->add($createPost);
//
//        // добавляем разрешение "updatePost"
//        $updatePost = $auth->createPermission('updatePost');
//        $updatePost->description = 'Update post';
//        $auth->add($updatePost);

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

//        $createPost = $auth->createPermission('createPost');
//        $createPost->description = 'Create a post';
//        $auth->add($createPost);

//        // добавляем роль "admin" и даём роли разрешение "updatePost"
//        // а также все разрешения роли "author"
//        $admin = $auth->createRole('admin');
//        $auth->add($admin);
//        $auth->addChild($admin, $updatePost);
//        $auth->addChild($admin, $author);

//        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
//        // обычно реализуемый в модели User.
//        $auth->assign($author, 2);
//        $auth->assign($admin, 1);
    }
}