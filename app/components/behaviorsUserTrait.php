<?php

namespace app\components;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

trait behaviorsUserTrait
{
    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['superAdmin', 'admin'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return \Yii::$app->response->redirect(['/auth/in']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
}