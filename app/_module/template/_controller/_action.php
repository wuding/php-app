<!DOCTYPE html>
<html>
<head>
    <title>404 Not Found</title>
</head>

<body>
<h1><?=$method?></h1>
<p>文件 <?=$file?></p>
<p>行 <?=$line?></p>

<?php
extract($uriInfo);
?>
<h2>没有找到对应的方法</h2>
<h3><?="app\\$module\controller\\$controller::$action"?></h3>
<div>
    <b>请求地址</b>
    <address style="display: inline;"><?=$uri?></address>
</div>
</form>
</body>
</html>