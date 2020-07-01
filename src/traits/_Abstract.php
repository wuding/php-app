<?php
namespace traits;

use Ext\Zlib;

trait _Abstract
{
    public function _errorReport()
    {
        print_r(func_get_args());
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

    public static function artists($artists)
    {
        $arr = explode(',', $artists);
        $pieces = [];
        foreach ($arr as $key => $value) {
            if ($value) {
                $row = self::$artists[$value] ?? null;
                if ($row) {
                    $pieces[] = "<a href=\"/music/artist/$value/site/1\">$row->name</a>";
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

    public function lyricFilename($type, $song, $version, $id = 0)
    {
        $extensions = ['', 'lrc', 'xml', 'txt'];
        $ext = $extensions[$type];
        $filename = "$this->cacheDir\lyric\\$song-$version.$ext";
        if ($id < 3625) {
            $md5 = md5("$song-$version");
            $hash = substr($md5, 0, 2);
            $filename = "$this->cacheDir\geci\\$ext\\$hash\\$md5.$ext";

        } elseif ($id < 54160) {

        } else {
            $filename = "$this->cacheDir\lyrics\\$ext\\$song-$version.$ext";
        }
        return $filename;
    }

    public function lyricContent($type, $song, $version, $id = 0)
    {
        $filename = $this->lyricFilename($type, $song, $version, $id);
        return Zlib::getContents($filename);
    }
}
