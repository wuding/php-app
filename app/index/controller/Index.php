<?php

namespace app\index\controller;

use app\index\view\Prototype;
use app\search\model\view\ShortcutKey;
use function php\func\{get, session};
use Pkg\Glob;

class Index extends \MagicCube\Controller
{
    public static function index()
    {
        //=s
        // 配置
        extract(Glob::conf('view'));
        // 查询
        extract(get(array('q')));
        // 会话
        $uid = session('user.id', 1);
        $login = session('user.name');
        // 模型
        $ShortcutKey = new ShortcutKey;
        // 其他
        $hour = date('H');
        $surplus = 24 - $hour;

        //=f
        $_SESSION['init'] = time();
        // 视图
        $login_link = '<a href="/user/login">登录</a>';
        if ($login) {
            $login_link = '<a href="/user/settings">设置</a>';
        }

        //=z
        $qh = htmlspecialchars($q);

        //=sh
        // 模型
        $all = $surplus ? $ShortcutKey->select('no, url, favicon, name', "user = '$uid'", 'id', $surplus) : array();
        // 视图
        $dl = Prototype::dl($all, $favicon_default);

        //=g
        return get_defined_vars();
    }
}
