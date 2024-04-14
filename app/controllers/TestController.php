<?php

namespace app\controllers;

use app\components\Controller;
use app\models\QuizizzSearch;
use app\models\TestForm;

class TestController extends Controller
{
    public function actionIndex(): string
    {
        $searchModel = new QuizizzSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id): string
    {
        $model = new TestForm();

        return $this->render('view', [
            'model' => $model,
            'id' => $id
        ]);
    }
}