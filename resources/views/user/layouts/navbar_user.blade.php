<nav class="main-nav">
    <ul class="menu">

        <li>
            <a href="{{ route('trangchu') }}">🏠TRANG CHỦ

            </a>
        </li>

        <li class="nav-product">

            <a href="{{ url('user/car_shop/danhsachsanpham') }}">
                🚗 SẢN PHẨM
            </a>





        </li>
 @if(session('user_id'))
 <li>
        <a href="{{ route('tranglaithu') }}">
            
            🗓️ĐẶT LỊCH LÁI THỬ
        </a>
 </li>
 <li>
     <a href="{{ route('datlichbaoduong') }}">
           
            🛠️ĐẶT LỊCH BẢO DƯỠNG
        </a>
 </li>
    @endif
        

        

        

    </ul>
</nav>