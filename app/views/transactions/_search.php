<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TransactionsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="transactions-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?=$form->field($model, 'created_at', ['inputOptions' => ['class' => 'date-changer form-control']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary my-3']) ?>
        <?= Html::a('Сбросить', Url::to('/transactions?TransactionsSearch[payment_status]=SUCCESS'), ['class' => 'btn btn-outline-secondary my-3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
