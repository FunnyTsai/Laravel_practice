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


    <!-- 引入 jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>
<body>
    <div class="box">
        <div class="box-body">
          <table
            id="table"
            data-filter-control="true"
            data-search="true"
            data-pagination="true"
            data-page-size="30"
            data-sort-name="course_id"
            data-show-search-clear-button="true"
            data-toolbar="#toolbar"
            data-show-toggle="true"
            data-show-columns="true">
            <thead>
              <tr>                             
                  <th data-field="USER_ID" data-sortable="true">員工編號</th>
                  <th data-field="USER_NAME" data-sortable="true">姓名</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>

            @foreach($data as $item)
                <tr>
                    <td>{{ $item->USER_ID }}</td>
                    <td>{{ $item->USER_NAME }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
