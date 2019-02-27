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
<table>
<thead>
    <tr>
        <th>ID</th>
        @foreach (account_permission_tag::$struct_types as $struct => $type)
        <th>{{ array_key_exists($struct, account_permission_tag::$struct_display_names)? account_permission_tag::$struct_display_names[$struct]: $struct }}</th>
        @endforeach
        <th>
            <a href='/account_permission_tags/add'>添加</a>
        </th>
    </tr>
</thead>
    @foreach ($account_permission_tags as $id => $account_permission_tag)
    <tr>
        <td>{{ $id }}</td>
        @foreach (account_permission_tag::$struct_types as $struct => $type)
        @if (account_permission_tag::$struct_types[$struct] === 'enum')
        <td>{{ $account_permission_tag->{'get_'.$struct.'_description'}() }}</td>
        @else
        <td>{{ $account_permission_tag->{$struct} }}</td>
        @endif
        @endforeach
        <td>
            <a href='/account_permission_tags/update/{{ $account_permission_tag->id }}}'>修改</a>
            <a href='javascript:delete_{{ $account_permission_tag->id }}.submit();'>删除</a>
            <form id='delete_{{ $account_permission_tag->id }}' action='/account_permission_tags/delete/{{ $account_permission_tag->id }}' method='POST'></form>
        </td>
    </tr>
    @endforeach
<tbody>
</tbody>
</table>
</body>
</html>