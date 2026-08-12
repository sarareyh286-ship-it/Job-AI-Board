<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'required_skills', 'category_id', 
        'location', 'work_type', 'salary', 'deadline'
    ];

    // الوظيفة بتنتمي لقسم واحد
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // الوظيفة ممكن يتقدم عليها أكتر من شخص
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}