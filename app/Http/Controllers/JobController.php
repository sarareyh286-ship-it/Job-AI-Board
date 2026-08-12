<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // 1. عرض كل الوظائف في الصفحة الرئيسية
    public function index()
    {
        $jobs = Job::with('category')->latest()->get();
        return view('jobs.index', compact('jobs'));
    }

    // 2. عرض تفاصيل وظيفة معينة (تم إضافة فحص التقديم هنا)
    public function show($id)
    {
        $job = Job::with('category')->findOrFail($id);

        // فحص هل المستخدم الحالي مقدم على الوظيفة دي بالفعل ولا لا
        $hasApplied = false;
        if (Auth::check()) {
            $hasApplied = JobApplication::where('user_id', Auth::id())
                                        ->where('job_id', $id)
                                        ->exists();
        }

        return view('jobs.show', compact('job', 'hasApplied'));
    }

    // 3. التقديم على وظيفة
    public function apply($id)
    {
        $userId = Auth::id();

        // التحقق مما إذا كان المستخدم قدم على هذه الوظيفة من قبل
        $exists = JobApplication::where('user_id', $userId)
                                ->where('job_id', $id)
                                ->exists();

        if ($exists) {
            return back()->with('error', 'لقد قمت بالتقديم على هذه الوظيفة بالفعل!');
        }

        // إنشاء وحفظ الطلب بالبيانات الموجودة في الجدول فقط
        $application = new JobApplication();
        $application->user_id = $userId;
        $application->job_id  = $id;
        $application->save();

        return back()->with('success', 'تم تقديم طلبك بنجاح! بالتوفيق 🚀');
    }

    // 4. إلغاء التقديم على وظيفة (تطابق اسمها مع الـ Route والـ Blade)
    public function cancelApply($id)
    {
        $userId = Auth::id();

        $application = JobApplication::where('user_id', $userId)
                                     ->where('job_id', $id)
                                     ->first();

        if ($application) {
            $application->delete();
            return back()->with('success', 'تم إلغاء التقديم على الوظيفة بنجاح.');
        }

        return back()->with('error', 'لم يتم العثور على طلب التقديم.');
    }
}