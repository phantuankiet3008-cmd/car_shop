<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm gói bảo dưỡng</title>
</head>

<body>
    <h2>Thêm gói bảo dưỡng</h2>

    <form action="/trang_admin/goibaoduong/them" method="POST">
        @csrf

        <p>
            Tên gói <br>
            <input type="text" name="ten_goi" required>
        </p>

        <p>
            Mô tả <br>
            <textarea name="mo_ta"></textarea>
        </p>

        <p>
            Giá <br>
            <input type="number" name="gia" required>
        </p>

        <button type="submit">
            Thêm gói
        </button>

        <a href="/trang_admin/goibaoduong">
            <button type="button">
                Quay lại
            </button>
        </a>

    </form>


</body>

</html>