<?php
#phpinfo(8);
#print_r(get_loaded_extensions());
/*
$string = 'ALL=7,SYSTEM=4,PERDIR=6|2,USER';
$variable = explode(',', $string);
$arr = [];
foreach ($variable as $value) {
    $name = "PHP_INI_$value";
    $arr[$name] = constant($name);
}
print_r($arr);exit;
*/
#header("Content-type: text/html");

// 未使用
$changeable = array(
    'PHP_INI_SYSTEM' => array(
        'allow_url_fopen',
    )
);

// 写入 ini
$filename = dirname(__DIR__) ."/zh-php.ini";
if ('POST' === $_SERVER['REQUEST_METHOD']) {
    extract($_POST);
    // 空值项
    $pieces = [];
    foreach ($no as $key => $value) {
        $pieces[] = ";$key =";
        unset($item[$key]);
    }
    $str = implode(PHP_EOL, $pieces);

    // 设置项
    $pieces = [];
    foreach ($item as $key => $value) {
        $val = $value;
        if (!is_numeric($value) && '' !== $value) {
            $val = "\"$value\"";
        }
        $pieces[] = "$key = $val";
    }
    $string = implode(PHP_EOL, $pieces);

    $data = $string . PHP_EOL . PHP_EOL . $str;
    echo file_put_contents($filename, $data);
    exit;
}


// 选项对应手册（短）网址
$ini = array(
'allow_url_fopen' => '',
'allow_url_include' => '',
'arg_separator.input' => '',
'arg_separator.output' => '',
'assert.active' => '',
'assert.bail' => '',
'assert.callback' => '',
'assert.exception' => '',
'assert.quiet_eval' => '',
'assert.warning' => '',
'auto_append_file' => '',
'auto_detect_line_endings' => '',
'auto_globals_jit' => '',
'auto_prepend_file' => '',
'bcmath.scale' => '',
'browscap' => '',
'cli.pager' => '',
'cli.prompt' => '',
'cli_server.color' => '',
'date.default_latitude' => '',
'date.default_longitude' => '',
'date.sunrise_zenith' => '',
'date.sunset_zenith' => '',
'date.timezone' => '',
'default_charset' => '',
'default_mimetype' => '',
'default_socket_timeout' => '',
'disable_classes' => '',
'disable_functions' => '',
'display_errors' => '',
'display_startup_errors' => '',
'doc_root' => '',
'docref_ext' => '',
'docref_root' => '',
'enable_dl' => '',
'enable_post_data_reading' => '',
'error_append_string' => '',
'error_log' => '',
'error_prepend_string' => '',
'error_reporting' => '',
'expose_php' => '',
'extension_dir' => '',
'file_uploads' => '',
'filter.default' => '',
'filter.default_flags' => '',
'from' => '',
'geoip.custom_directory' => '',
'hard_timeout' => '',
'highlight.comment' => '',
'highlight.default' => '',
'highlight.html' => '',
'highlight.keyword' => '',
'highlight.string' => '',
'html_errors' => '',
'iconv.input_encoding' => '',
'iconv.internal_encoding' => '',
'iconv.output_encoding' => '',
'ignore_repeated_errors' => '',
'ignore_repeated_source' => '',
'ignore_user_abort' => '',
'implicit_flush' => '',
'include_path' => '',
'input_encoding' => '',
'internal_encoding' => '',
'log_errors' => '',
'log_errors_max_len' => '',
'mail.add_x_header' => '',
'mail.force_extra_parameters' => '',
'mail.log' => '',
'max_execution_time' => '',
'max_file_uploads' => '',
'max_input_nesting_level' => '',
'max_input_time' => '',
'max_input_vars' => '',
'memory_limit' => '',
'mysqlnd.collect_memory_statistics' => '',
'mysqlnd.collect_statistics' => '',
'mysqlnd.debug' => '',
'mysqlnd.fetch_data_copy' => '',
'mysqlnd.log_mask' => '',
'mysqlnd.mempool_default_size' => '',
'mysqlnd.net_cmd_buffer_size' => '',
'mysqlnd.net_read_buffer_size' => '',
'mysqlnd.net_read_timeout' => '',
'mysqlnd.sha256_server_public_key' => '',
'mysqlnd.trace_alloc' => '',
'open_basedir' => '',
'output_buffering' => '',
'output_encoding' => '',
'output_handler' => '',
'pcre.backtrack_limit' => '',
'pcre.jit' => '',
'pcre.recursion_limit' => '',
'phar.cache_list' => '',
'phar.readonly' => '',
'phar.require_hash' => '',
'post_max_size' => '',
'precision' => '',
'realpath_cache_size' => '',
'realpath_cache_ttl' => '',
'register_argc_argv' => '',
'report_memleaks' => '',
'report_zend_debug' => '',
'request_order' => '',
'sendmail_from' => '',
'sendmail_path' => '',
'serialize_precision' => '',
'session.auto_start' => '',
'session.cache_expire' => '',
'session.cache_limiter' => '',
'session.cookie_domain' => '',
'session.cookie_httponly' => '',
'session.cookie_lifetime' => '',
'session.cookie_path' => '',
'session.cookie_samesite' => '',
'session.cookie_secure' => '',
'session.gc_divisor' => '',
'session.gc_maxlifetime' => '',
'session.gc_probability' => '',
'session.lazy_write' => '',
'session.name' => '',
'session.referer_check' => '',
'session.save_handler' => '',
'session.save_path' => '',
'session.serialize_handler' => '',
'session.sid_bits_per_character' => '',
'session.sid_length' => '',
'session.trans_sid_hosts' => '',
'session.trans_sid_tags' => '',
'session.upload_progress.cleanup' => '',
'session.upload_progress.enabled' => '',
'session.upload_progress.freq' => '',
'session.upload_progress.min_freq' => '',
'session.upload_progress.name' => '',
'session.upload_progress.prefix' => '',
'session.use_cookies' => '',
'session.use_only_cookies' => '',
'session.use_strict_mode' => '',
'session.use_trans_sid' => '',
'short_open_tag' => '',
'SMTP' => '',
'smtp_port' => '',
'sys_temp_dir' => '',
'syslog.facility' => '',
'syslog.filter' => '',
'syslog.ident' => '',
'track_errors' => '',
'unserialize_callback_func' => '',
'unserialize_max_depth' => '',
'upload_max_filesize' => '',
'upload_tmp_dir' => '',
'url_rewriter.hosts' => '',
'url_rewriter.tags' => '',
'user_agent' => '',
'user_dir' => '',
'user_ini.cache_ttl' => '',
'user_ini.filename' => '',
'variables_order' => '',
'windows.show_crt_warning' => 'windows-show-crt-warning',
'xmlrpc_error_number' => '',
'xmlrpc_errors' => '',
'zend.assertions' => '',
'zend.detect_unicode' => '',
'zend.enable_gc' => '',
'zend.exception_ignore_args' => '',
'zend.multibyte' => '',
'zend.script_encoding' => '',
'zlib.output_compression' => '',
'zlib.output_compression_level' => '',
'zlib.output_handler' => '',
);

$uri = [];
foreach ($ini as $key => $value) {
    $value = $value ?: str_replace('_', '-', $key);
    $uri[$key] = $value;
}
#print_r($uri);

// 推荐使用默认值，不设置
$default_value = 'allow_url_fopen,allow_url_include,arg_separator.input,auto_append_file,auto_prepend_file';

// 自定义
$custom_value = 'sys_temp_dir';

// ini_set
$runtime_value = 'user_agent,arg_separator.output,include_path';

global $ref;
$ref = array(
    // https://www.php.net/manual/en/ini.list.php
    'ini.list' => array(
        'report_zend_debug',
        'sys_temp_dir',
    ),
    // phar.configuration.html#ini.phar.cache-list
    'configuration' => array(
        'errorfunc' => array(
            'syslog.facility',
            'syslog.ident',
            'xmlrpc-error-number',
        ),
        'var' => array(
            'unserialize-callback-func',
            'unserialize_max_depth',
        ),
        'outcontrol' => array(
            'url-rewriter.hosts',
        ),
        'session' => array(
            'session.cookie-samesite',
            'session.sid-bits-per-character',
            'session.trans-sid-hosts',
            'session.trans_sid_tags',
            'session.use-strict-mode',
        ),
        'phar' => array(
            'phar.cache-list',
        ),
        'pcre' => array(
            'pcre.jit',
        ),
        'info' => array(
            'max-input-vars',
        ),
        'mail' => array(
            'mail.add-x-header',
            'mail.force_extra_parameters',
            'mail.log',
        ),
        'iconv' => array(
            'iconv.input-encoding',
            'iconv.internal_encoding',
            'iconv.output_encoding',
        ),
        'misc' => array(
            'syntax-highlighting' => array(
                'highlight.comment',
                'highlight.default',
                'highlight.html',
                'highlight.keyword',
                'highlight.string',
            ),
        ),
        'readline' => array(
            'cli.pager',
            'cli.prompt',
        ),
        'geoip' => array(
            'geoip.custom-directory',
        ),
    ),
    // mysqlnd.config.html#ini.mysqlnd.collect-memory-statistics
    'config' => array(
        'mysqlnd' => array(
            'mysqlnd.collect-memory-statistics',
            'mysqlnd.collect-statistics',
            'mysqlnd.debug',
            'mysqlnd.fetch_data_copy',
            'mysqlnd.log_mask',
            'mysqlnd.mempool_default_size',
            'mysqlnd.net_cmd_buffer_size',
            'mysqlnd.net_read_buffer_size',
            'mysqlnd.net_read_timeout',
            'mysqlnd.sha256_server_public_key',
            'mysqlnd.trace_alloc',
        ),
    ),
    // ini.core.html#ini.serialize-precision
    'ini.core' => array(
        'hard-timeout',
        'max-file-uploads',
        'serialize-precision',
        'windows-show-crt-warning',
        'user-ini.cache-ttl',
        'user_ini.filename',
        'zend.detect-unicode',
        'zend.exception-ignore-args',
        'zend.multibyte',
        'zend.script_encoding',
        'input_encoding',
        'internal_encoding',
        'output_encoding',
    ),
    // https://www.php.net/manual/en/features.commandline.ini.php#ini.cli-server.color
    'features.commandline.ini' => array(
        'cli_server.color',
    )
);
#print_r($ref['configuration']);exit;

function configuration($item) {
    global $ref;
    $item = str_replace('_', '-', $item);
    $conf = $ref['configuration'];
    foreach ($conf as $key => $value) {
        foreach ($value as $kk => $val) {
            $type = gettype($val);
            if ('string' === $type) {
                $val = str_replace('_', '-', $val);
                if ($item === $val) {
                    return "https://www.php.net/manual/en/$key.configuration.php#ini.$val";
                }
            } elseif ('array' === $type) {
                foreach ($val as $k => $vl) {
                    $v = str_replace('_', '-', $vl);
                    if ($item === $v) {
                        return "https://www.php.net/manual/en/$key.configuration.php#ini.$kk";
                    }
                }
            }
        }
    }
    return false;
}

function config($item) {
    global $ref;
    $item = str_replace('_', '-', $item);
    $conf = $ref['config'];
    foreach ($conf as $key => $value) {
        foreach ($value as $val) {
            $val = str_replace('_', '-', $val);
            if ($item === $val) {
                return "https://www.php.net/manual/en/$key.config.php#ini.$val";
            }
        }
    }
    return false;
}

function iniCore($item) {
    global $ref;
    $item = str_replace('_', '-', $item);
    $ini = $ref['ini.core'];
    foreach ($ini as $key) {
        $key = str_replace('_', '-', $key);
        if ($item === $key) {
            return "https://www.php.net/manual/en/ini.core.php#ini.$item";
        }
    }
    return false;
}

function iniList($item) {
    global $ref;
    $item = str_replace('_', '-', $item);
    $iniList = $ref['ini.list'];
    foreach ($iniList as $key) {
        $key = str_replace('_', '-', $key);
        if ($item === $key) {
            return "https://www.php.net/manual/en/ini.list.php";
        }
    }
    return false;
}

function section($item, $sec = 'features.commandline.ini') {
    global $ref;
    $item = str_replace('_', '-', $item);
    $ini = $ref[$sec];
    foreach ($ini as $key) {
        $key = str_replace('_', '-', $key);
        if ($item === $key) {
            return "https://www.php.net/manual/en/$sec.php#ini.$item";
        }
    }
    return false;
}

// 获取文档地址
/*
$filename = "Q:\System\ProgramFiles\php-7.4.9-nts\php-.ini";
$conf = file_get_contents($filename);
*/
$conf = '';
$func = ['configuration', 'config', 'iniCore', 'iniList', 'section'];
$array = [];
foreach ($uri as $key => $value) {
    $val = addslashes($value);
    if (!preg_match("/php\.net\/$val/i", $conf)) {
        $url = null;
        foreach ($func as $fn) {
            $url = $fn($value);
            if (false !== $url) {
                break 1;
            }
        }
        $array[$key] = $url;
    }
}
/*
print_r($array);
*/

function url($item) {
    global $array;
    $url = $array[$item] ?? null;
    if ($url) {
        return $url;
    }
    $item = str_replace('_', '-', $item);
    return $url = "http://php.net/$item";
}

// 获取已经加载的扩展配置选项
function core($section = null, $details = true) {
    $variable = get_loaded_extensions();
    natcasesort($variable);
    $arr = $ext = [];
    $all = ini_get_all(null, $details);
    $string = 'Core,PDO,Phar,Reflection,SimpleXML,SPL,Zend OPcache';
    $haystack = explode(',', $string);
    foreach ($variable as $extension) {
        $row = [];
        if (!in_array($extension, $haystack)) {
            $row = ini_get_all($extension, $details);
            $ext = array_merge($ext, $row);
        }
        $arr[$extension] = $row;
    }
    $arr['Core'] = array_diff_key($all, $ext);
    if (null === $section) {
        return $arr;
    }
    return $arr[$section];
}

function htmlChar($str) {
    try {
        $str = @htmlspecialchars($str);#var_dump($str);
    } catch (Exception $e) {
        print_r([$str, $e, __FILE__, __LINE__]);
    }
    return $str;
}

#$all = ini_get_all();
$all = core();
#print_r($all);exit;

// 数组转为 HTML
#$tr = html($all);'Core'
$tr = [];
foreach ($all as $key => $value) {
    $ht = html($value, $key);
    $tr = array_merge($tr, $ht);
}

function html($all, $title = null) {
    $tr = $sets = $acc = $eqs = [];
    if ($title) {
        $tr[] = "<tr><th colspan='8' scope='row' style='text-align: center; border-bottom: 1px #000 solid'>$title</th></tr>";
    }
    $i = 1;
    foreach ($all as $key => $value) {
        $first = $value[0] ?? null;
        if (!is_array($value)) {
            var_dump([$key, $value, __LINE__]);exit;
        } elseif ($first) {
            var_dump([$key, $value, __LINE__]);exit;
        }

        $arr = [
            'checked' => ''
        ];
        $a = [];
        foreach ($value as $k => $v) {
            $a[$k] = $v;
            if (null === $v) {
                if ('global_value' === $k) {
                    $arr['checked'] = 'checked';
                } else {
                    $v = "<i>no value</i>";
                }

            } else {
                #$v = @htmlspecialchars($v);

            }
            $arr[$k] = $v;

        }
        if (!array_key_exists('global_value', $a)) {
            print_r($a);
            var_dump([$key, $value, __LINE__]);exit;
        }

        $any = $ok = '';
        $set = false;
        if (!in_array($key, array('date.timezone', 'default_charset'))) {
            $set = false === ini_set($key, 'test_set');
        } else {
            $any = 'N';
        }
        $try = ini_get($key);
        $eq = $try !== 'test_set' && false === $set;
        if ($eq) {
            $eqs[$key] = $key;
        }
        extract($arr);
        $url = url($key);

        if ('7' === $access) {
            if (true === $set) {
                $sets[$key] = $access;
                $any = 'N';
            }

        } elseif (false === $set) {
            $acc[$key] = $try;
        }

        if (true === $set && $a['local_value'] !== $try) {
            $val = null === $a['global_value'] && null === $a['local_value'];
            if ($val && '' !== $try) {
                var_dump([$a['global_value'], $a['local_value'], $try]);
            }
            $ok = 'N';
        }
        $set = true === $set ? 'N' : '';
        $type = gettype($global_value);
        $style = '';
        if (!$arr['checked']) {
            if (preg_match("/^(#[0-9a-f]{6})$/i", $local_value)) {
                #$local_value = "<span style=\"color: $local_value\">$local_value</span>";
                $style = "border-color: $local_value";
            } else {
                $local_value = htmlChar($local_value);
            }
            $global_value = htmlChar($global_value);
        }

        $tr[] = <<<HEREDOC
    <tr>
        <td>$i</td>
        <th style="text-align:left"><a href="$url">$key</a></th>
        <!--td style="text-align:right"><pre>$local_value</pre></td-->
        <td><input name="item[$key]" value="$global_value" style="width: 300px; $style"></td>
        <td><input type="checkbox" name="no[$key]" $checked></td>
        <td>$any</td>
        <td>$ok</td>
        <td>$access</td>
        <td>$set</td>
        <!--td>$try</td-->
    </tr>
    HEREDOC;
        $i++;
    }
    return $tr;
}

// 生成 HTML
$str = implode(PHP_EOL, $tr);
$html = <<<HEREDOC
<table>
<tr>
    <th>#</th>
    <th>key</th>
    <!--th>local_value</th-->
    <th>global_value</th>
    <th>no value</th>
    <th>Any value</th>
    <th>ok</th>
    <th>access</th>
    <th>Changeable</th>
    <!--th>try</th-->
</tr>
$str
</table>
HEREDOC;

#print_r([$sets, $acc, $eqs]);exit;
?>
<h1 style="text-align:center;">php-ini-config</h1>
<hr>
<form action="" method="post">
    <?=$html?>
    <hr>
    <input name="filename" value="<?=$filename?>" placeholder="php.ini 本地文件地址" style="width:500px">
    <button type="submit">Save</button>
</form>
