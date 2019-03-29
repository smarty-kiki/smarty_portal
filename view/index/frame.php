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
            width: 10%;
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
            width: 90%;
            margin-left: 10%;
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
        <iframe src="/dashboard" frameborder="0" name="frame"></iframe>
    </div>
    <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
    <script>
        $(function () {

            var title = window.document.title;
            var action = getQueryString('action');
            var atag = null,lis = [];

            $('a').on('click', function () {

                $('.active').removeClass('active');

                atag = $(this);

                atag.addClass('active');

                title = window.document.title = atag.text();

                lis = atag.parents('li');

                history.pushState({}, title, '/?action='+lis[0].className);
            });

            function getQueryString(name) {

                var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
                var r = window.location.search.substr(1).match(reg);
                if (r != null) {
                    return unescape(r[2]);
                }
                return null;
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

        });
    </script>
</body>
</html>
