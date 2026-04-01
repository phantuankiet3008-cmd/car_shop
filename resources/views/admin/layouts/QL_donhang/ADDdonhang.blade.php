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
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tạo Đơn Hàng Mới</h3>
        </div>
        <form action="{{ route('admin.donhang.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-user"></i> Thông tin khách hàng</h5>
                        <hr>
                        <div class="form-group">
                            <label>Chọn khách hàng <span class="text-danger">*</span></label>
                            <select name="id_khach_hang" class="form-control select2" required>
                                <option value="">-- Chọn khách hàng --</option>
                                @foreach($data['ds_khach_hang'] as $kh)
                                    <option value="{{ $kh['id_Khach_Hang'] }}">
                                        {{ $kh['Ho_Ten'] }} - {{ $kh['So_Dien_Thoai'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5><i class="fas fa-car"></i> Chọn sản phẩm xe</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Loại xe</label>
                                    <select id="id_loai" class="form-control">
                                        <option value="">-- Tất cả loại --</option>
                                        @foreach($data['ds_loai'] as $loai)
                                            <option value="{{ $loai['id_Loai_xe'] }}">{{ $loai['Ten_Loai_Xe'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Thương hiệu</label>
                                    <select id="id_thuong_hieu" class="form-control">
                                        <option value="">-- Tất cả hiệu --</option>
                                        @foreach($data['ds_thuong_hieu'] as $th)
                                            <option value="{{ $th['id_Thuong_Hieu'] }}">{{ $th['Ten_Thuong_Hieu'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Sản phẩm <span class="text-danger">*</span></label>
                            <select id="id_xe" class="form-control" required>
                                <option value="">-- Chọn loại/thương hiệu trước --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Màu sắc & Phiên bản <span class="text-danger">*</span></label>
                            <select id="id_xe_mau" name="id_xe_mau" class="form-control" required>
                                <option value="">-- Chọn sản phẩm trước --</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <h5><i class="fas fa-money-bill-wave"></i> Chi tiết thanh toán</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Giá gốc (VNĐ)</label>
                                    <input type="number" name="gia_goc" id="gia_goc" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Giảm giá (VNĐ)</label>
                                    <input type="number" name="gia_giam" id="gia_giam" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tiền cọc (VNĐ)</label>
                                    <input type="number" name="tien_coc" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tổng cộng (Sau giảm)</label>
                                    <input type="text" id="tong_tien_hien_thi" class="form-control" readonly style="font-weight: bold; color: red;">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái đơn hàng</label>
                                    <select name="trang_thai" class="form-control">
                                        <option value="moi">Mới tạo</option>
                                        <option value="da_ky">Đã ký hợp đồng</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Thanh toán</label>
                                    <select name="payment_status" class="form-control">
                                        <option value="pending">Chờ thanh toán</option>
                                        <option value="paid">Đã thanh toán</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary px-5">Tạo Đơn Hàng</button>
                <a href="{{ route('admin.donhang.index') }}" class="btn btn-secondary">Hủy bỏ</a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    
    // 1. Lọc Sản phẩm theo Loại & Thương hiệu
    $('#id_loai, #id_thuong_hieu').on('change', function() {
        let loai = $('#id_loai').val();
        let th = $('#id_thuong_hieu').val();

        $('#id_xe').html('<option value="">Đang tải...</option>');
        $('#id_xe_mau').html('<option value="">-- Chọn sản phẩm trước --</option>');
        $('#gia_goc').val('');

        $.ajax({
            url: '/api/get-san-pham',
            type: 'GET',
            data: { id_loai: loai, id_thuong_hieu: th },
            success: function(res) {
                $('#id_xe').html(res.html);
            }
        });
    });

    // 2. Lọc Màu xe theo Sản phẩm
    $(document).on('change', '#id_xe', function() {
        let id_xe = $(this).val();
        if(!id_xe) return;

        $('#id_xe_mau').html('<option value="">Đang tải...</option>');

        $.ajax({
            url: '/api/get-mau-xe',
            type: 'GET',
            data: { id_xe: id_xe },
            success: function(res) {
                $('#id_xe_mau').html(res.html);
            }
        });
    });

    // 3. Khi chọn phiên bản màu -> Lấy giá và tính toán
    $(document).on('change', '#id_xe_mau', function() {
        let gia = $(this).find(':selected').data('gia');
        if(gia) {
            $('#gia_goc').val(gia);
            tinhTongTien();
        }
    });

    // 4. Hàm tính tổng tiền tự động
    function tinhTongTien() {
        let goc = parseInt($('#gia_goc').val()) || 0;
        let giam = parseInt($('#gia_giam').val()) || 0;
        let tong = goc - giam;
        if(tong < 0) tong = 0;
        
        $('#tong_tien_hien_thi').val(new Intl.NumberFormat('vi-VN').format(tong) + ' VNĐ');
    }

    // Sự kiện khi nhập giảm giá
    $('#gia_giam').on('input', function() {
        tinhTongTien();
    });
});
</script>