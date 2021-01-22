<?php

namespace app\index\view;

class Prototype
{
    // 搜索引擎图标列表
    public static function dl($all = array(), $favicon = null, $cdn_prefix = null)
    {
        $pieces = array();
        foreach ($all as $row) {
            $no = $row->no ?: $row->url;
            $icon = $favicon;
            if ($row->favicon) {
                $icon = $row->favicon;
                if (null !== $cdn_prefix) {
                    $icon = str_replace("{cdn_prefix}", $cdn_prefix, $icon);
                }
            }
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
