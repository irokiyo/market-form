<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>market</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>
<body>
    <header class="header">
        <h1 class="header__ttl"><img src="{{ asset('/images/Vector (2).png') }}" alt="ロゴ" class="tti-img"><img src="{{ asset('/images/Group.png') }}" alt="名前" class="tti-img">

        </h1>
        <form action="" class="search">
            <input type="text" class="search-text" name="keyword" placeholder="なにをお探しですか？">
        </form>
        <nav class="header__nav">
            <ul>
                <li class="nav__item">ログアウト</li>
                <li class="nav__item">マイページ</li>
                <li class="nav__item">出品</li>
            </ul>
        </nav>
    </header>
    <main class="main">
        @yield('content')
    </main>
</body>
</html>