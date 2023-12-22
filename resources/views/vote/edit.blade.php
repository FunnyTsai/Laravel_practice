
{{-- 檢查傳送過來的資料 --}}
@isset($vote)
    {{-- {{ dd($data['group']) }} --}}
    {{-- {{ dd($vote['collector_name']) }}
    {{ dd($vote['attribute1_name']) }} --}}

@endisset 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vote.css') }}">
    
    <!-- 加入這個才可以從js傳value到controller -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- 引入 jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- 引入 autocomplete相關 -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <script src="{{ asset('js/vote/vote.js') }}"></script>
    <script src="{{ asset('js/vote/edit.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js') }}"></script>
</head>
<body>
    @extends('layouts.page', ['webTitle' => '投票資料'])

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')
       

        @include('components.breadcrumb', ['page' => 'vote', 'pageName' => '投票', 'title' => '編輯'])

        <form class="needs-validation" action="{{route('vote.update', $vote)}}" novalidate method="post" required>
            @csrf
            @method('patch')
            <div class="col-md-12 col-lg-12">
                
                <hr class="my-4">
                    
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <label for="VOTE_DATE" class="form-label">建立日期</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime($vote['VOTE_DATE'])) }}" name="VOTE_DATE" required>
                        <div class="invalid-feedback">
                            建立日期欄位為必填.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="CREATE_BY" class="form-label">建立者</label>
                        <input type="text" class="form-control" value="{{ $CREATE_BY['USER_NAME'] }}" name="CREATE_BY" required>
                    </div>
                </div>
                    
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <label for="START_DATE" class="form-label">投票期間(起)</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime($vote['START_DATE'])) }}" name="START_DATE" required>
                        <div class="invalid-feedback">
                            建立日期欄位為必填.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="END_DATE" class="form-label">投票期間(迄)</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime($vote['END_DATE'])) }}" name="END_DATE" required>
                        <div class="invalid-feedback">
                            建立日期欄位為必填.
                        </div>
                    </div>
                </div>
                    
                <div class="row g-4 mb-4">
                    <div class="col-sm-12">
                        <label for="USE_GROUP" class="form-label">部門</label>
                        <textarea class="form-control" name="USE_GROUP" rows="4" cols="50" required>{{ $USE_GROUP_FINAL }}</textarea>
                    </div>
                </div>
                    
                <div class="row g-4 mb-4">
                    <div class="col-sm-12">
                        <label for="TITLE" class="form-label">標題</label>
                        <textarea class="form-control" name="TITLE" rows="1" cols="50" required>{{ $vote['TITLE'] }}</textarea>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-12">
                        <label for="TITLE_DESC" class="form-label">描述</label>
                        <textarea class="form-control" name="TITLE_DESC" rows="6" cols="50" required>{{ $vote['TITLE_DESC'] }}</textarea>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-12">
                        <label for="VOTED_USER" class="form-label">已投票人員</label>
                        <textarea class="form-control" name="TITLE_DESC" rows="6" cols="50" required>{{ $VOTER_FINAL }}</textarea>
                    </div>
                </div>
    
                <hr class="my-4">

                <div class="">
                    <div class="input-group mb-4">
                        <button id="voteSubmit" class="btn btn-primary">新增投票明細</button>
                    </div>
                
                    <div id="voteDetails" class="mb-4">
                        <!-- JS自動生成DIV -->
                    </div>
                </div>        
    
                <hr class="my-4">

                <div class="text-end">
                    <button class="btn btn-success" type="submit">確定存檔</button>
                    <a class="btn btn-light" href="{{ route('vote.index') }}">回主畫面</a>
                </div>   

                <div class='hidden'>                                
                    <input type="hidden" id="vote_info" data-info="{{ $VOTE_INFO }}">
                </div> 
            </div>                   
        </form>   
        
        <script src="{{ asset('js/checkout.js') }}"></script>
    @endsection
</body>
</html>