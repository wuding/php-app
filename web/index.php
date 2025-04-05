<?php

/**/

namespace Fu;

error_reporting(E_ALL);

use function Func\{post, request, server};

class App
{
    const VERSION = 25.0204;
    const REVISION = 1;

    static $properties = [
        ''
    ];
    static $functions = [
    ];
    static $php_net = [
        'manual' => [
            'en' => [
            ],
        ],
    ];

    var $property_hooks = [
        'get' => [
        ],
        'set' => [
        ],
    ];

    function __construct()
    {
        $var = [#(object)
            '' => [
                'glue' => '.'
            ],
            'language' => [
                'constants' => [
                    '.php',
                    'magic' => [
                        '' => [
                            '<!DOCTYPE html>' => [
                                'h2' => 'Magic constants',
                                'th' => 'Name',
                                'td' => [
                                    '__LINE__' => __LINE__,
                                    '__FILE__' => __FILE__,
                                    '__DIR__' => __DIR__,
                                    '__FUNCTION__' => __FUNCTION__,
                                    '__CLASS__' => __CLASS__,
                                    '__TRAIT__' => __TRAIT__,
                                    '__METHOD__' => __METHOD__,
                                    '__PROPERTY__' => <<<'NOWDOC'

<br />
<b>Warning</b>:  Use of undefined constant __PROPERTY__ - assumed '__PROPERTY__' (this will throw an Error in a future version of PHP) in <b>J:\git\github.com\wuding\php-app\future\web\index.php</b> on line <b>53</b><br />
NOWDOC,
                                    '__NAMESPACE__' => __NAMESPACE__
                                ]
                            ],
                        ],
                        '.php',
                        '25.02101613' => [
                        ]
                    ],
                ],
            ],
        ];
        $array_push = array_push(self::$php_net['manual']['en'], $var);

        $runtime = [
            '__LINE__' => __LINE__,
            '__FILE__' => __FILE__,
            '__METHOD__' => __METHOD__,
        ];
        $this->const($runtime);

        $this->init();
    }

    function __destruct()
    {
        $runtime = [
            '__LINE__' => __LINE__,
            '__FILE__' => __FILE__,
            '__METHOD__' => __METHOD__,
        ];
        $this->const($runtime);
    }

    function __get($name)
    {

    }

    function __set($name, $value)
    {

    }

    function _sync()
    {

    }

    function _sign()
    {

    }

    function _sess()
    {

    }

    function init(&$orig = [])
    {
        $runtime = [
            '__LINE__' => __LINE__,
            '__FILE__' => __FILE__,
            '__METHOD__' => __METHOD__,
        ];
        $this->const($runtime);

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
            'Dew\\' => ROOT .'/src/dew/',
            'Frost\\' => ROOT .'/src/frost/',
            'Snow\\' => ROOT .'/src/snow/',
            'Ice\\' => ROOT .'/src/ice/',
            'Func\\' => ROOT .'/src/func/',
            'Ext\\' => ROOT .'/src/ext/',
            'Pkg\\' => ROOT .'/src/pkg/',
        ];
        $autoload = $this->autoload();
        $a = [];
        foreach ($psr4 as $key => $value) {
            $a[] = $autoload->addPsr4($key, $value);
        }
    }

    function const(&$orig = [])
    {
        $mt = microtime();
        // self::$php_net['manual']['en'][0]['language']['constants']['magic'][$mt] = $orig;
    }

    function run()
    {
        $runtime = ['__LINE__' => __LINE__, '__FILE__' => __FILE__, '__METHOD__' => __METHOD__];
        $this->const($runtime);#print_r(self::$php_net);
$orig = [
    'URI' => '',
    'METHOD' => '',
    'TIME' => '',
    'TIME_FLOAT' => '',
];
        $Vars = new \Func\Vars;#print_r(server('REQUEST_URI'));die;print_r(request($orig, 'URI'));
        $Descent = new \Frost\Descent();
        $script = 'index/index';
        $run = $Descent->run(server('REQUEST_URI'));#die;
        // var_dump($run);die;
        extract($run);

        unset($runtime, $orig, $Vars, $Descent, $run);
        $f = ROOT ."/app/search/src/template/$script.php";
        $i = include $f;
    }

    function autoload()
    {
        return require ROOT .'/vendor/autoload.php';
    }
}



$App = new App();
$run = $App->run();
