
{{-- 檢查傳送過來的資料
    @isset($userData)
    {{ dd($userData) }}
@endisset 
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- 引入 jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- 引入 Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- 引入 Bootstrap Table JavaScript -->
    <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></script>
    
    <!-- 引入 Bootstrap Table filter-control -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.4/extensions/filter-control/bootstrap-table-filter-control.js"></script>
   
    <!-- 引入bootstrap table的中文語言包 -->
    <script src="https://cdn.bootcdn.net/ajax/libs/bootstrap-table/1.18.3/locale/bootstrap-table-zh-TW.min.js"></script>
  
    <!-- 引入 Bootstrap Table CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap-table/bootstrap-table.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap-table/bootstrap-table-filter-control.css') }}">
       
</head>
<body>
    @extends('layouts.member')

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')
        <h1 class="fw-bold">系統資料/帳號資料</h1>

        {{-- <div class="text-start">
            <a class="btn btn-primary" href="{{ route('member.create') }}">新增帳號</a>
            <a class="btn btn-danger" href="">刪除選取項目</a>
        </div> --}}

        <div class="table-responsive mt-3">
            <table
                id="table"
                data-filter-control="true"
                data-search="true"
                data-pagination="true"
                data-page-size="14"
                data-show-search-clear-button="true">
                <thead>
                    <tr>
                        <th data-field="0" data-checkbox="true"></th>  
                        <th data-field="USER_ID" data-filter-control="input">員工編號</th>
                        <th data-field="USER_NAME" data-filter-control="input">姓名</th>
                        <th data-field="USER_GROUP" data-filter-control="select">部門</th>
                        <th data-field="USER_ZONE" data-filter-control="select">區域</th>
                        <th data-field="TEAM" data-filter-control="input">組別</th>
                        <th data-field="USER_ROLE" data-filter-control="select">角色</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userData as $user)
                        <tr>
                            <td></td>
                            <td>{{ $user->USER_ID }}</td>
                            <td>{{ $user->USER_NAME }}</td>
                            <td>{{ $user->USER_GROUP }}</td>
                            <td>{{ $user->USER_ZONE }}</td>
                            <td>{{ $user->TEAM }}</td>
                            <td>
                                @switch($user->USER_ROLE)
                                @case('S')
                                    系統管理員
                                    @break
                                @case('A')
                                    助理
                                    @break
                                @case('B')
                                    部門經理
                                    @break
                                @case('C')
                                    客服人員
                                    @break
                                @case('D')
                                    後勤人員
                                    @break
                                @case('E')
                                    主管
                                    @break
                                @case('F')
                                    原廠人員
                                    @break
                                @case('G')
                                    ARM
                                    @break
                                @case('H')
                                    出納主管
                                    @break
                                @case('I')
                                    信管人員
                                    @break
                                @case('J')
                                    財務長
                                    @break
                                @case('L')
                                    離職
                                    @break
                                @default
                                    一般使用者
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end">
            <a class="btn btn-primary" href="{{ route('member.create') }}">新增帳號</a>
            <a class="btn btn-danger" href="">刪除選取項目</a>
        </div>

        <script>
            // 在此初始化 bootstrap-table
            $(function () {
                $('#table').bootstrapTable({
                });
            });
        </script>
    @endsection
</body>
</html>
