<?php

namespace winwin\petClinic\admin\services;

use kuiper\helper\Arrays;
use winwin\support\exception\NotFoundException;

class MockAuthProvider implements AuthProviderInterface
{
    private static $USERS = [
        [
            'name' => 'admin',
            'password' => '123456',
            'avatar' => 'http://cdn.17gaoda.com/avatar/1.png',
        ],
    ];

    public function exists($username)
    {
        return $this->findUser($username) !== false;
    }

    public function verifyPassword($username, $password)
    {
        $user = $this->findUser($username);
        if (!$user) {
            return false;
        }

        return $user['password'] == $password;
    }

    public function getIdentity($username)
    {
        $user = $this->findUser($username);
        if ($user === false) {
            throw new NotFoundException("User '$username' does not exist");
        }

        return $user;
    }

    private function findUser($username)
    {
        $users = Arrays::assoc(self::$USERS, 'name');
        if (!isset($users[$username])) {
            return false;
        }

        return $users[$username];
    }
}
