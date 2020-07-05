<?php
use Ext\Filesystem;

\Ext\Info::setTimeLimit();

// 全局变量
$dir = "N:\Server\Mirror\https\www.microsoft.com";
$seconds = 10;
$string = '.,..,cms,en-us,zh-cn';
$haystack = explode(',', $string);

$directories = \Ext\Dir::scan($dir);
$addons = [];
foreach ($directories as $key => $value) {
    if (!in_array($value, $haystack)) {
        $addons[$value] = parseAddon($value);
        $addons[] = \Ext\Misc::sleep($seconds);
    }
}
print_r([__FILE__, __LINE__, $addons]);
exit;

// 本地化列表
$filename = $dir . "\\en-us\locale.aspx";
$subject = file_get_contents($filename);
$variable = [];
if (preg_match_all('/href="\/([^=]+)\/" bi:locale/', $subject, $matches)) {
    $variable = $matches[1];
}

// 中断处理
$enables = [];
foreach ($variable as $key => $value) {
    if ('vi-vn' == $value || $enables) {
        $enables[] = $value;
    }
}
# print_r($enables);exit;

// 下载本地化页面
$expression = $downloaded = $deleted = $error = [];
foreach ($enables as $key => $value) {
    // 是否已经下载
    $dir = "N:\Server\Mirror\https\www.microsoft.com\\$value";
    $filename = "N:\Server\Mirror\https\www.microsoft.com\\$value\iegallery.htm";
    $filenames = "N:\Server\Mirror\https\www.microsoft.com\\$value\iegallery.html";
    if (file_exists($filename) || file_exists($filenames)) {
        $downloaded[] = $value;
        continue 1;
    } elseif (file_exists($dir)) {
        $deleted[$value] = Filesystem::delete($dir);
        continue 1;
    }

    // 下载
    $url = "https://www.microsoft.com/$value/iegallery";
    $data = @file_get_contents($url);
    if (!$data) {
        echo "<p><a href=\"$url\">$url</a></p>" . PHP_EOL;
        if (preg_match('/HTTP\/([0-9.]+)\s+(\d+)(.*)/i', $http_response_header[0], $matches)) {
            if (404 == $matches[2]) {
                $error[] = $value;
                continue 1;
            } else {
                print_r([__LINE__, $value, $matches]);exit;
            }
        } else {
            print_r([__LINE__, $value, $http_response_header]);exit;
        }
    } else {
        $expression[$value] = Filesystem::putContents($filename, $data);
    }
}

print_r([$expression, $downloaded, $deleted, $error]);
exit;

print_r(get_included_files());
echo Filesystem::putContents($filename, '', 'null');
exit;

function parseAddon($local)
{
    $filename = "N:\Server\Mirror\https\www.microsoft.com\\$local\iegallery.htm";
    $contents = Filesystem::getContents($filename);
    $pattern = "/BrowserDetectionAddonInstallSearch\(&#39;([^&#]+)/";
    $arr = [];
    if (preg_match_all($pattern, $contents, $matches)) {
        $variable = $matches[1];
        foreach ($variable as $key => $value) {
            $name = getFilename($value, $local);
            # echo "<p><a href=\"$value\">$value</a></p>" . PHP_EOL;
            $file = "N:\Server\Mirror\https\www.microsoft.com\cms\api\am\binary\\$local.$name";
            $filesize = file_exists($file) ? filesize($file) : null;
            if (!$filesize) {
                $data = file_get_contents($value);
                $arr[$name] = file_put_contents($file, $data);
            } else {
                $arr['_' . $name] = $filesize;
            }
        }
    }
    return $arr;
}

function getFilename($url, $local)
{
    $names = [];
    $path = parse_url($url, PHP_URL_PATH);
    $names[] = pathinfo($path, PATHINFO_FILENAME);
    $headers = get_headers($url, 1);
    if (!isset($headers['Content-Disposition'])) {
        print_r([__FILE__, __LINE__, $local, $url, $headers]);
        exit;
    }

    $disposition = $headers['Content-Disposition'];
    if (preg_match('/filename=(.*)/', $disposition, $matches)) {
        $file = $matches[1];
        $variable = explode('.', $file);
        $pieces = [];
        foreach ($variable as $key => $value) {
            if (!in_array($value, $pieces)) {
                $pieces[] = $value;
            }
        }
        $names[] = implode('.', $pieces);
    }
    $names[] = 'xml';
    $filename = implode('.', $names);
    return $filename;
}
