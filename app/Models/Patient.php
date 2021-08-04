<?php

namespace App\Models;

use App\Events\PatientCreated;
use App\Events\PatientUpdated;
use App\Helpers\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Patient extends Model
{
    use HasFactory, CommonMethods;

    protected $fillable = [
        'code',
        'ar_name',
        'en_name',
        'phone',
        'national_id',
        'nationality',
        'age',
        'gender',
        'social_status',
        'address',
        'type',
        'payment_method',
        'status',
        'company_id',
        'is_emergency',
        'discount_id',
        'room_id',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PatientCreated::class,
        'updated' => PatientUpdated::class,
    ];

    const ENUM_FIELDS = ['gender', 'social_status', 'type', 'payment_method', 'status'];
    const FILES_PATH = 'patients/files/';

    /**
     * Get array of values for the enum fields.
     *
     * @param String $field
     * @return Array
     */
    public static function getEnumValues(String $field = '')
    {
        switch ($field) {
            case 'gender':
                return ['male', 'female'];
                break;

            case 'social_status':
                return ['single', 'married'];
                break;

            case 'type':
                return ['citizen', 'resident', 'visitor'];
                break;

            case 'payment_method':
                return ['cash', 'cash_with_discount', 'insurance_company', 'family'];
                break;

            case 'status':
                return ['closed', 'blocked', 'opened'];
                break;

            default:
                return [];
                break;
        }
    }

    /**
     * Scope a query to only include not blocked patients.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotBlocked($query)
    {
        return $query->where('status', '!=', 'blocked');
    }

    /**
     * Scope a query to only include only blocked patients.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }

    /**
     * Scope a query to only include only emergency patients.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmergency($query)
    {
        return $query->where('is_emergency', 1);
    }

    /**
     * Scope a query to only include only opened users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpened($query)
    {
        return $query->where('status', 'opened');
    }

    ## Start Relationships.
    public function doctors()
    {
        return $this->belongsToMany(User::class, 'doctor_patient', 'patient_id', 'doctor_id')
            ->withPivot('diagnose')
            ->withTimestamps();
    }

    /**
     * Get all of the patient's files.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'owner');
    }

    /**
     * Get all of the reservations for the Patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the company that owns the Patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the Discount that owns the Patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * Get the room that owns the Patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    ## End Relationships.

    /**
     * Get all the patient diagnosis.
     */
    public function diagnoses()
    {
        $diagnoses = [];
        foreach ($this->doctors as $doctor) {
            if (!empty($doctor->pivot->diagnose)) {
                $diagnoses[$doctor->name] = $doctor->pivot->diagnose;
            }
        }
        return $diagnoses;
    }

    /**
     * Get specific model's files path.
     */
    public function urlToDownload(String $fileName)
    {
        return Storage::disk('uploads')->url(static::FILES_PATH . $this->id . '/' . $fileName);
    }

    /**
     * Store given files to uploads.
     *
     * @param Array|UplodedFile $files
     * @param string $type
     * @return mixed
     */
    public function storeToUploads($files, $type = 'file', $description = '')
    {
        if (!is_array($files)) {
            $files = [$files];
        }

        $path = static::FILES_PATH . $this->id;

        foreach ($files as $file) {
            $name = time() . '_' . $type . '_' . $file->getClientOriginalName();
            $file->storeAs($path, $name, 'uploads');
            $object = File::create([
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'owner_id' => $this->id,
                'owner_type' => Patient::class,
            ]);
        }
        return $object; // So in case of one file return its object.
    }

    /**
     * Delete the Folder that contains all the model files.
     */
    public function deleteAllUploadedFiles()
    {
        return Storage::disk('uploads')->deleteDirectory(static::FILES_PATH . $this->id);
    }

    /**
     * Delete all associated records from files table.
     */
    public function deleteAssociatedFiles()
    {
        foreach ($this->files as $file) {
            $file->delete();
        }
        return true;
    }
}
