


<form action="{{ url('/trang_admin/san_pham/sua/' . $data['xe']['id_Xe']) }}"
      method="POST" enctype="multipart/form-data">
    @csrf

    <div class="vfast-col-right">
        <h2 style="text-align:center;color:#0f172a;margin-bottom:20px">
            CHỈNH SỬA SẢN PHẨM
        </h2>

        <div class="vfast-edit-main">

            {{-- Ảnh đại diện --}}
            <div class="vfast-col-left">
                <h3>Ảnh đại diện hiện tại</h3>
                <img src="{{ asset('upload/anh_dai_dien/'.$data['xe']['Anh_Dai_Dien']) }}"
                     class="img-main-preview">
                <p style="color:#666;font-style:italic;margin-top:10px">
                    File: {{ $data['xe']['Anh_Dai_Dien'] }}
                </p>
            </div>

            {{-- Album ảnh theo màu --}}
            <div class="vfast-col-mid">
                <h3 style="border-left:4px solid #3b82f6;padding-left:10px">
                    Album ảnh chi tiết theo màu
                </h3>

                @php $currentColor = ''; @endphp

                @if(!empty($data['list_anh_mau']))
                    @foreach($data['list_anh_mau'] as $anh)
                        @if($currentColor !== $anh['Ten_Mau'])
                            @if($currentColor !== '')
                                    </div>
                                </div>
                            @endif
                            @php $currentColor = $anh['Ten_Mau']; @endphp
                            <div class="color-group">
                                <strong>Màu: {{ $currentColor }}</strong>
                                <div class="horizontal-images">
                        @endif

                        <div class="img-item">
                            <img src="{{ asset('upload/anh_xe_mau/'.$anh['Hinh_Anh_Xe_Mau']) }}"
                                 width="150" height="100"
                                 onclick="openZoom(this.src)">
                        </div>
                    @endforeach
                                </div>
                            </div>
                @else
                    <p>Chưa có ảnh chi tiết.</p>
                @endif

                {{-- Giá theo màu --}}
                <h4 style="margin-top:15px">Giá theo từng màu</h4>
                @foreach($data['ds_mau'] as $m)
                    <div class="mau-edit">
                        <span style="width:100px;display:inline-block">
                            {{ $m['Ten_Mau'] }}
                        </span>
                        <input type="text"
                               name="gia_mau[{{ $m['id_Xe_Mau'] }}]"
                               value="{{ number_format($m['Gia'],0,',','.') }}">
                    </div>
                @endforeach
            </div>

            {{-- Form chỉnh sửa --}}
            <div class="vfast-col-right">
                <div class="form-group">
                    <label>Tên sản phẩm:</label>
                    <input type="text" name="ten_xe"
                           value="{{ $data['xe']['Ten_Xe'] }}" required>
                </div>

                <div class="form-group">
                    <label>Mô tả sản phẩm:</label>
                    <textarea name="mo_ta">{{ $data['xe']['Mo_Ta'] }}</textarea>
                </div>

                <div style="display:flex;gap:20px">
                    <div class="form-group" style="flex:1">
                        <label>Loại xe:</label>
                        <select name="id_loai">
                            <option value="{{ $data['xe']['id_Loai_Xe'] }}">
                                {{ $data['xe']['Ten_Loai_Xe'] }} (Hiện tại)
                            </option>
                            @foreach($data['List_Loai'] as $loai)
                                <option value="{{ $loai['id_Loai_xe'] }}">
                                    {{ $loai['Ten_Loai_Xe'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="flex:1">
                        <label>Thương hiệu:</label>
                        <select name="id_thuong_hieu">
                            <option value="{{ $data['xe']['id_Thuong_Hieu'] }}">
                                {{ $data['xe']['Ten_Thuong_Hieu'] }} (Hiện tại)
                            </option>
                            @foreach($data['List_ThuongHieu'] as $th)
                                <option value="{{ $th['id_Thuong_Hieu'] }}">
                                    {{ $th['Ten_Thuong_Hieu'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group" style="background:#fff3cd;padding:15px;margin-top:15px">
                    <label>Thay đổi ảnh đại diện:</label>
                    <input type="file" name="new_anh_dai_dien">
                </div>

                <button class="btn-update">LƯU THAY ĐỔI</button>
                <a href="{{ url('/trang_admin/san_pham') }}" class="btn-cancel">
                    Quay lại
                </a>
            </div>
        </div>
    </div>
</form>


{{-- Zoom ảnh --}}
<div id="zoomModal" onclick="this.style.display='none'">
    <img id="zoomImg"
         style="max-width:90%;max-height:90%;border:4px solid #fff">
</div>

<script>
function openZoom(src){
    document.getElementById('zoomModal').style.display='flex';
    document.getElementById('zoomImg').src = src;
}
</script>

