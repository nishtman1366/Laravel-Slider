<?php
namespace Nishtman\LaravelSlider\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Morilog\Jalali\Jalalian;

class Category extends Model
{
    use HasFactory;

    public function getTable()
    {
        return config('slider.database.categories_table', parent::getTable());
    }

    protected $fillable = ['name', 'description', 'status'];
    protected $appends = ['statusText', 'createDate', 'updateDate'];

    public function getStatusTextAttribute()
    {
        if (is_null($this->attributes['status'])) return 'نامشخص';
        switch($this->attributes['status'])
        {
            default:
            case 'SLIDER_CATEGORY_CREATED':
                return 'ایجاد شده';
            case 'SLIDER_CATEGORY_ACTIVE':
                return 'فعال';
            case 'SLIDER_CATEGORY_INACTIVE':
                return 'غیرفعال';
            case 'SLIDER_CATEGORY_DELETED':
                return 'حذف شده';
        }
    }

    public function getCreateDateAttribute()
    {
        if (is_null($this->attributes['created_at'])) return null;
        return Jalalian::forge($this->attributes['created_at'])->format('Y/m/d H:i:s');
    }

    public function getUpdateDateAttribute()
    {
        if (is_null($this->attributes['updated_at'])) return null;
        return Jalalian::forge($this->attributes['updated_at'])->format('Y/m/d H:i:s');
    }


    public function sliders()
    {
        return $this->hasMany(Slider::class, 'category_id', 'id');
    }
}
