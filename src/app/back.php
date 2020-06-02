<?php
# echo $request_urn;

$filename = 'D:\System\Users\Administrator\.gitconfig';
$filenm = 'C:\Users\Administrator\.gitconfig';

function parse_gitconfig_file($filename) {
    $lines = file($filename);
    # print_r($lines);
    $sections = array();
    $name = '';
    foreach ($lines as $key => $value) {
        $val = trim($value);
        if (preg_match('/^\[([^\]]*)\]$/i', $val, $matches)) {
            $name = $matches[1];
            if (!array_key_exists($name, $sections)) {
                $sections[$name] = array();
            }
        } elseif (preg_match('/^([^=]*)=(.*)$/i', $val, $matches)) {
            $nm = trim($matches[1]);
            $v = trim($matches[2]);
            if ($name) {
                if (!is_array($sections[$name])) {
                    $sections[$name] = array($sections[$name]);
                }
                if (!array_key_exists($nm, $sections[$name])) {
                    $sections[$name][$nm] = $v;
                } else {
                    if (!is_array($sections[$name][$nm])) {
                        $sections[$name][$nm] = array($sections[$name][$nm]);
                    }
                    $sections[$name][$nm][] = $v;
                }
            }else {
                $sections[$nm] = $v;
                $name = $nm;
            }
        }
    }
    return $sections;
}

function array_to_gitconfig($array) {
    $lines = '';
    $keys = array();
    foreach ($array as $section => $names) {
        if (is_array($names)) {
            foreach ($names as $nm => $items) {
                if (is_array($items)) {
                    if (!array_key_exists($section, $keys)) {
                        $lines .= "" . PHP_EOL;
                        $lines .= "[$section]" . PHP_EOL;
                        $keys[$section] = 0;
                    } else {
                        $keys[$section]++;
                    }

                    foreach ($items as $k => $v) {
                        $lines .= "$nm = $v" . PHP_EOL;
                    }
                } else {
                    $lines .= "$nm = $items" . PHP_EOL;
                }
            }

        } else {
            $lines .= "$section = $names" . PHP_EOL;
        }
    }
    return $lines;
}

$arr = parse_gitconfig_file($filename);
$ar = parse_gitconfig_file($filenm);
$stat = stat($filename);
$sta = stat($filenm);
$a = $arr;
$b = $ar;
if ($stat['mtime'] < $sta['mtime']) {
    $a = $ar;
    $b = $arr;
}
$array = array_merge_recursive($a, $b);


$recent = $array['gui']['recentrepo'];
$repo = array();
foreach ($recent as $key => $value) {
    if (!in_array($value, $repo)) {
        $repo[] = $value;
    }
}
$array['gui']['recentrepo'] = $repo;

$email = $array['user']['email'];
$name = $array['user']['name'];
$user = array();
foreach ($email as $key => $value) {
    $nm = $name[$key];
    $val = $nm .','. $value;
    if (!in_array($val, $user)) {
        $user[] = $val;
    }
}
$m = $n = array();
foreach ($user as $key => $value) {
    $exp = explode(',', $value);
    $m[] = $exp[1];
    $n[] = $exp[0];
}
$array['user']['email'] = $m;
$array['user']['name'] = $n;
# print_r($user);
# print_r($array);

$gitconfig = array_to_gitconfig($array);
# print_r($gitconfig);

echo file_put_contents($filename, $gitconfig);
