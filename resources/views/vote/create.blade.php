
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
    <link rel="stylesheet" href="{{ asset('css/vote.css') }}">

    <!-- 引入 jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>

    <!-- 引入 Popper.js -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>

    <!-- 引入 Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>   

    <script src="{{ asset('js/vote/vote.js') }}"></script>  
    <script src="{{ asset('js/vote/create.js') }}"></script> 
</head>
<body>
    @extends('layouts.page', ['webTitle' => '投票資料'])

    @section('sidebar')
        @include('layouts.sidebar')
    @endsection

    @section('main')

        @include('components.breadcrumb', ['page' => 'vote', 'pageName' => '投票資料維護', 'title' => '新增'])
     
        <form id="voteForm" class="needs-validation" action="{{route('vote.store')}}" method="post" required>
            @csrf
            <div class="col-md-12 col-lg-12">
                <hr class="my-4">
                    
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <label for="VOTE_DATE" class="form-label">建立日期</label>
                        <input type="date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="VOTE_DATE" readonly required>
                    </div>
                    <div class="col-sm-6">
                        <label for="CREATE_BY" class="form-label">建立者</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->USER_NAME ?? '未登入' }}" name="CREATE_BY" readonly required>
                    </div>
                </div>
                    
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <label for="START_DATE" class="form-label">投票期間(起)</label>
                        <input type="date" class="form-control" value="{{old('START_DATE')}}" id="START_DATE" name="START_DATE" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="END_DATE" class="form-label">投票期間(迄)</label>
                        <input type="date" class="form-control" value="{{old('END_DATE')}}" id="END_DATE" name="END_DATE" required>
                    </div>
                </div>
                    
                <div class="row g-4 mb-4">
                    <div class="col-sm-12">
                        <label for="selectedDepartments" class="form-label mb-2">部門</label>
                        <div class="d-flex align-items-center">
                            <div class="col-md-11">
                                <input type="hidden" id="deptcodesCodeInput" name="deptcodesCodeInput">
                                <textarea id="departmentInput" name="departmentInput" type="text" class="form-control" rows="6" cols="50" readonly required></textarea>
                            </div>
                            <div class="col-md-1">
                                <a data-bs-toggle="modal" data-bs-target="#departmentModal" class="btn btn-success ms-3 departmentBtn">選擇</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-12">
                        <label for="TILE" class="form-label">標題</label>
                        <textarea class="form-control" value="{{old('TITLE')}}" name="TITLE" rows="1" cols="50" required></textarea>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-12">
                        <label for="TITLE_DESC" class="form-label">描述</label>
                        <textarea class="form-control" value="{{old('TITLE_DESC')}}" name="TITLE_DESC" rows="6" cols="50" required></textarea>
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
            </div>                   
        </form> 
                
        <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="departmentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="departmentModalLabel">選擇部門</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-5 text-center">
                                    <h5>可選部門</h5>
                                    <select id="allDepartments" multiple class="form-control department-list">
                                        @foreach ($allDept as $dept)
                                            <option value="{{ $dept->DEPT_CODE }}" data-deptname="{{ $dept->DEPT_NAME }}">{{ $dept->DEPT_NAME }}</option>                                            
                                        @endforeach
                                    </select>                                    
                                    <button class="btn btn-secondary mt-2" id="btnAddAll">全部加入 -></button>
                                </div>
                                <div class="col-md-2 text-center d-flex flex-column align-items-center justify-content-center">
                                    <button class="btn btn-primary" id="btnAdd">加入 ➡</button>
                                    <button class="btn btn-primary mt-2" id="btnRemove">⬅ 退回</button>
                                </div>
                                <div class="col-md-5 text-center">
                                    <h5>已選部門</h5>
                                    <select id="selectedDepartments" multiple class="form-control department-list"></select>
                                    <button class="btn btn-secondary mt-2" id="btnRemoveAll"><- 全部退回</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="selectDepartments" data-bs-dismiss="modal">確認</button>
                    </div>                    
                </div>
            </div>
        </div>  
    @endsection    
    
    <script src="{{ asset('js/checkout.js') }}"></script>
</body>
</html>
