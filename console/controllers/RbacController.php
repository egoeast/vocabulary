<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $simpleTranslate = $auth->createPermission('simpleTranslate');
        $simpleTranslate->description = 'Simple translate';
        $auth->add($simpleTranslate);

        $createVocabulary = $auth->createPermission('createVocabulary');
        $createVocabulary->description = 'Create Vocabulary';
        $auth->add($createVocabulary);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $user = $auth->createRole('user');
        $auth->add($user);
        //$auth->addChild($author, $createPost);
        $auth->addChild($user, $simpleTranslate);
        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        //$auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $createVocabulary);
        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($admin, 1);
        $auth->assign($user, 2);
    }
}