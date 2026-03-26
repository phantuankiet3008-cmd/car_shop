<style>
    /* 1. CSS Giao diện 3 cột */
    .vfast-edit-main { display: flex; gap: 20px; align-items: flex-start; background: #fff; padding: 20px; border-radius: 12px; }
    .vfast-col-left, .vfast-col-mid, .vfast-col-right { flex: 1; min-width: 0; }
    .vfast-col-mid { border-left: 1px solid #eee; border-right: 1px solid #eee; padding: 0 20px; }
    
    .img-main-preview { width: 100%; border-radius: 8px; border: 1px solid #ddd; object-fit: cover; aspect-ratio: 4/3; }
    .color-group { background: #f8fafc; padding: 10px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #e2e8f0; }
    .horizontal-images { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 8px; }
    .img-item img { border-radius: 4px; cursor: zoom-in; border: 1px solid #ccc; transition: 0.2s; }
    .img-item img:hover { border-color: #3b82f6; }

    input, select, textarea { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; margin-top: 5px; box-sizing: border-box; }
    .btn-update { width: 100%; background: #0f172a; color: white; padding: 15px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 20px; }
    
    /* 2. Fix lỗi Zoom Modal */
    #zoomModal { 
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
        background: rgba(0,0,0,0.85); display: none; /* Mặc định ẩn */
        justify-content: center; align-items: center; z-index: 10000; cursor: zoom-out;
    }
    #zoomImg { max-width: 90%; max-height: 90%; border: 4px solid #fff; border-radius: 4px; }
</style>

<form action="{{ url('/trang_admin/san_pham/sua/' . $data['xe']['id_Xe']) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2 style="text-align:center; color:#0f172a; margin: 30px 0;">CHỈNH SỬA SẢN PHẨM</h2>

    <div class="vfast-edit-main">
        {{-- CỘT 1: ẢNH ĐẠI DIỆN & 3D --}}
        <div class="vfast-col-left">
            <h3>Ảnh đại diện</h3>
            <img src="{{ $data['xe']['Anh_Dai_Dien'] }}" class="img-main-preview">
            
            <div style="margin-top:20px; background:#fef9c3; padding:15px; border-radius:8px;">
                <label style="font-weight:600;">Thay ảnh đại diện mới:</label>
                <input type="file" name="new_anh_dai_dien">
            </div>

            <div style="margin-top:15px; background:#f1f5f9; padding:15px; border-radius:8px;">
                <label style="font-weight:600;">Thay file 3D mới:</label>
                <input type="file" name="new_anh_3d">
            </div>
        </div>

        {{-- CỘT 2: ALBUM & GIÁ THEO MÀU --}}
        <div class="vfast-col-mid">
            <h3 style="border-left:4px solid #3b82f6; padding-left:10px">Biến thể & Album</h3>

            <div style="max-height: 450px; overflow-y: auto; padding-right: 5px;">
                @php $currentColor = ''; @endphp
                @if(!empty($data['list_anh_mau']))
                    @foreach($data['list_anh_mau'] as $anh)
                        @if($currentColor !== $anh['Ten_Mau'])
                            @if($currentColor !== '') </div> </div> @endif
                            @php $currentColor = $anh['Ten_Mau']; @endphp
                            <div class="color-group">
                                <strong style="font-size:13px">Màu: {{ $currentColor }}</strong>
                                <div class="horizontal-images">
                        @endif
                        <div class="img-item">
                            <img src="{{ $anh['Hinh_Anh_Xe_Mau'] }}" width="60" height="45" onclick="openZoom(this.src)">
                        </div>
                    @endforeach
                    </div> </div>
                @endif

                <h4 style="margin: 20px 0 10px; color:#64748b">Cập nhật màu đã có</h4>
                @foreach($data['ds_mau'] as $m)
                    <div style="display:flex; align-items:center; gap:5px; margin-bottom:8px; background:#fff; border:1px solid #eee; padding:5px; border-radius:6px;">
                        <span style="flex:1; font-weight:600; font-size:12px;">{{ $m['Ten_Mau'] }}</span>
                        <input type="text" name="gia_mau[{{ $m['id_Xe_Mau'] }}]" value="{{ number_format($m['Gia'],0,',','.') }}" style="width:90px; margin:0; padding:5px;" class="price-input">
                        <input type="number" name="so_luong[{{ $m['id_Xe_Mau'] }}]" value="{{ $m['So_Luong'] }}" style="width:50px; margin:0; padding:5px;">
                        {{-- FIX LỖI XÓA: Gọi hàm deleteColor --}}
                        <button type="button" onclick="deleteColor({{ $m['id_Xe_Mau'] }})" style="background:#fee2e2; color:#ef4444; border:none; padding:5px 8px; border-radius:4px; cursor:pointer;">✕</button>
                    </div>
                @endforeach

                <div id="new-color-area" style="margin-top:20px;"></div>
                <button type="button" onclick="addNewColor()" style="background:#3b82f6; color:#fff; border:none; padding:12px; width:100%; border-radius:6px; cursor:pointer; font-weight:bold;">+ THÊM MÀU MỚI</button>
            </div>
        </div>

        {{-- CỘT 3: THÔNG TIN CHI TIẾT --}}
        <div class="vfast-col-right">
            <h3>Thông tin chung</h3>
            <label>Tên sản phẩm:</label>
            <input type="text" name="ten_xe" value="{{ $data['xe']['Ten_Xe'] }}" required>

            <div style="display:flex; gap:10px; margin-top:10px;">
                <div style="flex:1">
                    <label>Loại xe:</label>
                    <select name="id_loai">
                        <option value="{{ $data['xe']['id_Loai_Xe'] }}">{{ $data['xe']['Ten_Loai_Xe'] }}</option>
                        @foreach($data['List_Loai'] as $loai)
                            <option value="{{ $loai['id_Loai_xe'] }}">{{ $loai['Ten_Loai_Xe'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex:1">
                    <label>Thương hiệu:</label>
                    <select name="id_thuong_hieu">
                        <option value="{{ $data['xe']['id_Thuong_Hieu'] }}">{{ $data['xe']['Ten_Thuong_Hieu'] }}</option>
                        @foreach($data['List_ThuongHieu'] as $th)
                            <option value="{{ $th['id_Thuong_Hieu'] }}">{{ $th['Ten_Thuong_Hieu'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-top:10px;">
                <label>Mô tả:</label>
                <textarea name="mo_ta" rows="6">{{ $data['xe']['Mo_Ta'] }}</textarea>
            </div>

            <button type="submit" class="btn-update">LƯU TẤT CẢ THAY ĐỔI</button>
        </div>
    </div>
</form>

{{-- 3. Fix lỗi Xóa - Form ẩn dùng để Submit lệnh Delete --}}
<form id="deleteColorForm" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

{{-- 4. Fix lỗi Zoom - Cấu trúc Modal --}}
<div id="zoomModal" onclick="this.style.display='none'">
    <img id="zoomImg" src="">
</div>
<script>
// 1. Xử lý Zoom ảnh
function openZoom(src){
    const modal = document.getElementById('zoomModal');
    const img = document.getElementById('zoomImg');
    modal.style.display = 'flex'; 
    img.src = src;
}

// 2. Xử lý Xóa biến thể cũ
function deleteColor(id){
    if(confirm("Xóa biến thể này sẽ xóa toàn bộ ảnh chi tiết liên quan. Bạn chắc chứ?")){
        let form = document.getElementById('deleteColorForm');
        form.action = "{{ url('/trang_admin/san_pham/xoa_mau') }}/" + id;
        form.submit();
    }
}

// 3. Xử lý Thêm màu mới
let newIdx = 0;
const danhSachMau = @json($data['ds_mau_xe']); 

function addNewColor() {
    const area = document.getElementById('new-color-area');
    const div = document.createElement('div');
    div.className = "new-color-item"; // Thêm class để dễ quản lý
    div.style = "background:#eff6ff; padding:12px; border:1px dashed #3b82f6; border-radius:8px; margin-bottom:10px;";
    
    let colorOptions = danhSachMau.map(m => `<option value="${m.Ten_Mau}">${m.Ten_Mau}</option>`).join('');

    div.innerHTML = `
        <div style="display:flex; gap:5px; margin-bottom:8px;">
            <select name="new_ten_mau[]" style="flex:2; margin:0; padding:8px;" required>
                <option value="">-- Chọn màu --</option>
                ${colorOptions}
            </select>
            <input type="text" name="new_gia_mau[]" placeholder="Giá" style="flex:2; margin:0; padding:8px;" class="price-input" required>
            <button type="button" onclick="this.parentElement.parentElement.remove()" style="color:red; border:none; background:none; cursor:pointer; font-weight:bold;">✕</button>
        </div>
        <label style="font-size:11px; color:#3b82f6">Chọn ảnh chi tiết cho màu này:</label>
        <input type="file" name="new_anh_mau[${newIdx}][]" multiple style="font-size:12px; margin-top:5px" required>
        <input type="hidden" name="new_so_luong[]" value="1">
    `;
    area.appendChild(div);
    
    // Gán lại sự kiện format tiền cho các ô input mới tạo
    initPriceFormat();
    newIdx++;
}

// 4. Hàm định dạng giá tiền (Dùng chung cho cũ và mới)
function initPriceFormat() {
    document.querySelectorAll('.price-input').forEach(el => {
        // Gỡ bỏ event cũ để tránh bị lặp (với các ô cũ)
        el.removeEventListener('input', formatHandler);
        el.addEventListener('input', formatHandler);
    });
}

function formatHandler(e) {
    let v = e.target.value.replace(/\D/g, "");
    e.target.value = v.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Chạy lần đầu khi load trang
initPriceFormat();
</script>