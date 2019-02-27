<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>{{ account::$entity_display_name }}[{{ $account->id }}]修改</title>
    <style>
     table {
         font-family: verdana,arial,sans-serif;
         font-size:11px;
         color:#333333;
         border-width: 1px;
         border-color: #666666;
         border-collapse: collapse;
         width: 100%;
     }
     table th {
         border-width: 1px;
         padding: 8px;
         border-style: solid;
         border-color: #666666;
         background-color: #dedede;
         text-align: center;
     }
     table td {
         border-width: 1px;
         padding: 8px;
         border-style: solid;
         border-color: #666666;
         background-color: #ffffff;
         text-align: center;
     }
    </style>
</head>
<body>
<table>
<tbody>
    <form action='' method='POST'>
    <tr>
        <td>
            {{ array_key_exists('nick_name', account::$struct_display_names)? account::$struct_display_names['nick_name']: 'nick_name' }}
        </td>
        <td>
            <input type='{{ account::$struct_types["nick_name"] }}' name='nick_name' value='{{ $account->nick_name }}'>
        </td>
    </tr>
    <tr>
        <td>
            {{ array_key_exists('password', account::$struct_display_names)? account::$struct_display_names['password']: 'password' }}
        </td>
        <td>
            <input type='{{ account::$struct_types["password"] }}' name='password' value=''>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <input type='submit' value='保存'>
        </td>
    </tr>
    </form>
</tbody>
</table>
</body>
<script>
</script>
</html>
