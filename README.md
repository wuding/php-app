# php-app 应用骨架

### 目录结构

app 应用目录

example

src 源文件目录

vendor

web 文档根目录



## 安装

#### 环境需求

PHP >= 5.4

#### 安装命令

```bash
composer create-project wuding/php-app=dev-master

# 或者下载 zip 解压后安装
composer install
```

#### 配置

app/config.php

```php
'database_contect' => 'database',
'database' => array(
    'db_name' => '',
    'username' => '',
    'password' => '',
),
```



## 内建服务器

### 默认索引文件名

| 优先级 | 文件名     | 命令行示例                                                   |
| ------ | ---------- | ------------------------------------------------------------ |
| 0      | router.php | php -S 0.0.0.0:80 E:\env\www\work\wuding\php-app\web\router.php |
| 1      | index.php  | php -S 0.0.0.0:80 -t E:\env\www\work\wuding\php-app\web      |
| 2      | index.html | php -S localhost:8080                                        |

### 存在的目录和文件

/favicon.ico

/index.html

/index.php 全静态服务器配置时无

/router.php

/img/

/img/index.html

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



## 流程

### 选项配置

.user.ini

set_time_limit(1);

### 请求资源

静态匹配，文件未检测到或直接返回

忽略扩展名（Web 动态资源）

首页

目录

文件

末端文件检测和包含