<?php

namespace app\controllers;

use app\components\Controller;
use app\models\ProblemSolving;
use app\models\Quizizz;
use app\models\QuizizzSearch;
use app\models\TestSolution;
use Yii;
use yii\web\Response;
use app\components\BaseBehaviors;

class TestController extends Controller
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

    public function actionView(int $id): string|Response
    {
        $model = new TestSolution();
        $quiz = Quizizz::find()->where(['id' => $id])->with(['questions', 'questions.answerOptions'])->one();

        if (TestSolution::find()->where(['user_id' => Yii::$app->getUser()->id, 'quiz_id' => $id])->count() === 0) {
            if (Yii::$app->request->isPost) {
                $model->quiz_id = $id;
                $model->user_id = Yii::$app->getUser()->id;
                $model->save();

                try {
                    foreach (Yii::$app->request->post()['AnswerOptions'] as $item) {
                        $problem_solving = new ProblemSolving();
                        $problem_solving->test_solution_id = $model->id;
                        $problem_solving->question_id = $item['question_id'];
                        $problem_solving->answer_id = $item['answer'];
                        $problem_solving->save();
                    }
                } catch (\Exception $exception) {
                }

                $this->flash('success', 'Данные успешно сохранены');
                return $this->redirect(['success']);
            }

            return $this->render('view', [
                'model' => $model,
                'quiz' => $quiz
            ]);
        }
        return $this->redirect(['success']);
    }

    public function actionSuccess(): string
    {
        return $this->render('success');
    }
}