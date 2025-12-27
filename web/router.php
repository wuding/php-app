<?php
// version 251215.1

// $path = $_SERVER["SCRIPT_FILENAME"];

// file_put_contents("php://stdout", "Requested: $path\n");
// echo "<p>Hello World</p>";
// return false;

namespace phoenix\web;

class Router
{
    // verb
    const BUILD = 202512151025;
    const EDTION = 0.19;
    const REVISION = 1;
    const VERSION = 25.1228;

    static $count = 0;
    static $objects = [
        'controller' => null,
    ];

    function __construct()
    {
        $init = self::init();
        // var_dump([__LINE__, __METHOD__, get_defined_vars()]);
    }

    function __destruct()
    {
        // var_dump([__LINE__, __METHOD__, get_included_files()]);
    }

    static function autoload($filename = null)
    {
        $filename = $filename ?: ROOT .'/vendor/autoload.php';
        $require = require $filename;
        return $require;
    }

    static function cookie($value = null, $expires = null)
    {
        $expires = $expires ?: time() + 86400 * 36525;
        $name = 'INIT';
        $cookie = $_COOKIE[$name] ?? null;
        $options = [
            'expires' => $expires,
            'path' => '/',
            'domain' => 'fu_app',
            'secure' => false,
            'httponly' => true,
        ];
        $setcookie = $cookie ?: setcookie($name, $value, $options);
        return $setcookie;
    }

    static function _trim_and_explode($var_array, $str = null)
    {
        $characters = $delimiter = '/';
        extract($var_array);

        $trim = trim($str, $characters);
        return $explode = explode($delimiter, $string = $trim);
    }

    static function _preg_replace_multiple_slashes_with_one($array, $subject = null)
    {
        $pattern = "#[/]+#";
        $replacement = '/';
        extract($array);

        return $preg_replace = preg_replace($pattern, $replacement, $subject);
    }

    static function _foreach_if_array_shift($var_array, $variable = [])
    {
        $i = 0;
        $arr = [
            'index',
            'index',
            'index',
            null,
        ];
        $array_from_variable = $variable;
        extract($var_array);

        foreach ($variable as $key => $value) {
            if (2 < $i) {
                break;
            }

            $arr[$key] = $value ?: 'index';
            $i++;
            array_shift($array_from_variable);
        }
        return [
            'array_from_variable'=> $array_from_variable,
            'arr'=> $arr
        ];
        print_r(get_defined_vars());
    }

    static function map($var_array)
    {
        $subject = null;
        extract($var_array);

        $_preg_replace_multiple_slashes_with_one = self::_preg_replace_multiple_slashes_with_one([], $subject);
        $_trim_and_explode = self::_trim_and_explode([], $_preg_replace_multiple_slashes_with_one);
        $_foreach_if_array_shift = self::_foreach_if_array_shift([], $_trim_and_explode);
        return $_list_if= self::_list_if($_foreach_if_array_shift);
        print_r(get_defined_vars());
        die;
    }

    static function _list_if($var_array, $arr = [], $array_from_variable = [])
    {
        extract($var_array);

        list($m, $c, $a, $p) = $arr;
        if (!$p) {
            $p = $array_from_variable;
        }

        $map = [
            [$m, $c, $a, $p],
            [$m, 'index', $c, $a],
            ['index', $m, $c, $a],
            ['index', 'index', $m, $c],
        ];
        return [
            'arr' => $arr,
            'map' => $map
        ];
    }

    static function map_v1($array)
    {
        $subject = null;
        extract($array);

        $pattern = "#[/]+#";
        $replacement = '/';
        $str = preg_replace($pattern, $replacement, $subject);
        $trim = trim($str, '/');
        $explode = explode('/', $trim);
        $clone = $explode;

        $arr = [
            'index',
            'index',
            'index',
            null,
        ];
        $i = 0;
        foreach ($explode as $key => $value) {
            if (2 < $i) {
                break;
            }
            $arr[$key] = $value ?: 'index';
            $i++;
            array_shift($clone);
        }
        list($m, $c, $a, $p) = $arr;
        if (!$p) {
            $p = $clone;
        }

        $map = [
            [$m, $c, $a, $p],
            [$m, 'index', $c, $a],
            ['index', $m, $c, $a],
            ['index', 'index', $m, $c],
        ];
        return [
            'arr' => $arr,
            'map' => $map
        ];
    }

    static function _str_replace($var_array, $module = null, $controller = null)
    {
        $search = [
            '{m}',
            '{c}',
        ];
        $replace = [
            $module,
            ucfirst($controller),
        ];
        $ns = 'app\{m}\src\controller\{c}';
        extract($var_array);

        $str_replace = str_replace($search, $replace, $ns, $count);

        return $values= [
            'str_replace' => $str_replace,
            'count' => $count
        ];
    }

    static function _class_exists_if($var_array, $map =null, &$class_exists =null, $subject =null)
    {
        $params = $str_replace = $action = null;
        extract($var_array);

        $class_exists[$str_replace] = $class_exist = class_exists($str_replace);
        if ($class_exist) {
            $array = [
                'map' => $map,
                'class_exists' => $class_exists,
                'class_exist' => $class_exist,
                'subject' => $subject,
                'params' => $params,
                'str_replace' => $str_replace,
                'action' => $action,
            ];
            return $array;
        }
    }

    static function foreach($var_array)
    {
        extract($var_array);

        $class_exists = [];
        foreach ($map as $key => $value) {
            list($module, $controller, $action, $params) = $value;
/*            $search = [
                '{m}',
                '{c}',
            ];
            $replace = [
                $module,
                ucfirst($controller),
            ];
            $ns = 'app\{m}\src\controller\{c}';
            $str_replace = str_replace($search, $replace, $ns, $count);
*/
            $_str_replace = self::_str_replace([], $module, $controller);
            extract($_str_replace);

            $var_arr = [
                'params'=> $params,
                'str_replace'=> $str_replace,
                'action'=> $action
            ];
            return $_class_exists_if = self::_class_exists_if($var_arr, $map, $class_exists, $subject);
            var_dump([__LINE__, __METHOD__, get_defined_vars()]);die;

/*            $class_exists[$str_replace] = $class_exist = class_exists($str_replace);
            if ($class_exist) {
                $array = [
                    'map' => $map,
                    'class_exists' => $class_exists,
                    'class_exist' => $class_exist,
                    'subject' => $subject,
                    'params' => $params,
                    'str_replace' => $str_replace,
                    'action' => $action,
                ];
                return $array;
                // self::new($array);
            }*/
        }

        return false;

        echo "<pre>";
        var_dump([__LINE__, __METHOD__, get_defined_vars()]);
        echo "</pre>";
        die;
    }

    static function new($var_array)
    {
        // define
        $map = $class_exists = $class_exist = $subject = $params = $str_replace = $action = null;
        // implement
        extract($var_array);

        // integrate
        $args = [
            'count' => self::$count++,
            'from' => __METHOD__,
            'uri' => $subject,
            'map' => $map,
            'class_exists' => $class_exists,
        ];

        $array = $args;
        $array['count'] = self::$count++;
        $array['params'] = $params;

        self::$objects['controller'] = $obj = new $str_replace($args);
        $array['result'] = $obj->$action($array);
        // $result = $obj->$action($params);

        // connect
        return $array;
        self::template($array, $string = $obj::$script);
    }

    static function dispatch($subject)
    {
        $map = self::map(get_defined_vars());
        $map['subject'] = $subject;
        $array = self::foreach($map);
        if (is_bool($array)) {
            echo "<pre>";
            var_dump([__LINE__, __METHOD__, get_defined_vars()]);
            echo "</pre>";
            die;
        }
        $new = self::new($array);
        $new['pre'] = json_encode(get_defined_vars(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // connect
        $obj = self::$objects['controller'];
        self::template($new, $string = $obj::$script);

        if (!$array['class_exists']) {
            echo "<pre>";
            var_dump([__LINE__, __METHOD__, get_defined_vars()]);
            echo "</pre>";
            die;
        }
        return [
            'info' => $map['arr'],
            'class' => $array['str_replace'],
        ];
    }

    static function dispatch_v1($subject)
    {
        $pattern = "#[/]+#";
        $replacement = '/';
        $str = preg_replace($pattern, $replacement, $subject);
        $trim = trim($str, '/');
        $explode = explode('/', $trim);
        $clone = $explode;
        $arr = [
            'index',
            'index',
            'index',
            null,
        ];
        $i = 0;
        foreach ($explode as $key => $value) {
            if (2 < $i) {
                break;
            }
            $arr[$key] = $value ?: 'index';
            $i++;
            array_shift($clone);
        }
        list($m, $c, $a, $p) = $arr;
        if (!$p) {
            $p = $clone;
        }

        $map = [
            [$m, $c, $a, $p],
            [$m, 'index', $c, $a],
            ['index', $m, $c, $a],
            ['index', 'index', $m, $c],
        ];

        $class_exists = [];
        foreach ($map as $key => $value) {
            list($module, $controller, $action, $params) = $value;
            $search = [
                '{m}',
                '{c}',
            ];
            $replace = [
                $module,
                ucfirst($controller),
            ];
            $ns = 'app\{m}\src\controller\{c}';
            $str_replace = str_replace($search, $replace, $ns, $count);
            $class_exists[$str_replace] = $class_exist = class_exists($str_replace);
            if ($class_exist) {
                $args = [
                    'count' => self::$count++,
                    'from' => __METHOD__,
                    'uri' => $subject,
                    'map' => $map,
                    'class_exists' => $class_exists,
                ];

                $array = $args;
                $array['count'] = self::$count++;
                $array['params'] = $params;

                $obj = new $str_replace($args);
                $result = $obj->$action($array);
                // $result = $obj->$action($params);

                $array = [
                    'pre' => json_encode(get_defined_vars(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ];
                $template= self::template($array, $string = $obj::$script);
                print_r($template);
                die;
                break;
            }
        }


        if (!$class_exists) {
            echo "<pre>";
            var_dump([__LINE__, __METHOD__, get_defined_vars()]);
            echo "</pre>";
            die;
        }
        return [
            'info' => $arr,
            'class' => $str_replace,
        ];
    }

    static function init()
    {
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
        $autoload = self::autoload();
        $a = [];
        foreach ($psr4 as $key => $value) {
            $a[] = $autoload->addPsr4($key, $value);
        }
        return $err;
    }

    static function run()
    {
        ksort($_SERVER);
        $value = md5(json_encode($_SERVER));
        $cookie = self::cookie($value);
        self::session();
        $str = $cookie .' '. $_SERVER['REQUEST_TIME_FLOAT'] .' '. $_SERVER['REMOTE_ADDR'] .':'. $_SERVER['REMOTE_PORT'];
        $str .= ' '. $_SERVER['REQUEST_METHOD'] .' '. $_SERVER['REQUEST_URI'];
        file_put_contents("php://stdout", "\n$str\n\n");
        // unset($str);
        // print_r([__LINE__, __METHOD__, $GLOBALS]);
        $dispatch = self::dispatch($_SERVER['REQUEST_URI']);
        die;

        $class = "app\user\src\controller\Index";
        $class = $dispatch['class'];
        $obj = new $class;
        $action = 'login';
        $action = $dispatch['info'][2];
        $function = [$obj, $action];
        $param_arr = [];
        return $res = call_user_func_array($function, $param_arr);
    }

    static function session()
    {
        $name = 'INIT';
        session_name($name);
        session_start();
    }

    static function template($array = [], $string = null)
    {

        ob_start();
        $include = include $string;
        $ogc = ob_get_contents();
        ob_end_clean();

        unset($array);
        echo $ogc;
        die;
        var_dump([__LINE__, __METHOD__, get_defined_vars()]);

        return [
            $include,
            $ogc
        ];
    }
}

$Router = new Router();
Router::run();
