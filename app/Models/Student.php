<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'students';

    public static $searchable = [
        'name',
        'email',
        'student_id_no',
        'program_name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'serial_no',
        'name',
        'email',
        'student_id_no',
        'cgpa',
        'out_of_cgpa',
        'certificate_generate_day_month',
        'certificate_generate_year',
        'result_published_date',
        'faculty_name',
        'program_name',
        'convocation_name',
        'hash_code',
        'certificate_url',
        'faculty_id',
        'program_id',
        'convocation_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function convocation()
    {
        return $this->belongsTo(Convocation::class, 'convocation_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
