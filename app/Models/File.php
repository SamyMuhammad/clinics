<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'owner_id',
        'owner_type',
    ];

    /**
     * Get array of values for the enum fields.
     * 
     * @param String $field
     * @return Array
     */
    public static function getEnumValues(String $field = '')
    {
        switch ($field) {
            case 'type':
                return ['file', 'rays', 'test'];
            break;

            default:
                return [];
            break;
        }
    }

    /**
     * Get the owner model.
     */
    public function owner()
    {
        return $this->morphTo();
    }

    public function scopeRays($query)
    {
        return $query->where('type', 'rays');
    }

    public function scopeFiles($query)
    {
        return $query->where('type', 'file');
    }

    public function scopeTests($query)
    {
        return $query->where('type', 'test');
    }

    /**
     * Get the file name with <bdi> tag.
     */
    public function getHTMLNameAttribute()
    {
        return "<bdi>$this->name</bdi>";
    }

    /**
     * Get a model's file-url to download.
     */
    public function url()
    {
        return Storage::disk('uploads')->url($this->owner_type::FILES_PATH . $this->owner->id . '/' . $this->name);
    }

    /**
     * Delete file from uploads folder.
     */
    public function deleteFromUploads(Type $var = null)
    {
        return Storage::disk('uploads')->delete($this->owner_type::FILES_PATH . $this->owner->id . '/' . $this->name);
    }

    public function getArTypeAttribute()
    {
        switch ($this->type) {
            case 'rays':
                return 'آشعة';
                break;
            
            case 'test':
                return 'تحاليل';
                break;
            
            default:
                return 'بيانات';
                break;
        }
    }
}
