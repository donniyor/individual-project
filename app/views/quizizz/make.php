<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Questions $question */
/** @var app\models\AnswerOptions $answer */
/** @var $id */

$this->title = 'Добавить вопросы';
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quizizz-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="make-question">
    </div>

    <?= Html::a('Добавить вопрос', Url::to(['question', 'id' => $id]), ['class' => 'btn btn-success ajax-add-question']) ?>

</div>