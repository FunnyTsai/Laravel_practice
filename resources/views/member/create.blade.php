
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
    <script src="{{ asset('js/autocomplete.js') }}"></script>
</head>
<body>
    @extends('layouts.member')

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')

        @include('components.breadcrumb_member', ['title' => '新增'])
     
        <div class="d-flex justify-content-center">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <form class="needs-validation" action="{{route('member.store')}}" novalidate method="post" required>
                            @csrf
                            <hr class="my-4">

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="user_id" class="form-label">帳號</label>
                                    <input type="text" class="form-control" value="{{old('user_id')}}" id="user_id" name="user_id" placeholder="請輸入帳號" minlength=7 maxlength=7 required>
                                    <div class="invalid-feedback">
                                        帳號欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="user_name" class="form-label">姓名</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="" value="" required>
                                    <div class="invalid-feedback">
                                        姓名欄位為必填.
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="user_group" class="form-label">部門</label>
                                    <select class="form-select" name="user_group" required>
                                        <option value="">請選擇部門...</option>
                                        @foreach($data['group'] as $item)
                                            <option value='{{ $item -> VLS_CODE }}'>
                                                {{ $item -> VLS_CODE }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        部門欄位為必填.
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="user_zone" class="form-label">區域</label>
                                    <select class="form-select" name="user_zone" required>
                                        <option value="">請選擇區域...</option>
                                        @foreach($data['zone'] as $item)
                                            <option value='{{ $item -> VLS_CODE }}'>
                                                {{ $item -> VLS_CODE }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        區域欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="user_boss" class="form-label">主管</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="user_boss" name="user_boss" placeholder="請輸入主管姓名" value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="user_role" class="form-label">角色</label>
                                    <select class="form-select" id="user_role" name="user_role" required>
                                        <option value="">請選擇角色...</option>
                                        @foreach($data['role'] as $item)
                                            <option value='{{ $item -> PHR_TYPE }}'>
                                                {{ $item -> PHR_NAME }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        角色欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="team" class="form-label">組別</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="team" name="team" placeholder="請輸入組別" value="">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="attribute1" class="form-label">差勤員工編號</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="attribute1" name="attribute1" placeholder="請輸入員工編號" value="">
                                    </div>
                                </div>
                                {{-- <div class="mb-3 col-md-3">
                                    <label for="attribute1_name" class="form-label" style="color:white">I</label>
                                    <input type="text" class="form-control" id="attribute1_name" style="color:red; font-weight:600" disabled>
                                </div> --}}

                                <div class="col-12">
                                    <label for="email" class="form-label">電子信箱</label>
                                    <input type="email" class="form-control" name="user_mail" placeholder="yourname@arich.com.tw">
                                </div>

                                <div class="col-sm-6">
                                    <label for="orig_vendor" class="form-label">原廠</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="orig_vendor" name="orig_vendor" placeholder="請輸入原廠" value="">
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="mail" class="form-label">標案訊息</label>
                                    <select class="form-select" name="mail" required>
                                        <option value="">請選擇標案訊息...</option>
                                        <option value="Y">是</option>
                                        <option value="N">否</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        標案訊息欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="salesrep_id" class="form-label">業務員ID</label>
                                    <input type="text" class="form-control" name="salesrep_id" placeholder="">
                                </div>

                                <div class="col-sm-6">
                                    <label for="collector_id" class="form-label">收款員ID</label>
                                    <input type="text" class="form-control" name="collector_id" placeholder="">
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="ord_amt" class="form-label">訂單金額</label>
                                    <select class="form-select" name="ord_amt">
                                        <option value="">請選擇訂單金額...</option>
                                        <option value="Y">
                                            是
                                        </option>
                                        <option value="N">
                                            否
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        訂單金額欄位為必填.
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="ord_dis_amt" class="form-label">訂單折讓金額</label>
                                    <select class="form-select" name="ord_dis_amt">
                                        <option value="">請選擇訂單折讓金額...</option>
                                        <option value="Y">
                                            是
                                        </option>
                                        <option value="N">
                                            否
                                        </option>
                                    </select>
                                </div>
                            
                                <div class="col-md-6">
                                    <label for="user_schedule" class="form-label">行事曆預設</label>
                                    <select class="form-select" name="user_schedule">
                                        <option value="">請選擇行事曆預設...</option>
                                        <option value="1">
                                            日
                                        </option>
                                        <option value="2">
                                            週
                                        </option>
                                        <option value="3">
                                            月
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="org_id" class="form-label">ORG預設</label>
                                    <select class="form-select" name="org_id" required>
                                        <option value="">請選擇ORG預設...</option>
                                        @foreach($data['org'] as $item)
                                            <option value='{{ $item -> ORG_ID }}'>
                                                {{ $item -> OU_NAME}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        ORG預設欄位為必填.
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <label for="meal_fee" class="form-label">誤餐費費用職別</label>
                                    <select class="form-select" name="meal_fee">
                                        <option value="">請選擇誤餐費費用職別...</option>
                                        <option value="PSR009">誤餐津貼_不計日當</option>
                                        <option value="PSR003">誤餐津貼_業務代表</option>
                                        <option value="PSR007">誤餐津貼_主任</option>
                                        <option value="PSR002">誤餐津貼_經理</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="trf_fee" class="form-label">交通津貼職別</label>
                                    <select class="form-select" name="trf_fee">
                                        <option value="">請選擇誤餐費費用職別...</option>
                                        <option value="PSR001">交通津貼_業務代表</option>
                                        <option value="PSR005">交通津貼_主任 </option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="user_password1" class="form-label">密碼</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="user_password1" name="user_password1" placeholder="請輸入密碼" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">
                                        密碼欄位為必填.
                                    </div>
                                    @error('user_password1')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label for="user_password2" class="form-label">確認密碼</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="user_password2" placeholder="請再次輸入密碼" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword2">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">
                                        確認密碼欄位為必填.
                                    </div>
                                </div>
                            </div>
                
                            <hr class="my-4">

                            <div class="text-end">
                                <button class="btn btn-success" type="submit">確定存檔</button>
                                <a class="btn btn-light" href="{{ route('member.index') }}">回主畫面</a>
                            </div>

                            <div class='hidden'>                                
                                <input type="hidden" id="bossAuto" data-auto="{{ $boss_auto }}">
                                <input type="hidden" id="teamAuto" data-auto="{{ $team_auto }}">
                                <input type="hidden" id="facAuto" data-auto="{{ $fac_auto }}">
                                <input type="hidden" id="attribute1Auto" data-auto="{{ $attribute1_auto }}">
                            </div>                            
                        </form>
                    </div>
                </div>
                @include('layouts.modal')
            </div>
        </div>
        <script>
            var boss_auto= @json($boss_auto);
        </script>
        
        <script src="{{ asset('js/checkout.js') }}"></script>
    @endsection
</body>
</html>
