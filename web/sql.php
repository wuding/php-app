<?php


function insert($variable)
{
    $sql = "INSERT INTO `tip_domain_zone` (`domain`, `reg`, `exp`) VALUES ";
    $pattern = "#\n#";
    $glue = "', '";
    $arr = [];
    foreach ($variable as $str) {
        $subject = trim($str);
        $pieces = preg_split($pattern, $subject);
        $s = implode($glue, $pieces);
        $row = "('$s')";
        $arr[] = $row;
    }

    $sql .= implode(','. PHP_EOL, $arr);
    return $sql;
}

function links($variable)
{
    $pieces = [];
    foreach ($variable as $value) {
        $s = "<a href=\"https://$value\" target=\"_blank\">$value</a>";
        $pieces[] = $s;
    }

    return implode('', $pieces);
}

function parsePing()
{
    $pattern = "#([a-z0-9\.]+) \[([\d\.]+)\]#";

    $filename = 'K:\text\domain\p.txt';
    $subject = file_get_contents($filename);

    $p = preg_match_all($pattern, $subject, $matches);
    print_r($matches);
    var_dump($p);
}

function format()
{
    $subject = <<<HEREDOC
accept:
*/*
accept-encoding:
gzip, deflate, br, zstd
accept-language:
zh-CN,zh;q=0.9
bx-v:
2.5.11
content-length:
681
content-type:
application/x-www-form-urlencoded; charset=UTF-8
cookie:
t_alimama=a020fc490b5d43988ef18bb448109f88; cookie2_alimama=1641f5943a7f8ebf0980db1b94f365c9; v_alimama=0; cna=L7DbH7A5Ux4CATrz9PDwHGS5; alimamapwag=TW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzEzMC4wLjAuMCBTYWZhcmkvNTM3LjM2; cookie32=ce5c3304fad1ca10d0098850dcb67a14; alimamapw=CFAQDFdaDT9RV11QBVVUAlJSUwJdVFtVU1VSVQpXUQVUBAQEV1EBBA%3D%3D; cookie31=MzM1NDM0NzIsbmV0am9pbiwyNzQ1NjA2ODZAcXEuY29tLFRC; dnk=netjoin; tracknick=netjoin; lid=gowud; lgc=; cookie2=1b3be52702d980e7e28d9b244e27ecdc; cancelledSubSites=empty; t=80634a8995890c7db505b6f9908911ce; sn=; arms_uid=2f6967d0-9e73-4cda-80d5-fd703403875c; login=true; wk_cookie2=13c99136a70255b542fb6d46b59e7f7f; _tb_token_=eb66f9a3476bb; wk_unb=VyyY5Y4mje4%3D; _m_h5_c=336f79c240fef6a54dc91fbab08f15cf_1740790819443%3B194c132dbd10c0a8c4046654fe7bd6c3; isg=BDEx7IGI8gOvhF6AQWMEQ6AmQL3LHqWQFhGLRxNGd_gKOlOMXm0oYo3ZWM5c8j3I; JSESSIONID=3D943F6BB25B9FC7BC1B2FB59333D8BB; xlly_s=1; _l_g_=Ug%3D%3D; cookie3_bak=1b3be52702d980e7e28d9b244e27ecdc; cookie1=VvvQ6fPQBMp01tmxAwi3KtnEYYfvrQtPTatoNYlj%2Bt0%3D; env_bak=FM%2Bgm%2FLsL0Aw%2B6YHHZVne58L3aQ6CUylrI7wfH6L4rCz; sg=n7d; uc1=cookie21=UtASsssmfavZrexPkAwn7A%3D%3D&existShop=false&cookie15=WqG3DMC9VAQiUQ%3D%3D&cookie16=Vq8l%2BKCLySLZMFWHxqs8fwqnEw%3D%3D&cookie14=UoYaiuNDodOXuw%3D%3D&pas=0; havana_lgc_exp=1772171984238; unb=40953887; cookie17=VyyY5Y4mje4%3D; _nk_=netjoin; sgcookie=E1005gap8J4zAXtPme5C%2BsZq9WiNypcszR34zvrMmZ1vNm7we5fpQ%2Bc1DBTeBmqJ3nYK1VYeJrhqbQoFSfuUIYLOYsWhGZhDxWpTg5eMq0bix5rTMqbLjvyl0rso%2FS6g3QDN; csg=042b2df5; cookie3_bak_exp=1741327184238; rurl=aHR0cHM6Ly9wdWIuYWxpbWFtYS5jb20v; tfstk=gb8K0h9NAADnN7Qm-2igr8Fd6shG2Ude5pRbrTX3Vdp9aIhPVDJoyUpkBXSSLwYJBQJNZzmeEdE5wOWoTecFFddyZ9jh-wwJed9b-9tHZ_UJTOvurBYJbzd2aecFrX7eTa7Snx0meBRFz87p6QkM1b1Py6NIsKmwTa7SI54Smqdehy1j1H151fClZzZWFzZs665fPys7Rlw1Q__5P9_7CG1V98NQPzG91O55PT95AU4xeONC9zKfKzWjicWuPzTO9MiMOOa5_FCdvtOBJza7a6IdhB6Z37uZHGOP2UPzyaRB0L5XdJMdPCCviMLKHyXyLUIJWGF7ACLRpiTCXSzX9wCWFgKZHrfd-hIvJHlzCB9cpn_eZSHH6iKO01s_wk_HmIYPcegL3OjVwKCvpJIyjEYY3rycH_qI6fEz4M1whxdZfqzFNACOnX384uSl_1Bm6fEz4M1N6tcKwurPq15..
origin:
https://pub.alimama.com
priority:
u=1, i
referer:
https://pub.alimama.com/portal/v2/pages/promo/goods/index.htm
sec-ch-ua:
"Chromium";v="130", "Google Chrome";v="130", "Not?A_Brand";v="99"
sec-ch-ua-mobile:
?0
sec-ch-ua-platform:
"Windows"
sec-fetch-dest:
empty
sec-fetch-mode:
cors
sec-fetch-site:
same-origin
user-agent:
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36
x-requested-with:
XMLHttpRequest
HEREDOC;

    $subject = <<<HEREDOC
accept:
*/*
accept-encoding:
gzip, deflate, br, zstd
accept-language:
zh-CN,zh;q=0.9
bx-v:
2.5.11
content-length:
724
content-type:
application/x-www-form-urlencoded; charset=UTF-8
cookie:
t_alimama=a020fc490b5d43988ef18bb448109f88; cookie2_alimama=1641f5943a7f8ebf0980db1b94f365c9; v_alimama=0; cna=L7DbH7A5Ux4CATrz9PDwHGS5; alimamapwag=TW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzEzMC4wLjAuMCBTYWZhcmkvNTM3LjM2; cookie32=ce5c3304fad1ca10d0098850dcb67a14; alimamapw=CFAQDFdaDT9RV11QBVVUAlJSUwJdVFtVU1VSVQpXUQVUBAQEV1EBBA%3D%3D; cookie31=MzM1NDM0NzIsbmV0am9pbiwyNzQ1NjA2ODZAcXEuY29tLFRC; dnk=netjoin; tracknick=netjoin; lid=gowud; lgc=; cookie2=1b3be52702d980e7e28d9b244e27ecdc; cancelledSubSites=empty; t=80634a8995890c7db505b6f9908911ce; sn=; arms_uid=2f6967d0-9e73-4cda-80d5-fd703403875c; login=true; wk_cookie2=13c99136a70255b542fb6d46b59e7f7f; _tb_token_=eb66f9a3476bb; wk_unb=VyyY5Y4mje4%3D; _m_h5_c=336f79c240fef6a54dc91fbab08f15cf_1740790819443%3B194c132dbd10c0a8c4046654fe7bd6c3; isg=BDEx7IGI8gOvhF6AQWMEQ6AmQL3LHqWQFhGLRxNGd_gKOlOMXm0oYo3ZWM5c8j3I; JSESSIONID=3D943F6BB25B9FC7BC1B2FB59333D8BB; xlly_s=1; _l_g_=Ug%3D%3D; cookie3_bak=1b3be52702d980e7e28d9b244e27ecdc; cookie1=VvvQ6fPQBMp01tmxAwi3KtnEYYfvrQtPTatoNYlj%2Bt0%3D; env_bak=FM%2Bgm%2FLsL0Aw%2B6YHHZVne58L3aQ6CUylrI7wfH6L4rCz; sg=n7d; uc1=cookie21=UtASsssmfavZrexPkAwn7A%3D%3D&existShop=false&cookie15=WqG3DMC9VAQiUQ%3D%3D&cookie16=Vq8l%2BKCLySLZMFWHxqs8fwqnEw%3D%3D&cookie14=UoYaiuNDodOXuw%3D%3D&pas=0; havana_lgc_exp=1772171984238; unb=40953887; cookie17=VyyY5Y4mje4%3D; _nk_=netjoin; sgcookie=E1005gap8J4zAXtPme5C%2BsZq9WiNypcszR34zvrMmZ1vNm7we5fpQ%2Bc1DBTeBmqJ3nYK1VYeJrhqbQoFSfuUIYLOYsWhGZhDxWpTg5eMq0bix5rTMqbLjvyl0rso%2FS6g3QDN; csg=042b2df5; cookie3_bak_exp=1741327184238; rurl=aHR0cHM6Ly9wdWIuYWxpbWFtYS5jb20v; tfstk=gPyo5Ybs37lW3mU9yrk56PMbzDfAo3MImypKJv3FgqujJQCQYvj3yrjSw_ZE-y4xl23-92HhxqrtY4kdNev3YqgKvYE8-r4al4eKyYW3tPaMJXyKJJx7nPvpea17YpDKLNQOBOESmvMFWwn9zsYSfD-Pp2lr3YiKq7DTOOE7Vn-k8GFVBeXs-vreT2zE3josXvoELbkVmDg2UDJrYESmAqkeLbuP3xotbp-rTyrVmDgq8vlrsPvESJPa3ZrvlSiSTp9SXb0a4qvgc8mPg5BsIpy8F0GuLcgcDiemqb0tGuDdM8zYY8eSGtpjdoFg-WzVnL43PuyEiJQv0fDqufyrIHWzmY0o_-GvbdzamkPti-INCYDrzWH7vhb8m848V-qpYIkoeScgEAW6z2FYjJm3dw60SuPa8WjPEIRZ3L9I0Me2OBGrcm097PGibqRssGScmC1SamisWijDOBT6LpdfmiA68boj445..
origin:
https://pub.alimama.com
priority:
u=1, i
referer:
https://pub.alimama.com/portal/v2/pages/promo/goods/index.htm?pageNum=1&pageSize=30&filters=%257B%2522floorId%2522%253A%2522105335%2522%257D&fn=search&q=&sort=empty%3Aindic_tk_pay_item_quantity_30d&selected=%257B%2522floorId%2522%253A%2522105335%2522%257D&floorId=80674
sec-ch-ua:
"Chromium";v="130", "Google Chrome";v="130", "Not?A_Brand";v="99"
sec-ch-ua-mobile:
?0
sec-ch-ua-platform:
"Windows"
sec-fetch-dest:
empty
sec-fetch-mode:
cors
sec-fetch-site:
same-origin
user-agent:
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36
x-requested-with:
XMLHttpRequest
HEREDOC;

    $pattern = "#\n#";
    $variable = preg_split($pattern, $subject);
    // print_r($variable);die;

    $a = [];
    $pattern = "#^([a-z\-]+):$#";
    $tmp = '';
    foreach ($variable as $key => $value) {
        if (preg_match($pattern, $value, $matches)) {
            $tmp = $matches[0];
            // print_r($matches);die;
        } else {
            $tmp .= " $value";
            $a[] = $tmp;
            $tmp = '';
        }
    }
    var_export($a);
}

$data = [
'softcool.top
2024-11-06 04:17:43
2034-11-06 04:17:43',
'jiedian.store
2024-11-06 04:25:07
2034-11-06 07:59:59',
'coolapp.top
2025-02-08 21:19:31
2035-02-08 21:19:31',
'uuu.show
2025-02-09 12:09:19
2026-02-09 12:09:19',
'uuu.hair
2025-02-09 16:41:34
2026-02-10 07:59:59',
'uuu.skin
2025-02-09 16:41:34
2026-02-10 07:59:59',
];
// print_r(insert($data));

$domain = [
'uuu.hair',
'uuu.show',
'uuu.skin',
'zzz.kids',
'zzz.pics',
'zzz.spa',
'zzz.tips',
];
// print_r(links($domain));

// parsePing();

format();
