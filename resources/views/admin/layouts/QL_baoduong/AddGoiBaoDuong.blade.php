<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm gói bảo dưỡng</title>
    <style>
        /* CSS khu trú để làm đẹp form mà không đụng vào layout chung */
        .form-container {
            max-width: 500px;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-family: sans-serif;
        }

        .form-group { margin-bottom: 15px; }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Đảm bảo padding không làm tràn chiều rộng */
        }

        .form-group textarea { height: 100px; resize: vertical; }

        .btn-submit {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-submit:hover { background-color: #218838; }

        .btn-back {
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }

        .btn-back:hover { background-color: #5a6268; }
    </style>
</head>

<body>
    <h2>Thêm gói bảo dưỡng mới</h2>

    <div class="form-container">
        <form action="{{ url('/trang_admin/goibaoduong/them') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Tên gói bảo dưỡng</label>
                <input type="text" name="ten_goi" placeholder="Ví dụ: Bảo dưỡng định kỳ 5000km" required>
            </div>

            <div class="form-group">
                <label>Mô tả dịch vụ</label>
                <textarea name="mo_ta" placeholder="Nhập các chi tiết kiểm tra, thay thế..."></textarea>
            </div>

            <div class="form-group">
                <label>Giá dự kiến (VNĐ)</label>
                <input type="number" name="gia" placeholder="Ví cấu: 500000" required>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn-submit">
                    Lưu gói bảo dưỡng
                </button>

                <a href="{{ url('/trang_admin/goibaoduong') }}" class="btn-back">
                    Quay lại
                </a>
            </div>
        </form>
    </div>

</body>

</html>