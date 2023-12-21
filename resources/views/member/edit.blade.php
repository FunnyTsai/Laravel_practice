
{{-- 檢查傳送過來的資料 --}}
@isset($member)
    {{-- {{ dd($data['group']) }} --}}
    {{-- {{ dd($member['collector_name']) }}
    {{ dd($member['attribute1_name']) }} --}}

@endisset 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/member.css') }}">
    
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
    
    <script src="{{ asset('js/member/member.js') }}"></script>
    <script src="{{ asset('js/member/edit.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js') }}"></script>
</head>
<body>
    @extends('layouts.page')

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')
       

        @include('components.breadcrumb', ['page' => 'member', 'pageName' => '帳號', 'title' => '編輯'])

        <form class="needs-validation" action="{{route('member.update', $member)}}" novalidate method="post" required>
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">加入的群組</span>
                        <span class="badge bg-primary rounded-pill" id="groupCountBadge">{{ count($data['group_info']) }}</span>
                    </h4>

                    <div class="input-group">
                        <input id="group" type="text" class="form-control" placeholder="請輸入群組名稱(點選建議選項)">
                        <button id="groupSubmit" class="btn btn-primary">新增</button>
                    </div>

                    <div class="mt-lg-3">
                        <ul class="list-group mb-3" id="groupList">
                            {{-- 系統自動產生 --}}
                        </ul>
                    </div>
                </div>
                        
                <div class="col-md-7 col-lg-7">
                    <hr class="my-4">

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="user_id" class="form-label">帳號</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $member['USER_ID'] }}" placeholder="" maxlength="7" disabled>
                            <div class="invalid-feedback">
                                帳號欄位為必填.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="user_name" class="form-label">姓名</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $member['USER_NAME'] }}" placeholder="" required>
                            <div class="invalid-feedback">
                                姓名欄位為必填.
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                            <label for="user_group" class="form-label">部門</label>
                            <select class="form-select" name="user_group" required>
                                <option value="">請選擇部門...</option>
                                @foreach($data['group'] as $item)
                                    <option value='{{ $item -> VLS_CODE }}'
                                        @if($item->VLS_CODE == $member->USER_GROUP) selected 
                                        @endif>
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
                                    <option value='{{ $item -> VLS_CODE }}'
                                        @if($item->VLS_CODE == $member->USER_ZONE) selected 
                                        @endif>
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
                                @if ($member->ATTRIBUTE1 && isset($data['attribute1_name']))
                                    <input type="text" class="form-control" id="user_boss" name="user_boss" placeholder="請輸入主管姓名" value="{{ $member-> USER_BOSS }} {{ $member -> BOSS_NAME }}">
                                @else
                                    <input type="text" class="form-control" id="user_boss" name="user_boss" placeholder="請輸入主管姓名" value="">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="user_role" class="form-label">角色</label>
                            <select class="form-select" name="user_role" required>
                                <option value="">請選擇角色...</option>
                                @foreach($data['role'] as $item)
                                    <option value='{{ $item -> PHR_TYPE }}' 
                                        @if($item->PHR_TYPE == $member->USER_ROLE) selected 
                                        @endif>
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
                                <input type="text" class="form-control" id="team" name="team" placeholder="請輸入組別" value="{{ $member -> TEAM }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="attribute1" class="form-label">差勤員工編號</label>
                            <div class="input-group">                                        
                                @if ($member->ATTRIBUTE1 && isset($data['attribute1_name']))
                                    <input type="text" class="form-control" id="attribute1" name="attribute1" value="{{ $member->ATTRIBUTE1 }} {{ $data['attribute1_name']-> USER_NAME }}">
                                @else
                                    <input type="text" class="form-control" id="attribute1" name="attribute1" value="">
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">電子信箱</label>
                            <input type="email" class="form-control" name="user_mail" placeholder="yourname@arich.com.tw" value="{{ $member -> USER_MAIL }}">
                        </div>
                        
                        {{-- 原廠資料庫顯示英文、頁面顯示中文 --}}
                        <div class="col-sm-6">
                            <label for="orig_vendor" class="form-label">原廠</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="orig_vendor" name="orig_vendor" placeholder="請輸入原廠" value="{{ $member -> ORIG_VENDOR }}">
                            </div>
                        </div>
                    
                        <div class="col-md-6">
                            <label for="mail" class="form-label">標案訊息</label>
                            <select class="form-select" name="mail" required>
                                <option value="">請選擇標案訊息...</option>
                                <option value="Y"
                                    @if($member->MAIL == "Y") selected 
                                    @endif>是
                                </option>
                                <option value="N"
                                    @if($member->MAIL == "N") selected 
                                    @endif>否
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                標案訊息欄位為必填.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="salesrep_id" class="form-label">業務員ID</label>
                            <input type="text" class="form-control" name="salesrep_id" placeholder="" value="{{ $member ->SALESREP_ID }}">
                        </div>
                        
                        <div class="mb-3 col-md-3">
                            <label for="teacher_1" class="form-label">收款員ID</label>
                            <input type="text" class="form-control" name="collector_id" placeholder="" value="{{ $member->COLLECTOR_ID }}">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="teacher_1" class="form-label" style="color:white">I</label>
                            @if ($member->COLLECTOR_ID && isset($data['collector_name']))
                                <input type="text" class="form-control" id="collector_name" value="{{ $member->COLLECTOR_ID }} ({{ $data['collector_name']->NAME }})" style="color:red; font-weight:600" disabled>
                            @else
                                <input type="text" class="form-control" id="collector_name" value="{{ $member->COLLECTOR_ID }}" style="color:red; font-weight:600" disabled>
                            @endif
                        </div>
                    
                        <div class="col-md-6">
                            <label for="ord_amt" class="form-label">訂單金額</label>
                            <select class="form-select" name="ord_amt">
                                <option value="">請選擇訂單金額...</option>
                                <option value="Y" 
                                    @if($member->ORD_AMT == 'Y') selected 
                                    @endif>
                                    是
                                </option>
                                <option value="N" 
                                    @if($member->ORD_AMT == 'N') selected 
                                    @endif>
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
                                <option value="Y" 
                                    @if($member->ORD_DIS_AMT == 'Y') selected 
                                    @endif>
                                    是
                                </option>
                                <option value="N" 
                                    @if($member->ORD_DIS_AMT == 'N') selected 
                                    @endif>
                                    否
                                </option>
                            </select>
                        </div>
                    
                        <div class="col-md-6">
                            <label for="user_schedule" class="form-label">行事曆預設</label>
                            <select class="form-select" name="user_schedule">
                                <option value="">請選擇行事曆預設...</option>
                                <option value="1" 
                                    @if($member->USER_SCHEDULE == '1') selected 
                                    @endif>
                                    日
                                </option>
                                <option value="2"
                                    @if($member->USER_SCHEDULE == '2') selected 
                                    @endif>
                                    週
                                </option>
                                <option value="3"
                                    @if($member->USER_SCHEDULE == '3') selected 
                                    @endif>
                                    月
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="org_id" class="form-label">ORG預設</label>
                            <select class="form-select" name="org_id" required>
                                <option value="">請選擇ORG預設...</option>
                                @foreach($data['org'] as $item)
                                    <option value='{{ $item -> ORG_ID }}'
                                        @if($item->ORG_ID == $member->ORG_ID) selected 
                                        @endif>
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
                                <option value="PSR009"
                                    @if($member->MEAL_FEE == 'PSR009') selected 
                                    @endif>誤餐津貼_不計日當
                                </option>
                                <option value="PSR003"
                                    @if($member->MEAL_FEE == 'PSR003') selected 
                                    @endif>誤餐津貼_業務代表
                                </option>
                                <option value="PSR007"
                                    @if($member->MEAL_FEE == 'PSR007') selected 
                                    @endif>誤餐津貼_主任
                                </option>
                                <option value="PSR002"
                                    @if($member->MEAL_FEE == 'PSR002') selected 
                                    @endif>誤餐津貼_經理
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="trf_fee" class="form-label">交通津貼職別</label>
                            <select class="form-select" name="trf_fee">
                                <option value="">請選擇誤餐費費用職別...</option>
                                <option value="PSR001"
                                    @if($member->TRF_FEE == 'PSR001') selected 
                                    @endif>交通津貼_業務代表
                                </option>
                                <option value="PSR005"
                                    @if($member->TRF_FEE == 'PSR005') selected 
                                    @endif>交通津貼_主任
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="user_password1" class="form-label">密碼</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="user_password1" name="user_password1" placeholder="請輸入密碼">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="user_password2" class="form-label">確認密碼</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="user_password2" name="user_password2" placeholder="請再次輸入密碼">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword2">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
        
                    <hr class="my-4">

                    <div class="text-end">
                        {{-- <button class="btn btn-primary btn-lg" type="submit">Continue to checkout</button> --}}
                        <button id="saveButton" class="btn btn-success" type="submit">確定存檔</button>
                        <a class="btn btn-light" href="{{ route('member.index') }}">回主畫面</a>
                    </div>

                    <div class='hidden'>                                
                        <input type="hidden" id="bossAuto" data-auto="{{ $boss_auto }}">
                        <input type="hidden" id="teamAuto" data-auto="{{ $team_auto }}">
                        <input type="hidden" id="facAuto" data-auto="{{ $fac_auto }}">
                        <input type="hidden" id="attribute1Auto" data-auto="{{ $attribute1_auto }}">
                        <input type="hidden" id="groupAuto" data-auto="{{ $group_auto }}">
                        <input type="hidden" id="groupInfo" data-info="{{ $data['group_info'] }}">
                    </div> 
                </div>
            </div>
        </form>
        
        <script src="{{ asset('js/checkout.js') }}"></script>
    @endsection
</body>
</html>
