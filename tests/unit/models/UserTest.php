<?php

namespace tests\unit\models;

use app\models\Admin;

class UserTest extends \Codeception\Test\Unit
{
    public function testFindUserById()
    {
        verify($user = Admin::findIdentity(100))->notEmpty();
        verify($user->username)->equals('admin');

        verify(Admin::findIdentity(999))->empty();
    }

    public function testFindUserByAccessToken()
    {
        verify($user = Admin::findIdentityByAccessToken('100-token'))->notEmpty();
        verify($user->username)->equals('admin');

        verify(Admin::findIdentityByAccessToken('non-existing'))->empty();
    }

    public function testFindUserByUsername()
    {
        verify($user = Admin::findByUsername('admin'))->notEmpty();
        verify(Admin::findByUsername('not-admin'))->empty();
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = Admin::findByUsername('admin');
        verify($user->validateAuthKey('test100key'))->notEmpty();
        verify($user->validateAuthKey('test102key'))->empty();

        verify($user->validatePassword('admin'))->notEmpty();
        verify($user->validatePassword('123456'))->empty();        
    }

}
