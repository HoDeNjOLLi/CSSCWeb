<?php
/**
 * Created by PhpStorm.
 * User: hojoe
 * Date: 10.01.2018
 * Time: 13:07
 */

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class User
{
    private $username;
    private $permissions;
    private $isAuthenticated;

    function __construct()
    {
        $this->isAuthenticated = false;
        $this->username = null;
        // rights for anon user
        $this->permissions = $this->anonPermissions();
    }

    static function getFromSession($container, Session $session)
    {
        $user = new User();
        $username = $session->get('username');
        if ($username) {
            $userModel = new Model($container['dbConnection']);
            $userData = $userModel->getUser($username);
            if ($userData) {
                $user->username = $username;
                $user->isAuthenticated = true;
                $user->permissions = $userModel->getPermissions($username);
            }
        }
        return $user;
    }

    function getUsername()
    {
        return $this->username;
    }

    function isAuthenticated()
    {
        return $this->isAuthenticated;
    }

    function hasPermission($permission)
    {
        return (array_search($permission, $this->permissions) !== false);
    }

    function anonPermissions()
    {
        return ['view cases'];
    }

    function logout(Request $request)
    {
        $session = $request->getSession();
        $session->remove('username');

        $this->username = null;
        $this->isAuthenticated = false;
        $this->permissions = $this->anonPermissions();
    }
}