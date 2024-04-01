<?php

namespace app\controllers;

//use app\models\SignupForm;
use app\models\Users;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\User;
use Yii;
use app\components\Controller;
use app\models\LoginForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;


class AuthController extends Controller
{
    public $layout = 'sign';

    public function actionIn()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionOut()
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->user->getReturnUrl(['/auth/in']));
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionVerifyEmail($token)
    {
        $user = Users::findByVerificationToken($token);
        $user->status = Users::STATUS_ACTIVE;
        $user->save();
        $this->flash('success', 'Вы успешно подтвердили свою почту.');
        return $this->render('VerifyEmail');
    }
}
