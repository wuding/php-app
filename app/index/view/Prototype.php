<?php

namespace app\index\view;

class Prototype
{
    // 搜索引擎图标列表
    public static function dl($all = array(), $favicon = null)
    {
        $pieces = array();
        foreach ($all as $row) {
            $no = $row->no ?: $row->url;
            $icon = $row->favicon ?: $favicon;
            $name = htmlspecialchars($row->name);
            $pieces[] = <<<HEREDOC
<dl>
    <button type="submit" name="id" value="$no" title="$name">
        <dd><img src="$icon"></dd>
        <dt>$name</dt>
    </button>
</dl>
HEREDOC;
        }
        return $dl = implode(PHP_EOL, $pieces);
    }
}
