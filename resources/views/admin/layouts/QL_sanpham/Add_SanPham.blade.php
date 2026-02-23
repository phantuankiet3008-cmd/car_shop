<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        .mau_xe_item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .color-preview {
            width: 30px;
            height: 30px;
            display: inline-block;
            vertical-align: middle;
            border: 1px solid #000;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="box">
    <h3>Thêm sản phẩm mới</h3>

    <form action="" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="ten_xe" placeholder="Tên xe" required>

        <input type="text" name="mo_ta" placeholder="Mô tả sản phẩm" required>

        <h3>Loại xe & Thương hiệu</h3>

        <select name="loai_xe" required>
            <option value="">-- Chọn loại xe --</option>
         @foreach($data['ds_loai'] as $row)
    <option value="{{ $row['id_Loai_xe'] }}">
        {{ $row['Ten_Loai_Xe'] }}
    </option>
@endforeach


        </select>

        <select name="thuong_hieu" required>
            <option value="">-- Chọn thương hiệu --</option>
           @foreach($data['ds_thuong_hieu'] as $row)
    <option value="{{ $row['id_Thuong_Hieu'] }}">
        {{ $row['Ten_Thuong_Hieu'] }}
    </option>
@endforeach



        </select>

        <h3>Hình ảnh sản phẩm</h3>
        <label>Ảnh đại diện:</label>
        <input type="file" name="anh_dai_dien" required>
        <br><br>

        <label>Ảnh 3D:</label>
        <input type="file" name="anh_3d">

        <hr>

        <div id="ds_mau_xe">
            <div class="mau_xe_item">
                <h4>Màu xe chính</h4>

                <select name="mau_xe[0]" onchange="previewColor(this)" required>
                    <option value="">-- Chọn màu --</option>
                   @foreach($data['ds_mau'] as $mau)
    <option value="{{ $mau['id_Mau'] }}" data-color="{{ $mau['Ma_Mau'] }}">
        {{ $mau['Ten_Mau'] }}
    </option>
@endforeach
                </select>

                <div class="color-preview"></div>

                <br><br>
                <label>Giá của màu:</label>
                <input type="number" name="gia_mau[0]" required>

                <br><br>
                <label>Ảnh chi tiết cho màu này:</label>
                <input type="file" name="anh_mau[0][]" multiple required>

                <input type="hidden" name="is_main[0]" value="1">
            </div>
        </div>

        <button type="button" onclick="themMau()">+ Thêm màu khác</button>

        <br><hr>

        <button type="submit"
                style="padding:10px 20px;background:green;color:white;">
            LƯU SẢN PHẨM
        </button>
    </form>
</div>
<select id="mau_options_template" style="display:none">
@foreach($data['ds_mau'] as $mau)
    <option value="{{ $mau['id_Mau'] }}"
            data-color="{{ $mau['Ma_Mau'] }}">
        {{ $mau['Ten_Mau'] }}
    </option>
@endforeach
</select>
<script>
let index = 1;

const rawOptions = document.getElementById('mau_options_template').innerHTML;


function previewColor(sel){
    const color = sel.options[sel.selectedIndex].getAttribute('data-color');
    sel.nextElementSibling.style.backgroundColor = color || 'transparent';
}

function themMau(){
    const div = document.createElement("div");
    div.className = "mau_xe_item";
    div.innerHTML = `
        <h4>Màu xe phụ</h4>
        <select name="mau_xe[${index}]" onchange="previewColor(this)" required>
            <option value="">-- Chọn màu --</option>
            ${rawOptions}
        </select>

        <div class="color-preview"></div>

        <br><br>
        <label>Giá:</label>
        <input type="number" name="gia_mau[${index}]" required>

        <br><br>
        <label>Ảnh chi tiết:</label>
        <input type="file" name="anh_mau[${index}][]" multiple required>

        <input type="hidden" name="is_main[${index}]" value="0">

        <button type="button"
                onclick="this.parentElement.remove()"
                style="color:red">
            Xóa màu này
        </button>
    `;
    document.getElementById("ds_mau_xe").appendChild(div);
    index++;
}
</script>

</body>
</html>
