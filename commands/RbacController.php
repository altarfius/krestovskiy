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

        // добавляем роль "author" и даём роли разрешение "createPost"
//        $admin = $auth->createRole('admin');
//        $auth->add($admin);

//        $supervisor = $auth->createRole('supervisor');
//        $auth->add($supervisor);

//        $auth->addChild($admin, $supervisor);

//        $manager = $auth->createRole('manager');
//        $auth->add($manager);
//
//        $auth->addChild($supervisor, $manager);

        $supervisor = $auth->getRole('supervisor');
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

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