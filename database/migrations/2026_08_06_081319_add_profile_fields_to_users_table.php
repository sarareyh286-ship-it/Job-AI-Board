
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age')->nullable();
            $table->string('job_title')->nullable();
            $table->text('profile_description')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('skills')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('resume')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['age', 'job_title', 'profile_description', 'phone_number', 'skills', 'profile_image', 'resume']);
        });
    }
};