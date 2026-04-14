<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm mới - Tối ưu Cloudinary</title>
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
    <style>
    /* Ép buộc trình duyệt luôn hiện thanh cuộn nếu nội dung dài */
    html, body { 
        overflow-y: auto !important; 
        height: auto !important; 
        margin: 0;
        padding: 0;
    }

    .box { 
        max-width: 900px; 
        margin: 40px auto; /* Tăng margin để không bị sát mép trên */
        font-family: Arial, sans-serif; 
        border: 1px solid #ccc; 
        padding: 20px; 
        border-radius: 8px; 
        background: white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    /* Các phần còn lại giữ nguyên */
    .mau_xe_item { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9; }
    .color-preview { width: 30px; height: 30px; display: inline-block; vertical-align: middle; border: 1px solid #000; margin-left: 10px; border-radius: 4px; }
    .flex-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .btn-main { padding: 12px 30px; background: #10b981; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 16px; }
    .btn-upload { background: #3b82f6; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; }
    .preview-img { width: 60px; height: 45px; object-fit: cover; border: 1px solid #ddd; margin-top: 5px; border-radius: 4px; }
    .album-preview { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 10px; }
    
    hr { margin: 20px 0; border: 0; border-top: 1px solid #eee; }
</style>
</head>
<body>

<div class="box">
    <h2 style="text-align: center; color: #1e293b;">THÊM SẢN PHẨM Ô TÔ MỚI</h2>

    <form action="{{ url('/trang_admin/san_pham/them') }}" method="POST">
        @csrf

        <div class="flex-row">
            <input type="text" name="ten_xe" placeholder="Tên xe (VD: VinFast VF8)" style="flex: 2" required>
            <select name="loai_xe" style="flex: 1" required>
                <option value="">-- Loại xe --</option>
                @foreach($data['ds_loai'] as $row)
                    <option value="{{ $row['id_Loai_xe'] }}">{{ $row['Ten_Loai_Xe'] }}</option>
                @endforeach
            </select>
            <select name="thuong_hieu" style="flex: 1" required>
                <option value="">-- Thương hiệu --</option>
                @foreach($data['ds_thuong_hieu'] as $row)
                    <option value="{{ $row['id_Thuong_Hieu'] }}">{{ $row['Ten_Thuong_Hieu'] }}</option>
                @endforeach
            </select>
        </div>

        <textarea name="mo_ta" placeholder="Mô tả chi tiết..." style="width: 100%; height: 60px; margin-bottom: 15px;"></textarea>

        <div class="flex-row" style="background: #eff6ff; padding: 15px; border-radius: 5px;">
            <div style="flex: 1">
                <label><b>Ảnh đại diện:</b></label><br>
                <button type="button" class="btn-upload" onclick="uploadSingle('anh_dai_dien_url', 'view_avatar')">Chọn Ảnh</button>
                <input type="hidden" name="anh_dai_dien_url" id="anh_dai_dien_url" required>
                <div id="view_avatar"></div>
            </div>
            <div style="flex: 1">
                <label><b>File 3D (.glb):</b></label><br>
                <button type="button" class="btn-upload" style="background:#6366f1" onclick="uploadSingle('anh_3d_url', 'view_3d', 'san_pham_3d')">Chọn File 3D</button>
                <input type="hidden" name="anh_3d_url" id="anh_3d_url">
                <div id="view_3d"></div>
            </div>
        </div>

        <hr>
        <h3>Cấu hình màu sắc & Giá</h3>

        <div id="ds_mau_xe">
            <div class="mau_xe_item" id="item_0">
                <h4 style="margin-top: 0; color: #3b82f6;">Màu mặc định</h4>
                <div class="flex-row">
                    <select name="mau_xe[0]" onchange="previewColor(this)" required style="flex: 1">
                        <option value="">-- Chọn màu --</option>
                        @foreach($data['ds_mau'] as $mau)
                            <option value="{{ $mau['id_Mau'] }}" data-color="{{ $mau['Ma_Mau'] }}">{{ $mau['Ten_Mau'] }}</option>
                        @endforeach
                    </select>
                    <div class="color-preview"></div>
                    <button type="button" onclick="quickAddColor(this)">+</button>
                </div>

                <div class="flex-row">
                    <input type="number" name="gia_mau[0]" placeholder="Giá bán" style="flex:1" required>
                    <input type="number" name="so_luong[0]" value="1" style="flex:1" required>
                </div>

                <div style="margin-top: 10px;">
                    <label>Album ảnh màu này:</label><br>
                    <button type="button" class="btn-upload" style="background:#f59e0b" onclick="uploadMultiple(0)">Thêm Ảnh Album</button>
                    <div id="album_urls_0"></div> <div id="album_preview_0" class="album-preview"></div>
                </div>
            </div>
        </div>

        <button type="button" onclick="themMau()" style="margin-bottom: 20px;">+ Thêm biến thể màu khác</button>

        <div style="text-align: center;">
            <button type="submit" class="btn-main">LƯU SẢN PHẨM</button>
        </div>
    </form>
</div>

<script>
let colorIndex = 1;
const cloudName = 'dht18l0rh'; 
const uploadPreset = 'ml_default';

// 1. Upload ảnh đơn (Avatar/3D)
function uploadSingle(inputId, viewId, folder = 'san_pham') {
    cloudinary.openUploadWidget({
        cloudName: cloudName, uploadPreset: uploadPreset, folder: folder, multiple: false
    }, (err, res) => {
        if (!err && res && res.event === "success") {
            document.getElementById(inputId).value = res.info.secure_url;
            document.getElementById(viewId).innerHTML = `<img src="${res.info.secure_url}" class="preview-img">`;
        }
    });
}

// 2. Upload nhiều ảnh cho Album của từng màu
function uploadMultiple(idx) {
    cloudinary.openUploadWidget({
        cloudName: cloudName, uploadPreset: uploadPreset, folder: 'anh_xe_mau', multiple: true
    }, (err, res) => {
        if (!err && res && res.event === "success") {
            const url = res.info.secure_url;
            // Tạo input hidden
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `anh_mau_urls[${idx}][]`;
            input.value = url;
            document.getElementById(`album_urls_${idx}`).appendChild(input);
            // Hiện preview
            document.getElementById(`album_preview_${idx}`).innerHTML += `<img src="${url}" class="preview-img">`;
        }
    });
}

function previewColor(sel){
    const color = sel.options[sel.selectedIndex].getAttribute('data-color');
    sel.nextElementSibling.style.backgroundColor = color || 'transparent';
}

function themMau(){
    const div = document.createElement("div");
    div.className = "mau_xe_item";
    div.innerHTML = `
        <h4 style="margin-top: 0; color: #64748b;">Biến thể màu mới</h4>
        <div class="flex-row">
            <select name="mau_xe[${colorIndex}]" onchange="previewColor(this)" required style="flex: 1">
                <option value="">-- Chọn màu --</option>
                ${document.querySelector('select[name="mau_xe[0]"]').innerHTML}
            </select>
            <div class="color-preview"></div>
        </div>
        <div class="flex-row">
            <input type="number" name="gia_mau[${colorIndex}]" placeholder="Giá" style="flex:1" required>
            <input type="number" name="so_luong[${colorIndex}]" value="1" style="flex:1" required>
        </div>
        <div style="margin-top: 10px;">
            <button type="button" class="btn-upload" style="background:#f59e0b" onclick="uploadMultiple(${colorIndex})">Thêm Ảnh Album</button>
            <div id="album_urls_${colorIndex}"></div>
            <div id="album_preview_${colorIndex}" class="album-preview"></div>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="color:red; border:none; background:none; cursor:pointer; margin-top:10px">Xóa màu này</button>
    `;
    document.getElementById("ds_mau_xe").appendChild(div);
    colorIndex++;
}

// Tận dụng hàm quickAddColor cũ của bạn
function quickAddColor(btn) {
    const name = prompt("Tên màu mới:");
    const code = prompt("Mã HEX (VD: #ff0000):", "#");
    if (name && code.startsWith("#")) {
        const sel = btn.parentElement.querySelector('select');
        const opt = new Option(name + " (Mới)", `NEW|${name}|${code}`);
        opt.setAttribute('data-color', code);
        sel.add(opt);
        opt.selected = true;
        previewColor(sel);
    }
}
</script>
</body>
</html>