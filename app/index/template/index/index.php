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
    <input type="search" name="q" placeholder="搜索">
    <blockquote style="display: none">
        <button type="submit">搜索</button>
    </blockquote>

    <div>
        <dl>
            <button type="submit" name="id" value="90091">
                <dd><img src="/img/icon/google.ico"></dd>
                <dt>Google</dt>
            </button>
        </dl>
        <dl>
            <button type="submit" name="id" value="40">
                <dd><img class="fav-28" src="/img/icon/youtube.png"></dd>
                <dt>YouTube</dt>
            </button>
        </dl>
        <dl>
            <button type="submit" name="id" value="43420">
                <dd><img class="fav-30" src="https://www.amazon.com/favicon.ico"></dd>
                <dt>Amazon</dt>
            </button>
        </dl>
        <dl>
            <button type="submit" name="id" value="76">
                <dd><img class="fav-28" src="/img/icon/facebook.ico"></dd>
                <dt>Facebook</dt>
            </button>
        </dl>
        <dl>
            <button type="submit" name="id" value="61">
                <dd><img class="fav-28" src="https://www.bing.com/sa/simg/favicon-2x.ico"></dd>
                <dt>Bing</dt>
            </button>
        </dl>
        <dl>
            <button type="submit" name="id" value="44">
                <dd><img class="fav-28" src="https://yastatic.net/iconostasis/_/KKii9ECKxo3QZnchF7ayZhbzOT8.png"></dd>
                <dt>Yandex</dt>
            </button>
        </dl>
        <dl>
            <button type="submit" name="id" value="431">
                <dd><img class="fav-28" src="https://s3-media0.fl.yelpcdn.com/assets/public/favicon.yji-118ff475a341620f50dfbaddb83efb25.ico"></dd>
                <dt>Yelp</dt>
            </button>
        </dl>
        <dl>
            <button type="submit" name="id" value="100">
                <dd><img src="https://www.baidu.com/favicon.ico"></dd>
                <dt>百度</dt>
            </button>
        </dl>
        <dl>
            <button type="submit" name="id" value="5090">
                <dd><img class="fav-26" src="https://www.sogou.com/images/logo/new/favicon.ico?v=4"></dd>
                <dt>搜狗</dt>
            </button>
        </dl>
        <dl>
            <button type="submit" name="id" value="360">
                <dd><img class="fav-28" src="https://s2.ssl.qhres.com/static/121a1737750aa53d.ico"></dd>
                <dt>360</dt>
            </button>
        </dl>
        <dl>
            <a href="/search/settings/add">
                <dd>+</dd>
                <dt>添加</dt>
            </a>
        </dl>
    </div>
</form>

</body>
</html>