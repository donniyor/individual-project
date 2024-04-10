<?php

namespace app\controllers;

use app\models\AnswerOptions;
use app\models\Questions;
use app\models\Quizizz;
use app\models\QuizizzSearch;
use Throwable;
use Yii;
use app\components\Controller;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class QuizizzController extends Controller
{
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
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

    public function actionCreate(): string|Response
    {
        $model = new Quizizz();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id): string|Response
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['make', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Quizizz
    {
        if (($model = Quizizz::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMake(int $id): string
    {
        return $this->render('make', [
            'quiz' => Quizizz::find()->where(['id' => $id])->with('questions')->one(),
            'question' => new Questions,
            'answer' => new AnswerOptions(),
            'id' => $id
        ]);
    }

    public function actionSaveQuestion(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $model = $id !== null ? Questions::findOne($id) : new Questions();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ['success' => true, 'id' => $model->id];
        }

        return ['success' => false, 'errors' => $model->getErrors()];
    }

    public function actionSaveAnswer(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $model = $id !== null ? AnswerOptions::findOne($id) : new AnswerOptions;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ['success' => true, 'id' => $model->id];
        }

        return ['success' => false, 'errors' => $model->getErrors()];
    }

    public function actionQuestion(int $id): string
    {
        return $this->renderPartial('question', [
            'question' => new Questions(),
            'id' => $id
        ]);
    }

    public function actionAnswer()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->renderPartial('answer', [
            'answer' => new AnswerOptions(),
            'id' => Yii::$app->request->post('id')
        ]);
    }
}
