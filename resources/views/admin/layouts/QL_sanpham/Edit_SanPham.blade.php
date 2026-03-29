<script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>

<style>
    /* Giữ nguyên style 3 cột của bạn và thêm các class bổ trợ */
    .vfast-edit-main { display: flex; gap: 20px; align-items: flex-start; background: #fff; padding: 20px; border-radius: 12px; }
    .vfast-col-left, .vfast-col-mid, .vfast-col-right { flex: 1; min-width: 0; }
    .vfast-col-mid { border-left: 1px solid #eee; border-right: 1px solid #eee; padding: 0 20px; }
    
    .img-main-preview { width: 100%; border-radius: 8px; border: 1px solid #ddd; object-fit: cover; aspect-ratio: 4/3; }
    .color-group { background: #f8fafc; padding: 12px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #e2e8f0; }
    .album-preview { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 8px; }
    
    .img-item-wrapper { position: relative; width: 60px; height: 45px; }
    .img-item-wrapper img { width: 100%; height: 100%; object-fit: cover; border-radius: 4px; border: 1px solid #ccc; }
    .btn-remove-old { position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; width: 16px; height: 16px; font-size: 10px; cursor: pointer; }

    input, select, textarea { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; margin-top: 5px; box-sizing: border-box; }
    .btn-cloud { background: #3b82f6; color: white; border: none; padding: 7px 12px; border-radius: 6px; cursor: pointer; font-size: 12px; margin-top: 5px; }
    .btn-update { width: 100%; background: #0f172a; color: white; padding: 15px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 20px; }
</style>

<form action="{{ url('/trang_admin/san_pham/sua/' . $data['xe']['id_Xe']) }}" method="POST">
    @csrf
    <h2 style="text-align:center; color:#0f172a; margin: 30px 0;">CHỈNH SỬA SẢN PHẨM</h2>

    <div class="vfast-edit-main">
        {{-- CỘT 1: ẢNH ĐẠI DIỆN & 3D --}}
        <div class="vfast-col-left">
            <h3>Ảnh đại diện & 3D</h3>
            <div id="view_avatar">
                <img src="{{ $data['xe']['Anh_Dai_Dien'] }}" class="img-main-preview">
            </div>
            
            <div style="margin-top:20px; background:#fef9c3; padding:15px; border-radius:8px; border: 1px solid #fde68a;">
                <label style="font-weight:600;">Thay ảnh đại diện mới:</label><br>
                <button type="button" class="btn-cloud" onclick="uploadAvatar()">Chọn từ Cloudinary</button>
                <input type="hidden" name="new_anh_dai_dien_url" id="new_anh_dai_dien_url">
            </div>

            <div style="margin-top:15px; background:#f1f5f9; padding:15px; border-radius:8px; border: 1px solid #e2e8f0;">
                <label style="font-weight:600;">Thay file 3D mới (.glb):</label><br>
                <div id="name_3d" style="font-size: 11px; color: #64748b; margin-bottom: 5px;">{{ basename($data['xe']['Anh_3d']) }}</div>
                <button type="button" class="btn-cloud" style="background:#6366f1" onclick="upload3D()">Chọn File 3D</button>
                <input type="hidden" name="new_anh_3d_url" id="new_anh_3d_url">
            </div>
        </div>

        {{-- CỘT 2: BIẾN THỂ & ALBUM --}}
        <div class="vfast-col-mid">
            <h3 style="border-left:4px solid #3b82f6; padding-left:10px">Biến thể & Album</h3>

            <div style="max-height: 500px; overflow-y: auto; padding-right: 5px;">
                {{-- DANH SÁCH MÀU ĐANG CÓ --}}
                @foreach($data['ds_mau'] as $m)
                    <div class="color-group">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <strong style="font-size:13px">{{ $m['Ten_Mau'] }}</strong>
                            <button type="button" onclick="deleteColor({{ $m['id_Xe_Mau'] }})" style="color:red; border:none; background:none; cursor:pointer;">✕ Xóa</button>
                        </div>
                        
                        <div style="display:flex; gap:5px; margin-top:5px;">
                            <input type="text" name="gia_mau[{{ $m['id_Xe_Mau'] }}]" value="{{ number_format($m['Gia'],0,',','.') }}" class="price-input" placeholder="Giá">
                            <input type="number" name="so_luong[{{ $m['id_Xe_Mau'] }}]" value="{{ $m['So_Luong'] }}" style="width:60px" placeholder="SL">
                        </div>

                        {{-- Album ảnh hiện tại --}}
                        <div class="album-preview" id="album_old_{{ $m['id_Xe_Mau'] }}">
                            @foreach($data['list_anh_mau'] as $anh)
                                @if($anh['id_Xe_Mau'] == $m['id_Xe_Mau'])
                                    <div class="img-item-wrapper" id="box_anh_{{ $anh['id_Xe_Mau_Anh'] }}">
                                        <img src="{{ $anh['Hinh_Anh_Xe_Mau'] }}" onclick="openZoom(this.src)">
                                        <button type="button" class="btn-remove-old" onclick="markDelete({{ $anh['id_Xe_Mau_Anh'] }})">×</button>
                                        <input type="hidden" name="delete_anh_ids[]" id="input_del_{{ $anh['id_Xe_Mau_Anh'] }}" value="">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <button type="button" class="btn-cloud" style="background:#10b981; width:100%" onclick="uploadToOld({{ $m['id_Xe_Mau'] }})">+ Thêm ảnh vào album</button>
                        <div id="container_more_{{ $m['id_Xe_Mau'] }}"></div>
                    </div>
                @endforeach

                {{-- KHU VỰC THÊM BIẾN THỂ MỚI --}}
                <div id="new-color-area"></div>
                <button type="button" onclick="addNewColor()" style="background:#3b82f6; color:#fff; border:none; padding:12px; width:100%; border-radius:6px; cursor:pointer; font-weight:bold;">+ THÊM MÀU MỚI</button>
            </div>
        </div>

        {{-- CỘT 3: THÔNG TIN CHUNG --}}
        <div class="vfast-col-right">
            <h3>Thông tin chung</h3>
            <label>Tên sản phẩm:</label>
            <input type="text" name="ten_xe" value="{{ $data['xe']['Ten_Xe'] }}" required>

            <div style="display:flex; gap:10px; margin-top:10px;">
                <div style="flex:1">
                    <label>Loại xe:</label>
                    <select name="id_loai">
                        @foreach($data['List_Loai'] as $loai)
                            <option value="{{ $loai['id_Loai_xe'] }}" {{ $loai['id_Loai_xe'] == $data['xe']['id_Loai_Xe'] ? 'selected' : '' }}>{{ $loai['Ten_Loai_Xe'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex:1">
                    <label>Thương hiệu:</label>
                    <select name="id_thuong_hieu">
                        @foreach($data['List_ThuongHieu'] as $th)
                            <option value="{{ $th['id_Thuong_Hieu'] }}" {{ $th['id_Thuong_Hieu'] == $data['xe']['id_Thuong_Hieu'] ? 'selected' : '' }}>{{ $th['Ten_Thuong_Hieu'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-top:10px;">
                <label>Mô tả:</label>
                <textarea name="mo_ta" rows="12">{{ $data['xe']['Mo_Ta'] }}</textarea>
            </div>

            <button type="submit" class="btn-update">LƯU TẤT CẢ THAY ĐỔI</button>
        </div>
    </div>
</form>

<div id="zoomModal" onclick="this.style.display='none'" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); display:none; justify-content:center; align-items:center; z-index:10000;"><img id="zoomImg" style="max-width:90%; max-height:90%; border:3px solid #fff;"></div>
<script>
const cloudName = 'dht18l0rh'; 
const uploadPreset = 'ml_default';
let newIdx = 0;

// 1. Upload Avatar
function uploadAvatar() {
    cloudinary.openUploadWidget({ cloudName, uploadPreset, folder: 'anh_dai_dien', multiple: false }, (err, res) => {
        if (!err && res.event === "success") {
            document.getElementById('new_anh_dai_dien_url').value = res.info.secure_url;
            document.getElementById('view_avatar').innerHTML = `<img src="${res.info.secure_url}" class="img-main-preview">`;
        }
    });
}

// 2. Upload 3D
function upload3D() {
    cloudinary.openUploadWidget({ cloudName, uploadPreset, folder: 'san_pham_3d', resourceType: 'raw' }, (err, res) => {
        if (!err && res.event === "success") {
            document.getElementById('new_anh_3d_url').value = res.info.secure_url;
            document.getElementById('name_3d').innerText = "Đã chọn: " + res.info.original_filename;
        }
    });
}

// 3. Quản lý ảnh cũ

function markDelete(id, url) {
    if(confirm("Xóa ảnh này khỏi hệ thống và Cloudinary?")) {
        // 1. Đánh dấu ID để xóa trong Database
        document.getElementById('input_del_' + id).value = id;
        
        // 2. Tạo input ẩn để gửi URL ảnh lên Server xử lý xóa trên Cloud
        const inputCloud = document.createElement('input');
        inputCloud.type = 'hidden';
        inputCloud.name = 'delete_cloudinary_urls[]';
        inputCloud.value = url;
        document.querySelector('form').appendChild(inputCloud);

        // 3. Hiệu ứng giao diện
        document.getElementById('box_anh_' + id).style.opacity = '0.3';
        document.getElementById('box_anh_' + id).style.pointerEvents = 'none';
    }
}
function uploadToOld(id_xm) {
    cloudinary.openUploadWidget({ cloudName, uploadPreset, folder: 'anh_xe_mau', multiple: true }, (err, res) => {
        if (!err && res.event === "success") {
            const url = res.info.secure_url;
            const input = document.createElement('input');
            input.type = 'hidden'; input.name = `more_anh_mau_urls[${id_xm}][]`; input.value = url;
            document.getElementById('container_more_'+id_xm).appendChild(input);
            document.getElementById('album_old_'+id_xm).innerHTML += `<img src="${url}" width="60" height="45" style="object-fit:cover; border-radius:4px;">`;
        }
    });
}

// 4. Thêm biến thể mới hoàn toàn (Đồng bộ trang thêm)
function addNewColor() {
    const area = document.getElementById('new-color-area');
    const div = document.createElement('div');
    div.className = "color-group";
    div.style = "background:#eff6ff; border:1px dashed #3b82f6;";
    
    div.innerHTML = `
        <div style="display:flex; gap:5px; margin-bottom:8px;">
            <select name="new_ten_mau[]" onchange="previewColor(this)" style="flex:2;" required>
                <option value="">-- Chọn màu --</option>
                @foreach($data['ds_mau_xe'] as $m)
                    <option value="{{ $m['id_Mau'] }}" data-color="{{ $m['Ma_Mau'] }}">{{ $m['Ten_Mau'] }}</option>
                @endforeach
            </select>
            <div class="color-preview" style="width:30px; height:30px; border:1px solid #ccc; border-radius:4px; margin-top:5px;"></div>
            <button type="button" onclick="quickAddColor(this)" style="margin-top:5px;">+</button>
            <button type="button" onclick="this.parentElement.parentElement.remove()" style="color:red; border:none; background:none; cursor:pointer; margin-top:5px;">✕</button>
        </div>
        <div style="display:flex; gap:5px;">
            <input type="text" name="new_gia_mau[]" placeholder="Giá" class="price-input" required>
            <input type="number" name="new_so_luong[]" value="1" style="width:60px">
        </div>
        <button type="button" class="btn-cloud" style="background:#f59e0b; width:100%" onclick="uploadNewAlbum(${newIdx})">Chọn Album Ảnh</button>
        <div id="new_urls_${newIdx}"></div>
        <div id="new_preview_${newIdx}" class="album-preview"></div>
    `;
    area.appendChild(div);
    newIdx++;
    initPriceFormat();
}

function uploadNewAlbum(idx) {
    cloudinary.openUploadWidget({ cloudName, uploadPreset, folder: 'anh_xe_mau', multiple: true }, (err, res) => {
        if (!err && res.event === "success") {
            const url = res.info.secure_url;
            const input = document.createElement('input');
            input.type = 'hidden'; input.name = `new_anh_mau_urls[${idx}][]`; input.value = url;
            document.getElementById(`new_urls_${idx}`).appendChild(input);
            document.getElementById(`new_preview_${idx}`).innerHTML += `<img src="${url}" width="50" height="40" style="object-fit:cover; border-radius:4px;">`;
        }
    });
}

function quickAddColor(btn) {
    const name = prompt("Tên màu mới:");
    const code = prompt("Mã HEX (VD: #ff0000):", "#");
    if (name && code.startsWith("#")) {
        const sel = btn.parentElement.querySelector('select');
        const opt = new Option(name + " (Mới)", `NEW|${name}|${code}`);
        opt.setAttribute('data-color', code);
        sel.add(opt); opt.selected = true;
        btn.parentElement.querySelector('.color-preview').style.backgroundColor = code;
    }
}

function previewColor(sel) {
    const color = sel.options[sel.selectedIndex].getAttribute('data-color');
    sel.nextElementSibling.style.backgroundColor = color || 'transparent';
}

function initPriceFormat() {
    document.querySelectorAll('.price-input').forEach(el => {
        el.oninput = (e) => {
            let v = e.target.value.replace(/\D/g, "");
            e.target.value = v.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        };
    });
}
function openZoom(src) { document.getElementById('zoomModal').style.display='flex'; document.getElementById('zoomImg').src=src; }
initPriceFormat();
</script>