<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>{{ permission_tag::$entity_display_name }}</title>
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
<thead>
    <tr>
        <th>ID</th>
        @foreach (permission_tag::$struct_types as $struct => $type)
        <th>{{ array_key_exists($struct, permission_tag::$struct_display_names)? permission_tag::$struct_display_names[$struct]: $struct }}</th>
        @endforeach
        <th>系统名</th>
        <th>操作</th>
    </tr>
</thead>
    @foreach ($permission_tags as $id => $permission_tag)
    <tr>
        <td>{{ $id }}</td>
        @foreach (permission_tag::$struct_types as $struct => $type)
        @if (permission_tag::$struct_types[$struct] === 'enum')
        <td>{{ $permission_tag->{'get_'.$struct.'_description'}() }}</td>
        @else
        <td>{{ $permission_tag->{$struct} }}</td>
        @endif
        @endforeach
        <td>{{ $permission_tag->system->name }}</td>
        <td>
            @if ($permission_tag->authorized_account_count() == 0)
                <a href='javascript:delete_{{ $permission_tag->id }}.submit();'>删除</a>
                <form id='delete_{{ $permission_tag->id }}' action='/permission_tags/delete/{{ $permission_tag->id }}' method='POST'></form>
            @else
                {{ $permission_tag->authorized_account_count() }} 用户被授权
            @endif
        </td>
    </tr>
    @endforeach
<tbody>
</tbody>
</table>
</body>
</html>
