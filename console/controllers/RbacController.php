<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Create roles
        $user = $auth->createRole('user');
        $admin = $auth->createRole('admin');

        //Create permissions
        $simpleTranslate = $auth->createPermission('simpleTranslate');
        $simpleTranslate->description = 'Simple translate';
        $createVocabulary = $auth->createPermission('createVocabulary');
        $createVocabulary->description = 'Create Vocabulary';
        $editVocabulary = $auth->createPermission('editVocabulary');
        $editVocabulary->description = 'Edit Vocabulary';

        //Add permissions
        $auth->add($simpleTranslate);
        $auth->add($createVocabulary);
        $auth->add($editVocabulary);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $auth->add($user);
        //$auth->addChild($author, $createPost);
        $auth->addChild($user, $simpleTranslate);
        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $auth->add($admin);
        //$auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $createVocabulary);
        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.

        $rule = new AuthorRule();
        $auth->add($rule);
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

        // "updateOwnPost" будет использоваться из "updatePost"
        $auth->addChild($updateOwnPost, $editVocabulary);

        // разрешаем "автору" обновлять его посты
        $auth->addChild($user, $updateOwnPost);

        $auth->assign($admin, 1);
        $auth->assign($user, 2);
    }
}