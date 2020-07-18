<?php
namespace traits;

use Ext\File;
use Ext\Zlib;

trait _Abstract
{
    public function _errorReport()
    {
        print_r(func_get_args());
    }

    public function _errorLog($logFile, $id)
    {
        $haystack = File::getContents($logFile, 1, '[]');
        if (!in_array($id, $haystack)) {
            $haystack[] = $id;
            $logData = json_encode($haystack);
            $put = File::putContents($logFile, $logData);
        }
        return get_defined_vars();
    }

    public static function _outputJson($code = null, $msg = null, $data = null)
    {
        $arr = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        return json_encode($arr);
    }

    public static function duration($str)
    {
        return $str = date('i:s', $str / 1000);
    }

    public static function datetime($str)
    {
        return $str = date('m-d H:i', $str);
    }

    public static function alias($str)
    {
        $arr = (array) json_decode($str);
        $str = implode(', ', $arr);
        return $str ? " &nbsp;$str" : null;
    }

    public static function name($str, $i = null, $only = null)
    {
        $q = $_GET['q'] ?? null;
        $queryData = ['offset' => $i];
        if ($q) {
            $queryData['q'] = $q;
        }
        $queryUrl = http_build_query($queryData, '', '&', PHP_QUERY_RFC3986);
        if ($only) {
            return "?$queryUrl";
        }
        $str = preg_replace('/%g/', "?$queryUrl", $str);
        return $str;
    }

    public static function mv($mv)
    {
        return $str = $mv ? "<a class=\"mv\" href=\"https://music.163.com/mv?id=$mv\" data-mv=\"$mv\" id=\"mv-$mv\" data-url >▶</a>" : null;
    }

    public static function mvUrl($str, $i = null, $row = null)
    {
        $url = htmlspecialchars($row->url);
        $str = 'mv' == $row->type ? preg_replace('/ data-url /', " data-url=\"$url\" ", $str) : $str;
        return $str;
    }

    public static function transNames($output, $i = null, $row = null)
    {
        $names = preg_split('/[;,]+/', $row->transNames);
        $alias = preg_split('/[;,]+/', $row->alias);
        $haystack = [];
        foreach ($names as $value) {
            if ($value && !in_array($value, $haystack)) {
                $haystack[] = $value;
            }
        }
        foreach ($alias as $value) {
            if ($value && !in_array($value, $haystack)) {
                $haystack[] = $value;
            }
        }
        $nm = implode(', ', $haystack);
        $str = preg_replace('/%nm/', $nm, $output);
        return $str;
    }

    public static function albums($output, $i = null, $row = null)
    {
        $name = $row->album;
        if ($obj = self::$albums[$row->album] ?? null) {
            $name = $obj->name ?: $name;
            $output = preg_replace('/%id/', $obj->id, $output);
        } else {
            // 是否需要记录?
            $output = preg_replace('/%id/', "$row->album/site/$row->site", $output);
        }
        $str = preg_replace('/%nm/', $name, $output);
        return $str;
    }

    public static function albumName($output, $i = null, $row = null)
    {
        $name = $row->name ? htmlspecialchars($row->name) : $row->id;
        $str = preg_replace('/%nm/', $name, $output);
        return $str;
    }

    public static function artists($artists)
    {
        $arr = explode(',', $artists);
        $pieces = [];
        foreach ($arr as $key => $value) {
            if ($value) {
                $row = self::$artists[$value] ?? null;
                if ($row) {
                    $obj = (object) $row;
                    $pieces[] = "<a href=\"/music/artist/$value/site/1\">$obj->name</a>";
                }
            }
        }
        return implode(' / ', $pieces);
    }

    public static function home($home)
    {
        return $str = $home ? "<a href=\"https://music.163.com/user/home?id=$home\">$home</a>" : null;
    }

    public static function publishTime($publishTime)
    {
        return $str = $publishTime ? date('Y-m-d H:i:s', $publishTime / 1000) : null;
    }

    public static function pic($pic)
    {
        return $str = $pic ? "<img style=\"width:24px\" src=\"$pic?param=24y24\">" : null;
    }

    public function lyricFilename($type, $song, $version, $id = 0, $site = -1, $size = -1)
    {
        $extensions = ['', 'lrc', 'xml', 'txt'];
        $ext = $extensions[$type];
        //$md5 = md5("$song-$version");
        $name = "$site-$song-$type-$version-$size";
        $md5 = md5($name);
        $hash = substr($md5, 0, 2);
        $arr = [
            'first' => "$this->cacheDir\lyric\\$song-$version.$ext",
            'second' => "$this->cacheDir\lyrics\\$ext\\$song-$version.$ext",
            //'third' => "$this->cacheDir\geci\\$ext\\$hash\\$md5.$ext",
            'fourth' => "$this->downloadDir\lyric\\$site\\$ext\\$hash\\$name.$ext",
        ];

        $key = 'second';
        if (3625 > $id || 451471 < $id) {
            $key = 'fourth';

        } elseif (54160 > $id) {
            $key = 'first';
        }

        $filename = $arr[$key];
        if (!file_exists($filename)) {
            unset($arr[$key]);
            foreach ($arr as $v) {
                if (file_exists($v)) {
                    return $v;
                }
            }
        }
        return $filename;
    }

    public function lyricContent($type, $song, $version, $id = 0, $site = -1, $size = -1)
    {
        $filename = $this->lyricFilename($type, $song, $version, $id, $site, $size);
        return Zlib::getContents($filename);
    }

    public function audioFilename($song, $au, $ur, $ext, $site = null, $br = null, $size = null)
    {
        if (null === $site) {
            return $filename = "$this->cacheDir/audio/$song-$au-$ur.$ext";
        }

        $name = "$site-$song-$ext-$br-$size";
        $md5 = md5($name);
        $hash = substr($md5, 0, 2);
        return $filename = "$this->downloadDir/music/$site/$ext/$hash/$ur-$au-$song.$ext";
    }
}
