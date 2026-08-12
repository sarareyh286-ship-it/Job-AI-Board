<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description']; // على حسب الأعمدة اللي عملتيها في الجدول

    // القسم الواحد بيحتوي على أكتر من وظيفة
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}