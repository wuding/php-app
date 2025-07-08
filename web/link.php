<!DOCTYPE html>
<html>
<!-- version 24.7.8 -->
<?php
$title = $_GET['q'] ?? '怪奇大法师';
$id = $_GET['id'] ?? 213085663;
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1.0">
    <title></title>
<style type="text/css">
a {
    text-decoration: none;
}

.open {
    padding: 500px 0 0 30px;
    font-size: 24px;
}

.url {
    text-align: center;
    font-size: 32px;
}

.search {
    padding: 20px 0 0 30px;
    font-size: 24px;
}

.title {
    text-align: center;
    font-size: 32px;
}

.watch {
    text-align: center;
    padding: 20px 0 0 0;
    font-size: 24px;
}

.img {
    text-align: center;
}

.img img {
    width: 80%;
}

.code {
    text-align: center;
    font-size: 24px;
}

.play {
    text-align: center;
    font-size: 24px;
    font-family: Tahoma, "hiragino sans gb", Helvetica, Arial;
}

.what {
    padding: 1000px 0 0 0;
    text-align: center;
}

.what input {
    font-size: 24px;
}

.what button {
    font-size: 24px;
}
</style>
</head>

<body>
<div class="open">打开:</div>
<div class="url"><a href="http://www.movcd.com?">www.movcd.com</a></div>
<div class="search">搜索:</div>
<div class="title"><a href="http://movcd.com/play?q=<?=$title?>&"><?=$title?></a></div>
<div class="watch">免费观看全片</div>
<div class="img">
<img src="/qrcode_movcd.com.png?v=<?=$id?>">
</div>
<div class="code">扫码立即观看</div>
<div class="play"><a href="http://movcd.com/play/<?=$id?>?">movcd.com/play/<?=$id?></a></div>
<div class="what">
<form>
<input type="search" name="q" value="<?=$title?>" placeholder="片名">
<p>
<input type="text" name="id" value="<?=$id?>" placeholder="id">
<p>
<button type="submit">测试</button>
</form>
</div>
</body>
</html>
