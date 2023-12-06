
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
    <!-- 引入 jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- 引入 Bootstrap Table JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="{{ asset('js/member_create.js') }}"></script>
</head>
<body>
    @extends('layouts.member')

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')
        <h1 class="fw-bold">帳號資料【新增】</h1>

        <div class="d-flex justify-content-center">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <form class="needs-validation" novalidate>
                            
                            <hr class="my-4">

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="user_id" class="form-label">帳號</label>
                                    <input type="text" class="form-control" id="user_id" placeholder="" value="" required>
                                    <div class="invalid-feedback">
                                        帳號欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="user_name" class="form-label">姓名</label>
                                    <input type="text" class="form-control" id="user_name" placeholder="" value="" required>
                                    <div class="invalid-feedback">
                                        姓名欄位為必填.
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="user_group" class="form-label">部門</label>
                                    <select class="form-select" id="user_group" required>
                                        <option value="">請選擇部門...</option>
                                        <option>United States</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        部門欄位為必填.
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="user_zone" class="form-label">區域</label>
                                    <select class="form-select" id="user_zone" required>
                                        <option value="">請選擇區域...</option>
                                        <option value="中區">中區</option>
                                        <option value="北區">北區</option>
                                        <option value="南區">南區</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        區域欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="user_boss" class="form-label">主管</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="user_boss" placeholder="" value="">
                                        <div class="input-group-append">
                                            <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#bosstModal">選擇</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="country" class="form-label">角色</label>
                                    <select class="form-select" id="country" required>
                                        <option value="">請選擇角色...</option>
                                        <option value="中區">中區</option>
                                        <option value="北區">北區</option>
                                        <option value="南區">南區</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        角色欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">組別</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="boss" placeholder="" value="">
                                        <div class="input-group-append">
                                            <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#bosstModal">選擇</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">行動電話</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" value="">
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">電話</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" value="">
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">傳真</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" value="">
                                </div>

                                <div class="col-6">
                                    <label for="email" class="form-label">電子信箱</label>
                                    <input type="email" class="form-control" id="email" placeholder="yourname@arich.com.tw">
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">差勤員工編號</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="boss" placeholder="" value="">
                                        <div class="input-group-append">
                                            <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#bosstModal">選擇</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">原廠</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="boss" placeholder="" value="">
                                        <div class="input-group-append">
                                            <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#bosstModal">選擇</a>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="country" class="form-label">標案訊息</label>
                                    <select class="form-select" id="country" required>
                                        <option value="">請選擇標案訊息...</option>
                                        <option value="是">是</option>
                                        <option value="否">否</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        標案訊息欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">業務員ID</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" value="">
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">收款員ID</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="" value="">
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="country" class="form-label">訂單金額</label>
                                    <select class="form-select" id="country">
                                        <option value="">請選擇訂單金額...</option>
                                        <option value="是">是</option>
                                        <option value="否">否</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        訂單金額欄位為必填.
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="country" class="form-label">訂單折讓金額</label>
                                    <select class="form-select" id="country">
                                        <option value="">請選擇訂單折讓金額...</option>
                                        <option value="是">是</option>
                                        <option value="否">否</option>
                                    </select>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="country" class="form-label">行事曆預設</label>
                                    <select class="form-select" id="country">
                                        <option value="">請選擇行事曆預設...</option>
                                        <option value="日">日</option>
                                        <option value="週">週</option>
                                        <option value="月">月</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="country" class="form-label">ORG預設</label>
                                    <select class="form-select" id="country" required>
                                        <option value="">請選擇ORG預設...</option>
                                        <option value="久裕企業">久裕企業</option>
                                        <option value="代收帳本">代收帳本</option>
                                        <option value="裕康國際OU">裕康國際OU</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        ORG預設欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">誤餐費費用職別</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="boss" placeholder="" value="">
                                        <div class="input-group-append">
                                            <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#bosstModal">選擇</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">交通津貼職別</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="boss" placeholder="" value="">
                                        <div class="input-group-append">
                                            <a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#bosstModal">選擇</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="password" class="form-label">密碼</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" placeholder="密碼" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">
                                        密碼欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="firstName" class="form-label">確認密碼</label>
                                    <input type="password" class="form-control" id="firstName" placeholder="" value="" required>
                                    <div class="invalid-feedback">
                                        確認密碼欄位為必填.
                                    </div>
                                </div>
                            </div>
                
                            <hr class="my-4">

                            <div class="text-end">
                                {{-- <button class="btn btn-primary btn-lg" type="submit">Continue to checkout</button> --}}
                                <button class="btn btn-success" type="submit" href="{{ route('member.create') }}">確定存檔</button>
                                <a class="btn btn-light" href="{{ route('member.index') }}">回主畫面</a>
                            </div>
                        </form>
                    </div>
                </div>
                @include('layouts.modal')
            </div>
        </div>
        
        <script src="{{ asset('js/checkout.js') }}"></script>
    @endsection
</body>
</html>
