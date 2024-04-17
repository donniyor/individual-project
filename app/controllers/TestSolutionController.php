<?php

namespace app\controllers;

use app\models\Quizizz;
use app\models\QuizizzSearch;
use app\components\Controller;
use app\models\TestSolution;
use app\components\BaseBehaviors;

class TestSolutionController extends Controller
{
    public function behaviors(): array
    {
        return BaseBehaviors::getBehaviors(['superAdmin', 'admin']);
    }

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
        return $this->render('view', [
            'quiz' => Quizizz::find()->where(['id' => $id])->with(['questions', 'questions.answerOptions'])->one(),
            'testSolution' => TestSolution::find()->where(['quiz_id' => $id])->all()
        ]);
    }
}
