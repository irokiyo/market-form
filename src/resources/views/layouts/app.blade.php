<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    @yield('css')
</head>
<body>
    <header class="header">
        <a href="{{route('index')}}" class="header__link"><h1 class="header__ttl"><img src="{{ asset('/images/Vector (2).png') }}" alt="ロゴ" class="ttl-img1"><img src="{{ asset('/images/Group.png') }}" alt="名前" class="ttl-img2"></a>
        </h1>
        @yield('header')
    </header>
    <main class="main">
        @yield('content')
    </main>
</body>
</html>