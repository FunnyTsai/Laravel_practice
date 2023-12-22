
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
    @extends('layouts.page', ['webTitle' => '投票資料'])

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')
        <h1 class="fw-bold">投票資料</h1>

        <table
            id="table"
            data-filter-control="true"
            data-search="true"
            data-pagination="true"
            data-page-size="10"
            data-show-search-clear-button="true"
            data-locale="zh-TW"
            data-sort-name="VOTE_DATE"
            data-sort-order="desc"
            >
            <thead>
                <tr>
                    <th data-field="0" data-checkbox="true"></th>  
                    <th data-field="VOTE_DATE" data-filter-control="input" data-sortable="true">建立日期</th>
                    {{-- <th data-field="USER_NAME" data-filter-control="input" data-sortable="true">部門</th> --}}
                    <th data-field="TITLE" data-filter-control="select">標題</th>
                    <th data-field="TITLE_DESC" data-filter-control="select">描述</th>
                    <th data-field="START_DATE" data-filter-control="input" data-sortable="true">開始日期</th>
                    <th data-field="END_DATE" data-filter-control="select" data-sortable="true">結束日期</th>
                    <th data-field="ACHIEVE_QTY" data-filter-control="input" data-sortable="true">投票數</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voteData as $vote)
                    <tr>
                        <td>
                            <input type="checkbox" name="btSelectItem" value="{{ $vote->VOTE_ID }}">
                        </td>
                        <td><a href="{{ route('vote.edit', $vote->VOTE_ID) }}">{{ $vote->VOTE_DATE }}</a></td> 
                        {{-- <td><a href="{{ route('vote.edit', $vote->VOTE_DATE) }}">{{ $vote->VOTE_DATE }}</a></td>     --}}
                        <td>{{ $vote->TITLE }}</td>
                        <td>{{ $vote->TITLE_DESC }}</td>
                        <td>{{ $vote->START_DATE }}</td>
                        <td>{{ $vote->END_DATE }}</td>
                        <td>{{ $vote->ACHIEVE_QTY }}</td>                       
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ route('vote.create') }}">新增投票</a>
            <form id="deleteForm" action="{{ route('vote.bulkDestroy') }}" method="post">
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
