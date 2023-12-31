<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $webTitle }} | 久裕行動業務系統</title>
</head>
<body>
    <main class="d-flex flex-nowrap" style="overflow-y: auto;">    
        <!-- 左側工作區 -->
        @yield('sidebar')

        <!-- 右側工作區 -->
        <div class="flex-grow-1 p-3" style="margin-top:1.6%">
            @if(session('notice'))
                <div class="alert alert-success">
                    {{ session('notice') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        
            @if($errors->any())            
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('main')
        </div>
    </main>
</body>
</html>