<?php

if (! function_exists('getRolePermissionUsersId')) {
    /**
     * Get the unique user IDs that have the specified roles or permissions.
     *
     * @return array
     */
    function getRolePermissionUsersId(mixed $roles, mixed $permissions)
    {
        $aduser = Sebastienheyd\Boilerplate\Models\User::whereHasRole($roles)->get('id')->pluck('id')->toArray();
        $permissionuser = Sebastienheyd\Boilerplate\Models\User::whereHasPermission($permissions)->get('id')->pluck('id')->toArray();

        return array_unique(array_merge($aduser, $permissionuser));
    }
}
