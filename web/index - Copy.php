<?php

/*
续费
api app bin conf data docs
网费 话费 办公设备 域名 主机 服务

消费
example 学费

src[req cpu=route controller; resp gpu=template view; io=db mem disk net]
餐饮

temp test
出行

vendor 日用品

缴费
web func ext pkg
水 火 电 物业费

===============

docs example
牙膏 牙刷 文档笔记

data conf
太阳能 香皂 安装配置

bin web
洗面奶 剃须刀 命令行 服务器图形用户界面

app api
毛巾 面巾纸

---

src vendor
撒尿 拉屎

test temp
淋浴 泡澡

-----------

php sublime git composer
bool int double str

sql http
arr obj

html css
nul res

client script
res-closed unkown-type

==============

家(假) 有(邮) 对 像 是(试) 靓(醒) 妞溜达(起); ^_%s恰饭(吃) 出发(走) 就位(开发到了) 测试(就号) )-[#]发布(完_ 事已 失一) [@]午饭(了=尿 食饵 拾二) [$]午休(回 失散 驶私)
bool int double str arr obj nul           res  res-closed unkown-type gettype    settype  is      not

[http://user:pass@urlnk.com:1024/path/filename.extension?key=value&name=value#anchor:href;fragment:url]
帽子 眼镜:围巾/外套:手套@内衣:内裤/裤子?袜子=鞋垫#鞋
z j:j/t:t@n:n/z?z=x#x
q J:m/s:t@U:Z/s?p=#K

眼镜:
//内衣:内裤
#鞋

=============

phtmd jcsql
<?;!@# {[/*,-=&:.
动静纯标-地[址,文件] (编解[符号文字])客层(逗)服[内容]-查链[语言]

冬景蠢婊地=常记树形 可曾复查脸.变靓方法
别爱太满 别睡太晚

============
雨【水谷】雨 【白】露【寒】露 霜 【降小】雪【大】雪
bi ds a on


-----------
# develop week

10.13 寒露 8 霜降 23

1.1

购物 a o n SHopping + Spec 买卖
.store shop market stall cart City,street
.wang site,app Goods,category,BARCODE,coupon Brand Company,factory,address,tel
.kids man women

1.3 小寒 5
1.6

电影b 电视i 音乐d 图片s SCan 读写
.red  cinema ticket
movcd video movie tv live
.cc   audio music sound
.pics image camera + Storage[Sync]

--------- 动静
# test day|night

9.26 /白露 7 Q秋分 23

2.1

主域名 public protected [sb.]SEarch 主动被动
urlnk
urlnk.org + Site

-------- 虚实
# stage seasons

7.20 大暑 22 大树 答数 得数

1.9

软件应用 分享 SOft[System] + Share 实践
softcool.top soft app
.spa share

8.21 处暑 23 出书

社区 文档教程 [sns]SOcial + Screen 理论
.tips
.pub

---------
# product self

2.6 立春 3

# private SEx + S? 男女 俊男美女
zi[see.to]p

*/

error_reporting(E_ALL);

class App
{
    const VERSION = 25.0204;
    const REVISION = 1;

    static $properties = [
    ];

    var $property_hooks = [
        'get' => [
        ],
        'set' => [
        ],
    ];

    function __construct()
    {
        // print_r([__LINE__,__FUNCTION__]);
        $this->init();
    }

    function __destruct()
    {
        // print_r([__LINE__,__FUNCTION__]);
    }

    function __get($name)
    {

    }

    function __set($name, $value)
    {

    }

    function init()
    {
        // print_r([__LINE__,__FUNCTION__]);
        $err = [];
        $constants = [
            'ROOT' => dirname(__DIR__),
        ];
        foreach ($constants as $name => $value) {
            if (defined($name)) {
                $err[$name] = constant($name);
                continue;
            }
            define($name, $value);
        }

        $psr4 = [
            'Dew\\' => ROOT .'/src/dew/',#Route Temp
            'Frost\\' => ROOT .'/src/frost/',#Scheme
            'Snow\\' => ROOT .'/src/snow/',#Html
            'Ice\\' => ROOT .'/src/ice/',#Db
            'Func\\' => ROOT .'/src/func/',
            'Ext\\' => ROOT .'/src/ext/',
            'Pkg\\' => ROOT .'/src/pkg/',
        ];
        $autoload = $this->autoload();
        $a = [];
        foreach ($psr4 as $key => $value) {
            $a[] = $autoload->addPsr4($key, $value);
        }
        // var_dump($this->const());
    }

    function const()
    {
        return $a = [
            __DIR__,
            __FILE__,
            __LINE__,
            __CLASS__,
            __FUNCTION__,
            __TRAIT__,
            __NAMESPACE__,
            __METHOD__,
            // __PROPERTY__,
        ];

    }

    function run()
    {
        // print_r([__LINE__,__FUNCTION__]);
        $Vars = new Func\Vars;
        $Descent = new \Frost\Descent();
        $run = $Descent->run();
        // var_dump($run);

        $f = ROOT ."/app/search/src/template/index/index.php";
        $i = include $f;

        $t = ROOT ."/temp/post.txt";
        $p = include $t;
/*
        $Cls = new Ext\Cls;
        $g = $Cls->get_class([], $Vars);
        var_dump($g);
        die;
*/

/*
        $Var = new Ext\Vars;
        $gettype = $Var->gettype([], $t);
        // var_dump($gettype);
        // die;
*/
        print_r($_GET);
        $URL = new Ext\URL;
        $q = $_GET['q'] ?? null;
        $pu = $q ? $URL->parse_url([], $q) : null;
        var_dump($pu);
        die;

        print_r($_POST);
        $data = $_POST['s'] ?? null;
        $File = new Ext\File;
        $expression = $data ? $File->file_put_contents([], $t, $data) : null;
        var_dump($expression);
    }

    function ext()
    {
        $Err = new \Ext\Err;
        $variable = [
            0,
            E_ERROR | E_WARNING | E_PARSE,
            E_ERROR | E_WARNING | E_PARSE | E_NOTICE,
            E_ALL & ~E_NOTICE,
            E_ALL,
            -1
        ];
        $arr = [];
        foreach ($variable as $key => $value) {
            $arr[] = $Err->error_reporting([], $value);
        }
        var_dump($variable);
        var_dump($arr);
    }

    function autoload()
    {
        return require ROOT .'/vendor/autoload.php';
    }
}



$App = new App();
$run = $App->run();
