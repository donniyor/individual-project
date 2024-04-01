<?php
namespace app\controllers;

use Yii;
use app\components\Controller;


class ImageController extends Controller
{
    public function actionIndex($name): string
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('content-type', Yii::$app->minio->getMimetype($name));
        return Yii::$app->minio->read($name);
    }
}
