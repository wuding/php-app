<!DOCTYPE html>
<html class="index">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>友联社</title>
    <link rel="stylesheet" type="text/css" href="/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/css/default.css">
    <link rel="stylesheet" type="text/css" href="/css/index.css">
</head>

<body>
<header>
    <h1>
        <a href="/faq">?</a>
    </h1>
    <div><?=$login_link?></div>
    <blockquote>友联社</blockquote>
</header>

<form action="/search">
    <input type="search" name="q" value="<?=$qh?>" placeholder="搜索" autofocus onfocus="this.select()">
    <blockquote style="display: none">
        <button type="submit">搜索</button>
    </blockquote>

    <div>
        <?=$dl?>
        <dl>
            <a href="/search/settings/add">
                <dd><img src="/img/icon/plus.png"></dd>
                <dt>添加</dt>
            </a>
        </dl>
    </div>
</form>

</body>
</html>