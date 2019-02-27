<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>{{ system::$entity_display_name }}添加</title>
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
    @foreach (system::$struct_types as $struct => $type)
    @if ($struct !== 'api_authorized_token')
    <tr>
        <td>
            {{ array_key_exists($struct, system::$struct_display_names)? system::$struct_display_names[$struct]: $struct }}
        </td>
        <td>
            @if (system::$struct_types[$struct] === 'enum')
            <select name='{{ $struct }}'>
            @foreach (system::$struct_formats[$struct] as $key => $value)
            <option value='{{ $key }}'>{{ $value }}</option>
            @endforeach
            </select>
            @else
                @if ($struct === 'account_id')
                    <select name='{{ $struct }}'>
                    @foreach ($choice_accounts as $id => $account)
                        <option value='{{ $id }}'>{{ '[ID:'.$account->id.'] '.$account->get_display_name() }}</option>
                    @endforeach
                    </select>
                @else
                    <input type='{{ $type }}' name='{{ $struct }}'>
                @endif
            @endif
        </td>
    </tr>
    @endif
    @endforeach
    <tr>
        <td>
            <a href='javascript:window.history.back(-1);'>取消</a>
        </td>
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
