<?php
# echo $request_urn;

use Topdb\Table;
use Model\BookmarkList;

Table::init($_CONFIG['database'], 'wuding/topdb');

$filename = isset($_GET['q']) ? $_GET['q'] : null;
$filename = $filename ?? 'D:\Storage\Browser\Bookmarks\json\Bookmarks.json';
$json = file_get_contents($filename);
$obj = json_decode($json);
$roots = $obj->roots;
global $bookmarks;
$bookmarks = [];
$level = 1;
foreach ($roots as $key => $value) {
    $arr = (array) $value;
    $arr['node_type'] = $key;
    $arr['level'] = $level;
    $children = $arr['children'];
    unset($arr['children']);
    $arr = fixDate(0, $arr);
    $row = add($arr);
    $bookmarks[] = bookmark($arr, $children, $level, $value->guid ?? null, $row);
}

function bookmark($bookmark, $children, $level = null, $guid = null, $row = null) {
    $level++;
    global $bookmarks;
    $upper = null;
    if (is_numeric($row)) {
        $upper = $row;
    } elseif (is_object($row)) {
        $upper = $row->bookmark_id;
    }

    foreach ($children as $k => $v) {
        $arr = (array) $v;
        $arr['level'] = $level;
        if ($guid) {
            $arr['sup'] = $guid;
        }
        if ($upper) {
            $arr['upper'] = $upper;
        }
        $child = isset($arr['children']) ? $arr['children'] : array();
        unset($arr['children']);
        $arr = fixDate(0, $arr);
        $arr = fixByte($arr);
        $row = add($arr);
        $bookmarks[] = bookmark($arr, $child, $level, $v->guid ?? null, $row);
    }

    return $bookmark;
}

function add($arr) {
    $pieces = [];
    foreach ($arr as $key => $value) {
        $val = addslashes($value);
        $pieces[] = "$key = '$val'";
    }
    $set = implode(', ', $pieces);

    extract($arr);
    $BookmarkList = new BookmarkList;
    $nm = addslashes($name);

    $where = '';
    $w = [
        'level' => $level,
        'name' => $name,
        'type' => $type,
    ];
    if ('url' == $type) {
        $w['url'] = $url;
        unset($w['level']);
    }

    $pieces = [];
    foreach ($w as $key => $value) {
        $val = addslashes($value);
        $pieces[] = "$key = '$val'";
    }
    $wh = implode(' AND ', $pieces);

    $sql = "SELECT * 
FROM `bookmark_list` 
WHERE $wh 
LIMIT 1";
    $row = $BookmarkList->db->find($sql);
    if (!$row) {
        $sql = "INSERT INTO bookmark_list SET $set";
        $row = $BookmarkList->db->insert($sql);
    }
    return $row;
}

function fixDate($time = null, $arr = null) {
    if ($arr) {
        if (isset($arr['date_added']) && $arr['date_added']) {
            $arr['date_added'] = fixDate($arr['date_added']);
        }
        if (isset($arr['date_modified']) && $arr['date_modified']) {
            $arr['date_modified'] = fixDate($arr['date_modified']);
        }
        if ($arr['meta_info'] ?? null) {
            $last_visited_desktop = $arr['meta_info']->last_visited_desktop ?? null;
            if ($last_visited_desktop) {
                $arr['last_visited_desktop'] = fixDate($last_visited_desktop);
            }
            unset($arr['meta_info']->last_visited_desktop);
            if ((array) $arr['meta_info']) {
                print_r($arr['meta_info']);
                exit;
            }
            unset($arr['meta_info']);
        }
        return $arr;
    }

    $epoch = -11644473600000;
    $time = $epoch + $time / 1000;
    return $time = round($time / 1000);
    $time = date('Y-m-d H:i:s', $time);
}

function fixByte($arr = null, $variable = null) {
    $variable = ['name', 'url'];
    foreach ($variable as $k => $key) {
        if ($arr[$key] ?? null) {
            $len = mb_strlen($arr[$key]);
            if (512 < $len) {
                $arr['full_'. $key] = $arr[$key];
                $arr[$key] = mb_substr($arr[$key], 0, 512);
            }
        }
    }
    return $arr;
}
print_r($bookmarks);
