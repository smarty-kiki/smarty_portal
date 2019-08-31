<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>{{ account_permission_tag::$entity_display_name }}</title>
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
<form role="form" method="POST">
    <table>
    <thead>
        <tr>
            <th rowspan=2>账号名</th>
            <th rowspan=2>昵称</th>
            @foreach ($systems as $system_id => $system)
                <?php $count = 0; ?>
                @foreach ($system->permission_tags as $permission_tag_id => $permission_tag)
                    @if ($permission_tag->is_not_deleted())
                        <?php $count += 1; ?>
                    @endif
                @endforeach

                @if ($count > 0)
                <th rowspan=1 colspan={{ $count }}>{{ $system_id.'.'.$system->name }}</th>
                @endif
            @endforeach
        </tr>
        <tr>
            @foreach ($systems as $system_id => $system)
                @foreach ($system->permission_tags as $permission_tag_id => $permission_tag)
                    @if ($permission_tag->is_not_deleted()) 
                    <th>{{ $permission_tag->name }}</th>
                    @endif
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($accounts as $account_id => $account)
        <tr>
            <td>{{ $account->email }}</td>
            <td>{{ $account->nick_name }}</td>
            @foreach ($systems as $system_id => $system)
                @foreach ($system->permission_tags as $permission_tag_id => $permission_tag)
                    @if ($permission_tag->is_not_deleted()) 
                    <td>
                        <input name="{{ $account_id.'_'.$permission_tag_id }}" type="checkbox" {{ $permission_tag->has_authorized_account($account)? 'checked': '' }}>
                    </td>
                    @endif
                @endforeach
            @endforeach
        </tr>
        @endforeach
    </tbody>
    </table>
    <input type="submit" value="保存修改">
</form>
</body>
</html>
