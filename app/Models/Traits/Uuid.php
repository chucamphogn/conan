<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Uuid
{
    /**
     * Trả về kiểu dữ liệu string vì để lưu được UUID thì phải lưu ở kiểu string.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    /**
     * Trả về false vì UUID không có tính tự động tăng.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    protected static function bootUuid()
    {
        // Tạo UUID và gán UUID cho model
        static::creating(function (Model $model) {
            if (Str::of($model->getKey())->isEmpty()) {
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        });

        // Nếu kẻ gian cố tình thay đổi UUID thì sẽ gán lại UUID cũ
        static::saving(function (Model $model) {
            // Lấy giá trị trước khi thay đổi
            $originalKey = Str::of($model->getOriginal($model->getKeyName()));

            // Nếu có sự khác biệt thì sẽ gán lại UUID cũ
            if ($originalKey->isNotEmpty()) {
                if (!$originalKey->exactly($model->getKey())) {
                    $model->setAttribute($model->getKeyName(), $originalKey);
                }
            }
        });
    }
}
