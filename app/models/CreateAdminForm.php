<?php

namespace app\models;

use Exception;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class CreateAdminForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $kindergarten_id;

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username', 'kindergarten_id'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\Admin', 'message' => 'Это имя уже занято'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['kindergarten_id', 'integer'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\Admin', 'message' => 'Эта почта уже занята'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя Пользователя',
            'email' => 'Почта',
            'kindergarten_id' => 'Детский Сад',
            'password' => 'Пароль',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool|null whether the creating new account was successful and email was sent
     * @throws Exception
     */
    public function createUser():?bool
    {
        if ($this->validate()) {
            $user = new Admin();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->kindergarten_id = $this->kindergarten_id;

            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();

            /* Create role for user */
            $authManager = Yii::$app->authManager;
            $role = $authManager->getRole('admin');

            Yii::$app->session->setFlash('success', 'Аккаунт был создан. Проверте почту.');
            return $user->save() && $this->sendEmail($user) && Yii::$app->authManager->assign($role, $user->id);
        }
        Yii::$app->session->setFlash('danger', 'Такой аккаунт не может быть создан.');
        return false;
    }

    /**
     * Sends confirmation email to user
     * @param Admin $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
