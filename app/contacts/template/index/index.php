<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>联系人</title>
</head>

<body>
<form action="">
    <input type="" name="q" value="">
    <button type="submit">搜索</button>
</form>

<table>
    <tr><th>#</th><th>姓名</th></tr>
<?php
$list = '';
$i = 1;
foreach ($all as $row) {
    extract((array) $row);
    $list .= "<tr><td>$i</td><td><a href=\"/contacts/$id\">$NickName</a></td></tr>";
    $i++;
}
echo $list;
?>
</table>
</body>
</html>
