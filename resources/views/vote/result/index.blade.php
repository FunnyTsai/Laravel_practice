
{{-- 檢查傳送過來的資料 --}}
@isset($voteData)
    {{-- {{ dd($voteData) }} --}}
    {{-- @foreach ($voteData as $vote)
        {{ dd($vote->VOTE_RESULT_ID) }}
    @endforeach --}}
@endisset

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

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

    <!-- 匯出檔案js -->
    <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
  
    <!-- 引入 Bootstrap Table CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap-table/bootstrap-table.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap-table/bootstrap-table-filter-control.css') }}">
    
    <!-- 引入 table printer相關 -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.4/extensions/print/bootstrap-table-print.min.js"></script>
</head>
<body>
    @extends('layouts.page', ['webTitle' => '投票結果查詢'])

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')
        <h1 class="fw-bold">投票結果查詢</h1>        

        <form class="needs-validation" action="{{ route('voteResult.index') }}" method="get" id="filterForm">
            @csrf
            <div class="row">
                <div class="col-md-8"> 
                    <div class="input-group">
                        <label class="d-flex align-items-center">
                            <span class="mr-3">投票主題：</span>
                        </label>
                        <select class="form-select" name="voteTitle" required>
                            <option value="">請選擇投票主題...</option>
                            @foreach($voteTitle_auto as $item)
                                <option value='{{ $item->VOTE_ID }}'>
                                    {{ $item->TITLE }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            <button class="btn btn-primary" type="submit">搜尋</button>
                            <button class="btn btn-secondary" onclick="window.location='{{ route('voteResult.index') }}'">回復</button>                            
                        </div>
                    </div>
                </div>
            </div>
        </form>   

        <table
            id="table"
            data-filter-control="true"
            data-search="true"
            data-pagination="true"
            data-page-size="23"
            data-show-search-clear-button="true"
            data-locale="zh-TW"
            data-toolbar="#toolbar"
            data-show-export="true"
            data-show-print="true"
            >
            <thead>
                <tr>
                    <th data-field="TITLE" data-filter-control="select">投票主題</th>  
                    <th data-field="VOTE_DEPT_CODE" data-filter-control="input">部門</th>
                    <th data-field="VOTE_USER" data-filter-control="input" data-sortable="true">姓名</th>
                    <th data-field="VOTE_TITLE" data-filter-control="select">投票結果</th>
                </tr>
            </thead>
            <tbody>                
                @foreach ($voteData as $vote)
                    <tr>
                        <td>{{ $vote->TITLE }}</td>
                        <td>{{ $vote->VOTE_DEPT_NAME }}</td>
                        <td>{{ $vote->VOTE_EMP_NAME }}</td>
                        <td>{{ $vote->VOTE_TITLE }}</td>                    
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            window.voteResultUrl = "{{ route('voteResult.index') }}";
            
            $('#filterForm').on('submit', function(e) {
                e.preventDefault(); 

                var voteTitle = $('select[name="voteTitle"]').val(); 

                $.ajax({
                    url: {{ route('voteResult.index') }},

                    method: "GET",
                    data: {
                        voteTitle: voteTitle
                    },
                    success: function(response) {
                        console.log("response",response); 
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        </script>

        <div class='hidden'>                                
            <input type="hidden" id="voteTitleAuto" data-auto="{{ $voteTitle_auto }}">
        </div>       

        <script>           
            $(function () {
                $('#table').bootstrapTable({
                    showExport: true,
                    buttonsAlign: "right",
                    exportDataType: "all",
                    exportTypes: ['json', 'csv', 'txt'],
                    exportOptions: {
                        fileName: '投票結果',
                    }
                });
            });
        </script>
    @endsection
</body>
</html>
