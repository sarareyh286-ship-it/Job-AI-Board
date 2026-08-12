<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;

class AdminJobController extends Controller
{
    // 1. عرض كل الوظائف للأدمن
    public function index()
    {
        $jobs = Job::latest()->get();
        return view('admin.jobs.index', compact('jobs'));
    }

    // 2. عرض صفحة إضافة وظيفة جديدة
    public function create()
    {
        return view('admin.jobs.create');
    }

    // 3. حفظ الوظيفة الجديدة في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'work_type'   => 'required|string',
            'salary'      => 'nullable|numeric',
            'description' => 'required|string',
        ]);

        Job::create($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'تمت إضافة الوظيفة بنجاح! 🎉');
    }

    // 4. عرض صفحة تعديل وظيفة
    public function edit($id)
    {
        $job = Job::findOrFail($id);
        return view('admin.jobs.edit', compact('job'));
    }

    // 5. تحديث بيانات الوظيفة
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'work_type'   => 'required|string',
            'salary'      => 'nullable|numeric',
            'description' => 'required|string',
        ]);

        $job = Job::findOrFail($id);
        $job->update($request->all());

        return redirect()->route('admin.jobs.index')->with('success', 'تم تعديل الوظيفة بنجاح! ✏️');
    }

    // 6. حذف وظيفة
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->route('admin.jobs.index')->with('success', 'تم حذف الوظيفة بنجاح! 🗑️');
    }

    // 7. عرض قائمة المتقدمين على الوظائف
    public function applications()
    {
        $applications = Application::with(['user', 'job'])->latest()->get();
        return view('admin.applications.index', compact('applications'));
    }
}