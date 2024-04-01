<?php

namespace app\commands;

use app\models\Admin;
use app\rules\canCreateRule;
use app\rules\canDeleteRule;
use Yii;
use yii\console\Controller;

class MyRbacController extends Controller
{
    public function actionIndex()
    {

        $auth = Yii::$app->authManager;
        $auth->removeAll();
        Admin::deleteAll();

        /* new user */
        $superAdmin = new Admin();
        $superAdmin->username = 'superAdmin';
        $superAdmin->email = 'superAdmin@mail.ru';
        $superAdmin->setPassword('superAdmin');
        $superAdmin->generateAuthKey();
        $superAdmin->save();

        /* permissions */
        $canSuperAdmin = $auth->createPermission('canSuperAdmin');
        $auth->add($canSuperAdmin);
        $canAdmin = $auth->createPermission('canAdmin');
        $auth->add($canAdmin);

        /* Users */
        $superAdminRole = $auth->createRole('superAdmin');
        $auth->add($superAdminRole);
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);

        $auth->addChild($superAdminRole, $canSuperAdmin);
        $auth->addChild($superAdminRole, $canAdmin);
        $auth->addChild($adminRole, $canAdmin);

        $auth->assign($superAdminRole, $superAdmin->id);

        print("\nAll correct!\n");
    }
}