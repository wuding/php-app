<!DOCTYPE html>
<html>
<head>
    <title>php-app 安装运行成功!</title>
</head>

<body>
<h1><?=$method?></h1>
<p>文件 <?=$file?></p>
<p>行 <?=$line?></p>

<h2>安装 index 模块</h2>
<p>下载 https://github.com/app-module/index</p>
<p>转到 app 目录使用命令提示符创建符号链接</p>
<code><?=$dir?>php-app\app>mklink /D index <?=$dir?>app-module\index\src</code>
</form>
</body>
</html>