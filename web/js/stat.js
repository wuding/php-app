/*---- 定义 ------*/

// 全局变量
global = {
    page: 1,
    overflow: 0,
}

XHR = []
AJAX = []
RESP = []

// 配置
Config = {
    apiHost: '/'
}

/*---- polyfill ------*/

if ( 'undefined' == typeof URLSearchParams ) {
    var URLSearchParams = function ( init ) {
        obj = new Object
        obj.data = {}

        obj.append = function ( key, value ) {
            obj.data[ key ] = value
        }

        obj.toString = function () {
            arr = []
            for ( key in obj.data ) {
                arr.push( key + '=' + encodeURIComponent( obj.data[ key ] ) )
            }
            return arr.join( '&' )
        }
        return obj
    }
}

/*---- 类库 ------*/

/**
 * 类库 - 主函数对象
 */
var _ = function () {
}

/**
 * 接口 - 调用
 */
_.api = function ( uri, formData, method, queryString, arg ) {
    method = method || 'get'
    method = method.toUpperCase()
    arg = arg || {}
    if ( 'GET' == method && ! queryString && formData ) {
        params = new URLSearchParams
        for ( pair in formData ) {
           params.append( pair, formData[ pair ] )
        }
        queryString = params.toString()
    }
    url = Config.apiHost + 'api/v1/' + uri
    if ( queryString ) {
        url += '?' + queryString
    }
    uri = uri.replace( /\//, '_' )
    req = XHR[ uri ] = new XMLHttpRequest
    req.onreadystatechange = function () {
        if ( 4 == req.readyState ) {
            if ( 200 == req.status ) {
                eval( "json = " + req.responseText + "; _.api.run( json, '" + uri + "', '" + encodeURI(JSON.stringify(arg)) + "' )" )
            } else {
                alert( 'Problem retrieving data: ' + req.statusText )
            }
        }
    }
    req.open( method, url, true )
    if ( 'POST' == method ) {
        req.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' )
    }
    req.send( formData )
}

/**
 * 接口 - 运行
 */
_.api.run = function (json, func, arg) {
    RESP[func] = json
    if (json) {
        if (3 < json.code) {
            alert(json.msg)
        } else {
            eval("api_" + func + "('" + arg + "')")
        }
    } else {
        str = JSON.stringify([json, func, arg])
        alert('_.api.run() ERROR: ' + str)
    }
}

/**
 * 日期时间 格式化
 * @param {string} [format] - 格式
 * @param {number} [timestamp] - 时间戳(秒)
 * @param {number} [millisec] - 与毫秒倍数
 * @param {mixed} [ignore] - 出错时返回
 * @returns {string} 格式化后的日期时间
 */
_.date = function ( format, timestamp, millisec, ignore ) {
    format = format || 'Y-m-d H:i:s';
    if ( null == timestamp ) { //容错
        timestamp = _.date.time() / 1000;
    }
    millisec = millisec || 1000;
    //ignore = '';

    // 忽略
    var val = (timestamp || 0 == timestamp) ? timestamp : '';
    var num = parseInt(val);
    if (isNaN(num) || 'number' != typeof num) {
        if ('undefined' != typeof ignore) {
            return ignore;
        } else {
            return val;
        }
    }
    //alert( num + '_' + val + '_' + timestamp );
    num = num * millisec;

    // 设置获取
    var date = new Date();
    date.setTime(num);
    var year = date.getFullYear();
    var n = date.getMonth() + 1;
    var j = date.getDate();
    var G = date.getHours();
    var i = date.getMinutes();
    var s = date.getSeconds();
    var w = date.getDay();
    var a = 'am';

    // 修改
    var y = String(year).substring(2);
    var m = String(n).str_pad(2);
    var d = String(j).str_pad(2);
    var H = String(G).str_pad(2);
    var dian = 12;
    if (12 < G) {
        dian = G - 12;
        a = 'pm';
    } else if (G) {
        dian = G;
    }
    var shi = String(dian).str_pad(2);

    i = String(i).str_pad(2);
    s = String(s).str_pad(2);

    if ( _.date.format.w ) {
        w = _.date.config[ _.date.format.w ][ w ];
    }

    // 替换
    var str = format.replace(/Y/g, year);
    str = str.replace(/n/g, n);
    str = str.replace(/j/g, j);
    str = str.replace(/G/g, G);
    str = str.replace(/i/g, i);
    str = str.replace(/s/g, s);
    str = str.replace(/w/g, w);

    str = str.replace(/y/g, y);
    str = str.replace(/m/g, m);
    str = str.replace(/d/g, d);
    str = str.replace(/H/g, H);
    str = str.replace(/g/g, dian);
    str = str.replace(/h/g, shi);
    str = str.replace(/a/g, a);
    str = str.replace(/A/g, a.toUpperCase());
    return str;
};


/**
 * 时间戳 毫秒
 * @param {number|string} millisec - 要设置的时间错毫秒
 * @returns {number|object} 时间戳或日期对象
 */
_.date.time = function ( millisec ) {
    var type = typeof millisec;
    if ('number' == type || 'string' == type) {
        if ( millisec.match( /^\+=/ ) ) {
            millisec = Number( millisec.replace( /[^\d]+/, '' ) );
            millisec += _.date.time();
        }
        _.date.object.setTime( millisec );
        return _.date.object;
    } else {
        return new Date().getTime();
    }
};

_.date.object = new Date;
_.date.timestamp = 0;
_.date.format = {};
_.date.config = {
    w: [
        '星期天',
        '星期一',
        '星期二',
        '星期三',
        '星期四',
        '星期五',
        '星期六'
    ]
};

/**
 * 获取或添加扩展名
 * @param {string} url - 文件地址
 * @param {string} [ext] - 要添加的扩展名
 * @param {boolean} remove - 是否移除
 * @returns {string} 扩展名或修改后的地址
 */
_.fileExtension = function ( url, ext, remove ) {
    var matches = url.match( /\.([a-z0-9]+)$/i );
    var extension = '';
    if ( null != matches ) {
        extension = matches[1];
    }
    if ( null != ext ) {
        if ( extension != ext ) {
            url += '.' + ext;
        }
    } else { //返回扩展名
        url = extension;
    }
    return url;
}

/**
 * 脚本加载与回调
 * @param {string|array} url - 脚本地址
 * @param {function} callback - 回调函数
 * @param {string} version - 版本号
 * @param {number} timeout - 延时加载 毫秒
 * @returns
 */
_.js = function ( url, callback, version, timeout ) {
    // 异步模块定义
    if ( url.constructor == Array ) {
        var shift = url.shift();
        if ( url.length ) {
            callback = ( function ( u, c, v, t ) {
                return function () {
                    _.js( u, c, v, t );
                };
            } )( url, callback, version, timeout );
        }
        url = shift;
    }

    var script = document.createElement("script");
    script.type = "text/javascript";

    // 回调函数
    if ('undefined' != typeof callback && null != callback) {
        if (script.readyState) {
            script.onreadystatechange = function () {
                if (script.readyState == "loaded" || script.readyState == "complete") {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {
            script.onload = function () {
                callback();
            };
        }
    }

    url = _.fileExtension( url, '' );
    if ('undefined' == typeof timeout || null == timeout) { //立即追加
        version = version || _.date.time();
        url += url.match(/\?/) ? '&' : '?'
        url += 'v=' + version;
        script.src = url;
        document.body.appendChild(script);
    } else { //延时追加
        _.js.timeout += timeout;
        _.js.script.push(script);
        setTimeout("_.js.append('" + url + "', '" + version + "', " + _.js.script.length + ");", _.js.timeout);
    }
};

_.js.script = [];
_.js.timeout = 0;

/*---- 自定义接口 ------*/

/**
 * AJAX - 加载数据
 *
 */
function loadData() {
    uri = 'play/title'
    key = uri + ':' + global.page
    if (!AJAX[key]) {
        AJAX[key] = 1
        loadInfo.innerHTML = '玩命加载中……'
        formData = {}
        npt = searchForm.getElementsByTagName('input')
        len = npt.length
        i = 0
        for (; i < len; i++) {
            el = npt[i]
            if (el.name && '' !== el.value) {
                formData[el.name] = el.value
            }
        }
        if (1 < global.page) {
            formData.page = global.page
        }
        formData.token = Server.token
        _.api(uri, formData)
    }
}

/**
 * API - 追加视频列表
 */
function api_play_title(arg) {
    position = 'beforeEnd'
    json = RESP['play_title']
    code = json.code
    msg = json.msg
    load_msg = msg || '标题加载完成'
    switch (code) {
        case 0:
            break
        case 1:
        case 2:
            load_msg = msg
            global.overflow = 1
            break
        case 3:
            alert(msg)
            return
        default:
            alert(code + ': ' + msg)
            return
    }

    data = json.data
    len = data.length
    i = 0
    for (; i < len; i++) {
        row = data[i]
        id = row.id
        html = row.tt
        ids = Server.title[id]
        leng = ids.length
        j = 0
        for (; j < leng; j++) {
            id = ids[j]
            obj = document.getElementById(id)
            obj.insertAdjacentHTML(position, html)
        }
    }
    loadInfo.innerHTML = load_msg
}
