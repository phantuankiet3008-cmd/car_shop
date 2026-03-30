<?php

namespace App\Services;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryService
{
    private $uploadApi;

    public function __construct()
    {
        // Cấu hình tập trung tại một nơi duy nhất
        $config = new Configuration();
        $config->cloud->cloudName = 'dht18l0rh';
        $config->cloud->apiKey    = '961252676676428';
        $config->cloud->apiSecret = 'vt1Pydhm3LnAi4RRjsGvXeGdNXE';
        $config->url->secure      = true;

        $this->uploadApi = new UploadApi($config);
    }

    /**
     * Hàm upload ảnh lên Cloudinary
     * Trả về: URL ảnh hoặc chuỗi rỗng nếu thất bại
     */
    public function uploadImage($file, $folder = 'loai_xe')
{
    // 1. Kiểm tra nếu file trống
    if (!$file) return '';

    // 2. Lấy đường dẫn tạm (realpath)
    $tmpPath = '';

    // Trường hợp là Object (từ Laravel Request)
    if (is_object($file) && method_exists($file, 'isValid')) {
        if (!$file->isValid()) return '';
        $tmpPath = $file->getRealPath();
    } 
    // Trường hợp là Array (từ $_FILES truyền sang)
    elseif (is_array($file) && isset($file['tmp_name'])) {
        if ($file['error'] !== 0) return '';
        $tmpPath = $file['tmp_name'];
    }
    // Trường hợp là chuỗi đường dẫn trực tiếp
    elseif (is_string($file)) {
        $tmpPath = $file;
    }

    if (empty($tmpPath)) return '';

    try {
        $result = $this->uploadApi->upload($tmpPath, [
            'upload_preset' => 'ml_default',
            'folder' => $folder
        ]);

        return $result['secure_url'];
    } catch (\Exception $e) {
        return '';
    }
}
    // Trong file app/Services/CloudinaryService.php

/**
 * Hàm xóa ảnh trên Cloudinary từ URL
 */
public function deleteImage($url)
{
    if (empty($url) || !str_contains($url, 'res.cloudinary.com')) return false;

    try {
        // Tách lấy Public ID từ URL Cloudinary
        // Ví dụ: .../image/upload/v12345/san_pham/abcxyz.png -> san_pham/abcxyz
        
        $temp = explode('/upload/', $url);
        if (count($temp) < 2) return false;

        $pathWithVersion = $temp[1]; // v12345/san_pham/abcxyz.png
        $pathParts = explode('/', $pathWithVersion);
        
        // Loại bỏ phần version (v12345)
        array_shift($pathParts); 
        
        $pathWithoutVersion = implode('/', $pathParts); // san_pham/abcxyz.png
        
        // Loại bỏ phần đuôi mở rộng (.png, .jpg...)
        $publicId = pathinfo($pathWithoutVersion, PATHINFO_DIRNAME) . '/' . pathinfo($pathWithoutVersion, PATHINFO_FILENAME);
        
        // Nếu file nằm ngay thư mục gốc (không có folder) thì pathinfo DIRNAME sẽ là "."
        if (pathinfo($pathWithoutVersion, PATHINFO_DIRNAME) == ".") {
            $publicId = pathinfo($pathWithoutVersion, PATHINFO_FILENAME);
        }

        return $this->uploadApi->destroy($publicId);
    } catch (\Exception $e) {
        return false;
    }
}
}