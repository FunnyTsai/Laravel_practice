
{{-- 檢查傳送過來的資料 --}}
@isset($userData)
    {{-- @foreach ($userData as $user)
        {{ dd($user->USER_ID) }}；
    @endforeach --}}
@endisset 

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.4/bootstrap-table-locale-all.min.js"></script>
    {{-- <script src="https://cdn.bootcdn.net/ajax/libs/bootstrap-table/1.21.4/locale/bootstrap-table-zh-TW.min.js"></script> --}}
  
    <!-- 引入 Bootstrap Table CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap-table/bootstrap-table.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap-table/bootstrap-table-filter-control.css') }}">
    <script src="{{ asset('js/member/delete.js') }}" crossorigin="anonymous"></script>

    <style>
        #table th {
            text-align: center;
        }
    
        #table td {
            text-align: center;
        }
    </style>
</head>
<body>
    @extends('layouts.page')

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')
        <h1 class="fw-bold">帳號資料</h1>

        {{-- <div class="text-start">
            <a class="btn btn-primary" href="{{ route('member.create') }}">新增帳號</a>
            <a class="btn btn-danger" href="">刪除選取項目</a>
        </div> --}}

        <table
            id="table"
            data-filter-control="true"
            data-search="true"
            data-pagination="true"
            data-page-size="20"
            data-show-search-clear-button="true"
            data-locale="zh-TW"
            >
            <thead>
                <tr>
                    <th data-field="0" data-checkbox="true"></th>  
                    <th data-field="USER_ID" data-filter-control="input" data-sortable="true">員工編號</th>
                    <th data-field="USER_NAME" data-filter-control="input" data-sortable="true">姓名</th>
                    <th data-field="USER_GROUP" data-filter-control="select" data-sortable="true">部門</th>
                    <th data-field="USER_ZONE" data-filter-control="select" data-sortable="true">區域</th>
                    <th data-field="TEAM" data-filter-control="input" data-sortable="true">組別</th>
                    <th data-field="USER_ROLE" data-filter-control="select" data-sortable="true">角色</th>
                    <th data-field="USER_BOSS" data-filter-control="input" data-sortable="true">主管</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userData as $user)
                    <tr>
                        <td>
                            <input type="checkbox" name="btSelectItem" value="{{ $user->USER_ID }}">
                        </td>
                        {{-- edit需要傳送member參數 --}}
                        {{-- <td><a href="{{ route('member.edit', ['member' => $user->USER_ID]) }}">{{ $user->USER_ID }}</a></td> --}}
                        <td><a href="{{ route('member.edit', $user->USER_ID) }}">{{ $user->USER_ID }}</a></td>    
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
                        <td>{{ $user->BOSS_NAME }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ route('member.create') }}">新增帳號</a>
            <form id="deleteForm" action="{{ route('member.bulkDestroy') }}" method="post">
                @csrf
                @method('delete')
                <input type="hidden" name="deleteIds" id="deleteIds">
                <button type="submit" class="btn btn-danger">刪除選取項目</button>
            </form>
        </div>

        <script>           
            $(function () {
                $('#table').bootstrapTable({
                });
            });
        </script>
    @endsection
</body>
</html>
