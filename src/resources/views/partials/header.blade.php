


<form action="" class="search">
    <input type="text" class="search-input" name="keyword" placeholder="なにをお探しですか？">
</form>
<nav class="header__nav">
    <ul class="header__nav__ul">
        <li >
            <form action="{{route('logout')}}" method="post">
                @csrf
                <button type="submit" class="nav__item">ログアウト</button>
            </form>
        </li>
        <li class="nav__item">マイページ</li>
        <li class="nav__item2">出品</li>
    </ul>
</nav>
