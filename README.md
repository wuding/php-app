# php-app 应用骨架

资源库 https://github.com/wuding/php-app

版本 v21



### 目录结构

app 应用目录

bin 工具脚本

conf 配置目录

- locale 本地化语言目录

data 数据目录

src 源文件目录

temp 临时目录

web 文档根目录



## 安装

### 环境需求

PHP >= 7.0.0



#### 扩展

##### 捆绑

| 扩展名    | 描述                | 可选 | 可替换        |
| --------- | ------------------- | ---- | ------------- |
| gettext   | 多语言              | Y    | php\func\lang |
| openssl   | Composer 下载时需要 | N    |               |
| pdo_mysql | PDO MySQL 驱动      |      |               |

##### PECL

| 扩展名    | 描述                | 可选 | 可替换        |
| --------- | ------------------- | ---- | ------------- |
| geoip     | IP 地理位置         | Y    | geoip/geoip   |
| redis     | 内存缓存            |      |               |

##### 配置示例

> php.ini

```ini
extension=openssl
```



#### Composer 包

注意：Composer 1.0 使用 PHP 8.0 会出错，PHP 7.3 经过验证可用。



##### 框架依赖

| 包名              | 描述               | 版本 | 可省略* | 已经包含在        | 因为                   |
| ----------------- | ------------------ | ---- | ------- | ----------------- | ---------------------- |
| wuding/php-func   | 常用函数库         |      |         |                   |                        |
| wuding/php-ext    | 扩展类库           |      | Y       | wuding/topdb      | PDObj                  |
| wuding/php-pkg    | 依赖包类           |      | Y       | wuding/magic-cube | Glob::conf             |
| 同上              |                    |      | Y       | wuding/topdb      | Glob::cnf<br>Glob::get |
| wuding/magic-cube | 模块调度器和控制器 |      |         |                   |                        |
| wuding/new-ui     | 视图模板引擎       |      |         |                   |                        |
| wuding/topdb      | 数据库模型         |      |         |                   |                        |

*可省略：意味可被其他依赖（不可省略的）加载



##### 功能需求

| 包名                | 描述           | 版本  | 冲突                               |
| ------------------- | -------------- | ----- | ---------------------------------- |
| geoip/geoip         | IP 地理位置    | ^1.17 | ext-geoip（此扩展无 PHP 8.0 版本） |
| phpmailer/phpmailer | 邮件发送验证码 | ^6.2  |                                    |



##### 安装命令示例

> cmd

```bash
D:
cd D:/wuding/php-app
composer require phpmailer/phpmailer
```




### 安装命令

```bash
# 创建项目
composer create-project wuding/php-app=dev-develop --prefer-source

# 或者下载 zip 解压后安装
composer install --prefer-source
```



### 配置

复制

> conf/.dist/config.php

到

> conf/develop.php

```php
<?php
return array(
    // 合并覆盖超全局变量
    'merge' => array(
        'server' => array(
            'REMOTE_ADDR' => '8.8.8.8',
        ),
    ),
    // 地理位置
    'geo' => array(
        'country_uids' => array (
          'XA' => 1,
          'CN' => 156,
          'TW' => 158,
          'HK' => 344,
          'US' => 840,
        ),
    ),
    // 本地化
    'locale' => array(
        'func' => 'gettext',
    ),
    // 扩展
    'ext' => array(
      'geoip' => array(),
    ),
    // 数据库
    'db' => array(
        'alias' => array(
            'connect' => 'db.server.master'
        ),
        'server' => array(
        ),
    ),
    // 内存缓存
    'mem' => array(
        'alias' => array(
            'connect' => 'mem.server.master'
        ),
    ),
    // 视图变量
    'view' => array(
        'cdn_prefix' => 'http://127.0.0.1:8000',
    ),
);
```



#### 本地化

```php
<?php
return array(
    'locale' => array(
        'func' => '\php\func\lang', # gettext 或其他函数名
        'domain' => '', # 空值则使用语言代码
        'directory' => ROOT ."/conf/locale",
        'default_language' => 'en',
        'available_languages' => array( # 可用语言必须包含默认语言
          'en' => 'US',
          'zh' => 'CN'，
        ),
        'module' => array(
            '' => array(),
            'index' => array(
                'site_name' => 'URLNK.ORG',
                'login' => 'Sign in',
            ),
        ),
    ),
);
```



#### 扩展

```php
<?php
return array(
    'ext' => array(
      'geoip' => array(
        'custom_directory' => ini_get('geoip.custom_directory') ?: 'N:\Server\Database\Category\ip\GeoIP\dat',
      ),
    ),
);
```



#### 数据库

```php
<?php
return array(
    'db' => array(
        'alias' => array(
            'connect' => 'db.server.master'
        ),
        'server' => array(
            'master' => array(
                'username' => '',
                'password' => '',
                'port' => 3306,
            ),
            'slave' => array(
            ),
        ),
    ),
);
```



#### 内存缓存

```php
<?php
return array(
    'mem' => array(
        'alias' => array(
            'connect' => 'mem.server.master'
        ),
        'server' => array(
            'master' => array(
                'host' => '127.0.0.1',
                'port' => 6379,
                'timeout' => 0,
                'reserved' => null,
                'retry_interval' => 0,
                'read_timeout' => 0,
                'option' => array('auth' => '<password>'),
                'method' => 'pconnect',
            ),
        ),
    ),
);
```



#### 视图变量

```php
<?php
return array(
    'view' => array(
        'cdn_prefix' => 'http://127.0.0.1:8000',
        'favicon_default' => '/img/favicon/default.png',
    ),
);
```



## 内建服务器

### 默认索引文件名

| 优先级 | 文件名     | 命令行示例                                                   |
| ------ | ---------- | ------------------------------------------------------------ |
| 0      | router.php | php -S 0.0.0.0:80 E:\env\www\work\wuding\php-app\web\router.php |
| 1      | index.php  | php -S 0.0.0.0:80 -t E:\env\www\work\wuding\php-app\web      |
| 2      | index.html | php -S localhost:8080                                        |

使用路由情况下：

- 如果请求路径不存在并且不包含点，则显示为 index.php

### 存在的目录和文件

/favicon.ico

/index.html

/index.php 全静态服务器配置时无

/router.php

/img/

/img/screenshot.png

### 存在的模块和控制器

/back

/back/end

### 测试结果

| 描述       | 地址         | router.php | index.php | index.html |
| ------------ | ---- | ---- | ---- | ---- |
| 根目录         | /            | 200 | 200 | 200 |
| 图标 | /favicon[.ico\|png] | 404,200,404 | 404,200,400 |.html,200,400|
| 首页 | /index[.html\|htm\|php] | 200         |200,200,400,200|.html,200,400,400|
| 路由 | /router[.php\|html] | 404 | 404,404,400 | .html,200,400 |
| 文件夹 | /img[/\|/index.html] | 200 | index | index |
| 图片 | /img/screenshot[/\|.png] | 404,404,200 | index,index,200 | index,index,200 |
| 模块 | /back[/\|.php] | 200 | 200,200,404 | .html,.html,400 |
| 控制器 | /back/end[/\|.php] | 200 | 200,200,404 | .html,.html,400 |
| 总结 | 默认不支持列出<br/>文件和目录 | 路由名称的<br/>模块不存在，<br/>可忽略扩展名 | 路由名称的<br/>模块不存在，<br>不可忽略扩展名 | 无点且不存<br/>在的入口文件接管 |

### 状态说明

| 状态  | 说明            |
| ----- | --------------- |
| 200   | 成功            |
| 400   | 默认错误页      |
| 404   | 自定义错误页    |
| index | 默认目录索引页  |
| .html | 输出 index.html |

