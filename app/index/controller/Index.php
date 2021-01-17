<?php

namespace app\index\controller;

use function php\fn\{get, session};

class Index extends \MagicCube\Controller
{
    public static function index()
    {
        //=s
        $login = session('user.name');

        //=f
        $_SESSION['init'] = time();
        $login_link = '<a href="/user/login">登录</a>';
        if ($login) {
            $login_link = '<a href="/user/settings">设置</a>';
        }

        //=g
        return get_defined_vars();
    }
}
