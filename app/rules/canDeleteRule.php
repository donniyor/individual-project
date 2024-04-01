<?php
namespace app\rules;

use yii\rbac\Rule;

class canDeleteRule extends Rule
{
    public $name = 'canDeleteRule';

    public function execute($user, $item, $params): bool
    {
        $myUserRoles = $params['myUserRoles'];
        $usersToDelete = $params['usersToDelete'];

        if(empty($usersToDelete)) return true;

        foreach ($myUserRoles as $myUserRole) {
            foreach ($usersToDelete as $userToDelete){
                if(
                    ($myUserRole->name === 'superAdmin' && $userToDelete->name !== 'superAdmin')
                    ||
                    ($myUserRole->name === 'admin' && $userToDelete->name === 'moderator')
                ) return true;
            }
        }

        return false;
    }
}