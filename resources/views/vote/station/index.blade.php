
{{-- 檢查傳送過來的資料 --}}
{{-- @isset($voteData)
    @foreach ($voteData as $vote)
        {{ dd($vote->VOTE_ID) }}；
    @endforeach
@endisset  --}}

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
    <script src="{{ asset('js/vote/delete.js') }}" crossorigin="anonymous"></script>

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
    @extends('layouts.page', ['webTitle' => '投票區'])

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')
        <h1 class="fw-bold">投票區</h1>

        <table
            id="table"
            data-filter-control="true"
            data-search="true"
            data-pagination="true"
            data-page-size="10"
            data-show-search-clear-button="true"
            data-locale="zh-TW"
            >
            <thead>
                <tr>
                    <th data-field="VOTE_ID">ID</th>  
                    <th data-field="VOTE_DATE" data-filter-control="input" data-sortable="true">建立日期</th>
                    <th data-field="TITLE" data-filter-control="input">標題</th>
                    <th data-field="TITLE_DESC" data-filter-control="input">描述</th>
                    <th data-field="START_DATE" data-sortable="true">開始日期</th>
                    <th data-field="END_DATE" data-sortable="true">結束日期</th>
                    <th data-field="function">功能</th>    
                </tr>
            </thead>
            <tbody>
                @foreach ($voteData as $vote)
                    <tr>
                        <td>{{ $vote->VOTE_ID }}</td>
                        <td>{{ $vote->VOTE_DATE }}</td> 
                        <td>{{ $vote->TITLE }}</td>
                        <td>{{ $vote->TITLE_DESC }}</td>
                        <td>{{ $vote->START_DATE }}</td>
                        <td>{{ $vote->END_DATE }}</td>       
                        <td>
                            @php
                                $currentDate = date('Y-m-d');
                            @endphp

                            @if (($currentDate >= $vote->START_DATE) && ($currentDate <= $vote->END_DATE))    
                                <a href="{{ route('voteStation.edit', $vote->VOTE_ID) }}" class="btn btn-primary btn-sm">投票</a>
                            @else
                                <a href="{{ route('voteStation.result', ['voteId' => $vote->VOTE_ID]) }}" class="btn btn-secondary btn-sm">查看</a>                          
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>           
            $(function () {
                $('#table').bootstrapTable({
                    
                });
                $('#table').bootstrapTable('hideColumn', 'VOTE_ID');
            });
        </script>
    @endsection
</body>
</html>
