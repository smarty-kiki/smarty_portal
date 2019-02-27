<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        center {
            margin-top:25%;
        }
    </style>
</head>
<body>
    <center>
        <form action="/login" method="POST">
            <table>
                <tr>
                    <td>邮箱:</td>
                    <td>
                        <input name="email" type="text">
                    </td>
                </tr>
                <tr>
                    <td>密码:</td>
                    <td>
                        <input name="password" type="password">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input name="refer" type="hidden" value="{{ $refer }}">
                    </td>
                    <td>
                        <input type="submit" value="登陆 (回车)">
                    </td>
                </tr>
            </table>
        </form>
    </center>
</body>
</html>
