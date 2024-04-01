<?php
namespace app\rules;

use yii\rbac\Rule;

class canCreateRule extends Rule
{
    public $name = 'canCreateRule';

    public function execute($user, $item, $params)
    {
        $myUserRoles = $params['myUserRoles'];
        $RoleToCreate = $params['RoleToCreate'];

        foreach ($myUserRoles as $myUserRole) {
            if(
                (
                    ($myUserRole->name === 'admin' && $RoleToCreate === 'moderator')
                    ||
                    ($myUserRole->name === 'superAdmin' && $RoleToCreate === 'admin')
                    ||
                    ($myUserRole->name === 'superAdmin' && $RoleToCreate === 'moderator')
                )
                &&
                ($RoleToCreate !== 'superAdmin')
            ) return true;
        }

        return false;
    }
}