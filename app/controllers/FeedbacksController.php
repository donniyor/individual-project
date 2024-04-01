<?php

namespace app\controllers;

use app\components\behaviorsSuperAdminTrait;
use app\models\Feedbacks;
use app\models\FeedbacksSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * FeedbacksController implements the CRUD actions for Feedbacks model.
 */
class FeedbacksController extends Controller
{
    use behaviorsSuperAdminTrait;

    /**
     * Lists all Feedbacks models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FeedbacksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Feedbacks model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Feedbacks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Feedbacks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feedbacks::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
