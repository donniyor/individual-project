<?php

namespace app\models;

use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_repeat;

    /**
     * @var \app\models\Users
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = Users::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required', 'on' => 'update'],
            ['password', 'string', 'min' => 6], // Yii::$app->params['user.passwordMinLength']

            ['password_repeat', 'required', 'on' => 'update'],
            ['password_repeat', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        $user->generateAuthKey();

        return $user->save(false);
    }
}
