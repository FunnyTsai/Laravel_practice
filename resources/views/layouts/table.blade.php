<!-- table.blade.php -->

{{-- <div class="table-responsive mt-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <!-- 欄位名稱 -->
                @foreach($headers as $header)
                    <th scope="col">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <!-- 資料 -->
                @foreach($columns as $column)
                    <td>{{ $item->{$column} }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

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
    
    <style>
        /* 为表头单元格（<th>）设置文本水平居中 */
        #table th {
            text-align: center;
        }
    
        /* 为表格主体单元格（<td>）设置文本水平居中 */
        #table td {
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- table.blade.php -->
    <div class="table-responsive mt-3">
        <table
            id="table"
            data-filter-control="true"
            data-search="true"
            data-pagination="true"
            data-page-size="14"
            data-show-search-clear-button="true">
            <thead>
                {{ $tableHeaders }}
            </thead>
            <tbody>
                <!-- ... -->
            </tbody>
        </table>
    </div>
</body>
