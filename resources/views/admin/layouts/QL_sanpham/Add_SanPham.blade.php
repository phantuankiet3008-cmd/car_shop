<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm mới</title>
    <style>
        .box { max-width: 900px; margin: 20px auto; font-family: Arial, sans-serif; border: 1px solid #ccc; padding: 20px; border-radius: 8px; }
        .mau_xe_item { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background: #f9f9f9; position: relative; }
        .color-preview { width: 30px; height: 30px; display: inline-block; vertical-align: middle; border: 1px solid #000; margin-left: 10px; border-radius: 4px; }
        .flex-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        input[type="text"], input[type="number"], select { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-add-color { background: #3b82f6; color: white; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-weight: bold; font-size: 18px; }
        .btn-add-color:hover { background: #2563eb; }
        .btn-main { padding: 10px 20px; background: #10b981; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        hr { margin: 20px 0; border: 0; border-top: 1px solid #eee; }
    </style>
</head>
<body>

<div class="box">
    <h2 style="text-align: center; color: #1e293b;">THÊM SẢN PHẨM Ô TÔ MỚI</h2>

    <form action="{{ url('/trang_admin/san_pham/them') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="flex-row">
            <input type="text" name="ten_xe" placeholder="Tên xe (VD: VinFast VF8)" style="flex: 2" required>
            <select name="loai_xe" style="flex: 1" required>
                <option value="">-- Chọn loại xe --</option>
                @foreach($data['ds_loai'] as $row)
                    <option value="{{ $row['id_Loai_xe'] }}">{{ $row['Ten_Loai_Xe'] }}</option>
                @endforeach
            </select>
            <select name="thuong_hieu" style="flex: 1" required>
                <option value="">-- Chọn thương hiệu --</option>
                @foreach($data['ds_thuong_hieu'] as $row)
                    <option value="{{ $row['id_Thuong_Hieu'] }}">{{ $row['Ten_Thuong_Hieu'] }}</option>
                @endforeach
            </select>
        </div>

        <textarea name="mo_ta" placeholder="Mô tả chi tiết sản phẩm..." style="width: 100%; height: 80px; padding: 8px; margin-bottom: 15px;"></textarea>

        <div class="flex-row" style="background: #eff6ff; padding: 10px; border-radius: 5px;">
            <div style="flex: 1">
                <label><b>Ảnh đại diện:</b></label><br>
                <input type="file" name="anh_dai_dien" required>
            </div>
            <div style="flex: 1">
                <label><b>File 3D (.glb):</b></label><br>
                <input type="file" name="anh_3d" accept=".glb">
            </div>
        </div>

        <hr>
        <h3>Cấu hình màu sắc & Giá</h3>

        <div id="ds_mau_xe">
            <div class="mau_xe_item">
                <h4 style="margin-top: 0; color: #3b82f6;">Màu mặc định (Primary)</h4>
                
                <div class="flex-row">
                    <select name="mau_xe[0]" onchange="previewColor(this)" required style="flex: 1">
                        <option value="">-- Chọn màu từ danh sách --</option>
                        @foreach($data['ds_mau'] as $mau)
                            <option value="{{ $mau['id_Mau'] }}" data-color="{{ $mau['Ma_Mau'] }}">
                                {{ $mau['Ten_Mau'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="color-preview"></div>
                    <button type="button" class="btn-add-color" title="Thêm màu mới vào hệ thống" onclick="quickAddColor(this)">+</button>
                </div>

                <div class="flex-row">
                    <div style="flex: 1">
                        <label>Giá bán (VNĐ):</label><br>
                        <input type="number" name="gia_mau[0]" placeholder="800000000" style="width: 90%" required>
                    </div>
                    <div style="flex: 1">
                        <label>Số lượng kho:</label><br>
                        <input type="number" name="so_luong[0]" value="1" min="0" style="width: 90%" required>
                    </div>
                </div>

                <div style="margin-top: 10px;">
                    <label>Album ảnh chi tiết (Chọn nhiều ảnh):</label><br>
                    <input type="file" name="anh_mau[0][]" multiple required>
                </div>

                <input type="hidden" name="is_main[0]" value="1">
            </div>
        </div>

        <button type="button" onclick="themMau()" style="padding: 8px 15px; cursor: pointer;">+ Thêm biến thể màu khác</button>

        <hr>
        <div style="text-align: center;">
            <button type="submit" class="btn-main">LƯU SẢN PHẨM VÀO HỆ THỐNG</button>
        </div>
    </form>
</div>

<select id="mau_options_template" style="display:none">
    @foreach($data['ds_mau'] as $mau)
        <option value="{{ $mau['id_Mau'] }}" data-color="{{ $mau['Ma_Mau'] }}">
            {{ $mau['Ten_Mau'] }}
        </option>
    @endforeach
</select>

<script>
let index = 1;

// Cập nhật ô xem trước màu sắc
function previewColor(sel){
    const color = sel.options[sel.selectedIndex].getAttribute('data-color');
    sel.nextElementSibling.style.backgroundColor = color || 'transparent';
}

// Hàm thêm màu chưa có trong hệ thống (Dấu + kế bên dropdown)
function quickAddColor(btn) {
    const name = prompt("Nhập tên màu mới (VD: Xanh Lục Bảo):");
    if (!name || name.trim() === "") return;
    
    const code = prompt("Nhập mã màu HEX (VD: #006400):", "#000000");
    if (!code || !code.startsWith("#")) {
        alert("Mã màu không hợp lệ (Phải bắt đầu bằng dấu #)");
        return;
    }

    // Giá trị đặc biệt gửi về Controller: NEW|Tên|Mã
    const newValue = `NEW|${name}|${code}`;
    
    // Tìm select cùng hàng
    const select = btn.parentElement.querySelector('select');
    
    // Tạo option mới
    const newOpt = document.createElement('option');
    newOpt.value = newValue;
    newOpt.setAttribute('data-color', code);
    newOpt.innerText = name + " (Mới)";
    newOpt.selected = true;
    
    // Thêm vào select hiện tại
    select.appendChild(newOpt);
    previewColor(select);
    
    // Cập nhật vào Template để các item thêm sau này cũng có màu này
    const template = document.getElementById('mau_options_template');
    const tempOpt = newOpt.cloneNode(true);
    tempOpt.selected = false;
    template.appendChild(tempOpt);
    
    alert("Đã thêm tạm thời màu '" + name + "'. Hệ thống sẽ tự tạo màu này khi bạn nhấn Lưu.");
}

// Hàm thêm một bộ màu khác (Biến thể màu thứ 2, 3...)
function themMau(){
    const rawOptions = document.getElementById('mau_options_template').innerHTML;
    const div = document.createElement("div");
    div.className = "mau_xe_item";
    div.innerHTML = `
        <h4 style="margin-top: 0; color: #64748b;">Biến thể màu phụ</h4>
        <div class="flex-row">
            <select name="mau_xe[${index}]" onchange="previewColor(this)" required style="flex: 1">
                <option value="">-- Chọn màu --</option>
                ${rawOptions}
            </select>
            <div class="color-preview"></div>
            <button type="button" class="btn-add-color" onclick="quickAddColor(this)">+</button>
        </div>

        <div class="flex-row">
            <div style="flex: 1">
                <label>Giá bán:</label><br>
                <input type="number" name="gia_mau[${index}]" required style="width: 90%">
            </div>
            <div style="flex: 1">
                <label>Số lượng:</label><br>
                <input type="number" name="so_luong[${index}]" value="1" min="0" required style="width: 90%">
            </div>
        </div>

        <div style="margin-top: 10px;">
            <label>Ảnh chi tiết:</label><br>
            <input type="file" name="anh_mau[${index}][]" multiple required>
        </div>

        <input type="hidden" name="is_main[${index}]" value="0">
        <button type="button" onclick="this.parentElement.remove()" style="color:red; margin-top:10px; border:none; background:none; cursor:pointer;">Xóa màu này</button>
    `;
    document.getElementById("ds_mau_xe").appendChild(div);
    index++;
}
</script>

</body>
</html>