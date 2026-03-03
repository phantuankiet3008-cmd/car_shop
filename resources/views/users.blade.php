@include('layouts.Header')
@include('layouts.Navbar')

@php
    $tab = $tab ?? 'overview';
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang người dùng</title>
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>

<div class="user-main">
    <aside class="user-sidebar">
        <ul>
        
        </ul>
    </aside>

    <section class="user-content">

        @if(session('msg'))
            <div class="alert success">
                {{ session('msg') }}
            </div>
        @endif

        @include('layouts.Footer')

    </section>
</div>

</body>
</html>