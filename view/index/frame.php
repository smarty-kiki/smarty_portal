<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>门户</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
        .left-bar {
            position: fixed;
            height: 100%;
            width: 170px;
            background-color: #666;
        }
        .left-bar ul {
            margin: 10px;
            list-style-type:none;
        }
        .left-bar ul li {
            font-size: 14px;
            color: #fff;
            overflow: hidden;
            white-space: nowrap;
        }
        .container {
            position: fixed;
            height: 100%;
            margin-left: 170px;
        }
        iframe {
            width: 100%;
            height:100%;
        }
        a:link {color: #aaa} /* 未访问的链接 */
        a:visited {color: #aaa} /* 已访问的链接 */
        a:hover {color: #bbb} /* 鼠标移动到链接上 */
        a:active {color: #fff} /* 选定的链接 */
        .active {
           background-color: #fff;
        }
        .logo {
           color: #fff;
           text-align: center;
        }
        .processcontainer {
           width: 100%;
           border: 0px solid;
           height: 2px;
         }
        #processbar {
           background: #E95831;
           float: left;
           height: 100%;
           text-align: center;
           line-height: 150%;
         }

@-webkit-keyframes blink {
  0% { color: #aaa;}
  95%, 100% { color: #E95831;}
}

@-moz-keyframes blink {
  0% { color: #aaa;}
  95%, 100% { color: #E95831;}
}

@-o-keyframes blink {
  0% { color: #aaa;}
  95%, 100% { color: #E95831;}
}

@keyframes blink {
  0% { color: #aaa;}
  95%, 100% { color: #E95831;}
}

.blink {
  animation: blink 1s infinite alternate;
  -o-animation: blink 1s infinite alternate;
  -ms-animation: blink 1s infinite alternate;
  -moz-animation: blink 1s infinite alternate;
  -webkit-animation: blink 1s infinite alternate;
}
    </style>
</head>
<body>
    <div class="left-bar">
        <div class="logo"></div>
        <div class="menu">
            <ul>
                @foreach ($systems as $system)
                @if (isset($menu_infos[$system->id]))
                <li>
                    <strong>{{ $system->name }}</strong>
                    {{ menu_recursive_render($menu_infos[$system->id]) }}
                </li>
                @endif
                @endforeach
                <li class="portal">
                    <strong>门户</strong>
                    <ul>
                        @if ($is_admin_or_system_admin)
                        <li class="permission_tag"> <a href="/permission_tags" target="frame">系统标签查看</a> </li>
                        <li class="account_permission_tag"> <a href="/account_permission_tags" target="frame">用户授权管理</a> </li>
                        @endif
                        <li class="system" > <a href="/systems" target="frame">系统管理</a> </li>
                        <li class="account" > <a href="/accounts" target="frame">账号列表</a> </li>
                        <li class="mine"> <a href="/accounts/update/mine" target="frame">修改账户信息</a> </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="processcontainer">
            <div id="processbar" style="width:0%;"></div>
        </div>
        <iframe id="iframe" src="/dashboard" frameborder="0" name="frame"></iframe>
    </div>
    <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
    <script>
        $(function () {

            $('.container').width(document.body.clientWidth - $('.left-bar').width())

            var title = window.document.title;
            var action = getQueryString('action');
            var atag = null,lis = [];
            var iframe = $('#iframe');

            var bartimer = null;
            var processbar = document.getElementById("processbar");

            iframe.on('load', function () {

                processbar.style.width = "0%";

                if (bartimer) {
                    window.clearInterval(bartimer);
                }
            });

            $('a').on('click', function () {

                $('.active').removeClass('active');

                atag = $(this);

                atag.addClass('active');

                title = window.document.title = atag.text();

                lis = atag.parents('li');

                history.pushState({}, title, '/?action='+lis[0].className);

                if (bartimer) {
                    window.clearInterval(bartimer);
                }

                bartimer = window.setInterval(function () {
                    setProcess();
                }, 10);

                iframe.attr('src', addParam(atag.attr('href'), 'account_token', '{{ $current_account->sign }}'));

                localStorage.setItem(atag.attr('href'), true);

                atag.removeClass('blink');

                return false;
            });

            function getQueryString(name) {

                var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
                var r = window.location.search.substr(1).match(reg);
                if (r != null) {
                    return unescape(r[2]);
                }
                return null;
            }

            function addParam(url, paramKey, paramVal) {

                var andStr = "?";
                var qmark_index = url.indexOf("?");
                if (qmark_index != -1) {
                    andStr = "&";
                }
                return url + andStr + paramKey + "="+ encodeURIComponent(paramVal);
            }

            function setProcess() {

                processbar.style.width = parseFloat(processbar.style.width) + 0.5 + "%";
                if(processbar.style.width == "90%"){
                    window.clearInterval(bartimer);
                }
            }

            // 处理 URL
            if (action) {
                atag = $('.' + action + ' a')[0];
                if (atag) {
                    atag.click();
                } else {
                    alert('咳咳，正在打开的这个 URL 不能随便看哦');
                }
            }

            $('a').each(function (k, v) {

                var v = $(v);

                if (! localStorage.getItem(v.attr('href'))) {
                    v.addClass('blink');
                }
            });

        });
    </script>
</body>
</html>
