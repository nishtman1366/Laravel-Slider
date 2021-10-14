<?php

namespace Nishtman\LaravelSlider\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Slider extends Model
{
    use HasFactory;

    public function getTable()
    {
        return config('slider.database.sliders_table', parent::getTable());
    }

    protected $fillable = ['category_id', 'title', 'subtitle', 'image', 'url', 'status'];
    protected $appends = ['statusText', 'createDate', 'updateDate', 'imageUrl'];

    public function getImageUrlAttribute()
    {
        if (is_null($this->attributes['image'])) {
            return null;
        }

        return url('storage') . sprintf('/sliders/%s/%s/%s', $this->category_id, $this->id, $this->image);
    }

    public function getStatusTextAttribute()
    {
        if (is_null($this->attributes['status'])) {
            return 'نامشخص';
        }
        switch ($this->attributes['status']) {
            default:
            case 'SLIDER_CREATED':
                return 'ایجاد شده';
            case 'SLIDER_ACTIVE':
                return 'فعال';
            case 'SLIDER_INACTIVE':
                return 'غیرفعال';
            case 'SLIDER_DELETED':
                return 'حذف شده';
        }
    }

    public function getCreateDateAttribute()
    {
        if (is_null($this->attributes['created_at'])) {
            return null;
        }

        return Jalalian::forge($this->attributes['created_at'])->format('Y/m/d H:i:s');
    }

    public function getUpdateDateAttribute()
    {
        if (is_null($this->attributes['updated_at'])) {
            return null;
        }

        return Jalalian::forge($this->attributes['updated_at'])->format('Y/m/d H:i:s');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
