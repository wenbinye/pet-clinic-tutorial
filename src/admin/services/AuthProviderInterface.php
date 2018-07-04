<?php

namespace winwin\petClinic\admin\services;

interface AuthProviderInterface
{
    /**
     * 检查用户名是否存在.
     *
     * @param string $username
     *
     * @return bool
     */
    public function exists($username);

    /**
     * 检查密码与用户名是否匹配.
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function verifyPassword($username, $password);

    /**
     * @param string $username
     *
     * @return array
     */
    public function getIdentity($username);
}
