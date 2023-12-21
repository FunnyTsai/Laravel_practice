
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
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/member.css') }}">
    <!-- 引入 jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>

    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <!-- 引入 autocomplete相關 -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <script src="{{ asset('js/member/member.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js') }}"></script>
</head>
<body>
    @extends('layouts.page')

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')

        @include('components.breadcrumb', ['page' => 'vote', 'pageName' => '投票', 'title' => '新增'])
     
        <form class="needs-validation" action="{{route('member.store')}}" method="post" required>
            @csrf

                <div class="col-md-7 col-lg-7">
                    <hr class="my-4">

                    <div class="row g-4">
                        <div class="col-sm-6">
                            <label for="user_id" class="form-label">帳號</label>
                            <input type="text" class="form-control" value="{{old('user_id')}}" id="user_id" name="user_id" placeholder="請輸入帳號" minlength=7 maxlength=7 required>
                            <div class="invalid-feedback">
                                帳號欄位為必填.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="user_name" class="form-label">姓名</label>
                            <input type="text" class="form-control" value="{{old('user_name')}}" id="user_name" name="user_name" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                姓名欄位為必填.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="user_boss" class="form-label">主管</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="user_boss" name="user_boss" placeholder="請輸入主管姓名" value="{{old('user_boss')}}">
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">電子信箱</label>
                            <input type="email" class="form-control" name="user_mail" placeholder="yourname@arich.com.tw" value="{{old('user_mail')}}">
                        </div>
                    </div>
        
                    <hr class="my-4">

                    <div class="text-end">
                        <button class="btn btn-success" type="submit">確定存檔</button>
                        <a class="btn btn-light" href="{{ route('member.index') }}">回主畫面</a>
                    </div>   
                </div>
            </div>                     
        </form>   
    @endsection    
    
    <script src="{{ asset('js/checkout.js') }}"></script>
</body>
</html>
