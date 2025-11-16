


<form action="" class="search">
    <input type="text" class="search-input" name="keyword" placeholder="なにをお探しですか？">
</form>
<nav class="header__nav">
    <ul class="header__nav__ul">
        <li >
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="nav__logout">ログアウト</button>
            </form>
        </li>
        <li class="nav__item"><a href="{{route('mypage')}}" class="nav__btn">マイページ</li>
        <li class="nav__item2"><a href="{{route('sell')}}" class="nav__item2-sell">出品</a></li>

    </ul>
</nav>
