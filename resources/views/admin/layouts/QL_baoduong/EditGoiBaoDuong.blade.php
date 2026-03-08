<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa gói bảo dưỡng</title>
</head>

<body>
    @extends('admin.layouts.main')

    @section('content')

    <h2>Sửa gói bảo dưỡng</h2>

    <form action="{{ route('goibaoduong.update',$goi->id) }}" method="POST">

        @csrf
        @method('PUT')

        <p>
            Tên gói <br>
            <input type="text" name="ten_goi" value="{{ $goi->ten_goi }}" required>
        </p>

        <p>
            Mô tả <br>
            <textarea name="mo_ta">{{ $goi->mo_ta }}</textarea>
        </p>

        <p>
            Giá <br>
            <input type="number" name="gia" value="{{ $goi->gia }}" required>
        </p>

        <button type="submit">
            Cập nhật
        </button>

        <a href="{{ route('goibaoduong.index') }}">
            <button type="button">
                Quay lại
            </button>
        </a>

    </form>

    @endsection
</body>

</html>