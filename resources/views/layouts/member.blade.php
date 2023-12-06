<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>帳號資料 | 久裕行動業務系統</title>
</head>
<body>
    <main class="d-flex flex-nowrap">    
        <!-- 左側工作區 -->
        @yield('sidebar')

        <!-- 右側工作區 -->
        <div class="flex-grow-1 p-3" style="overflow-y: auto; max-height: 90%;">
            @yield('main')
        </div>
    </main>
</body>
</html>