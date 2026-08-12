<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Services\AIService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    // 1. معالجة رسائل الشات بوت
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // جلب أحدث الوظائف كـ Context للـ AI
        $jobs = Job::select('title', 'location', 'work_type', 'salary', 'required_skills')->latest()->take(10)->get();

        $reply = $this->aiService->chatBotResponse($request->message, $jobs);

        return response()->json([
            'status' => 'success',
            'reply'  => $reply,
        ]);
    }

    // 2. تحليل نسبة التوافق لوظيفة معينة
    public function recommend(Request $request, $jobId)
    {
        $request->validate([
            'user_skills' => 'required|string',
        ]);

        $job = Job::findOrFail($jobId);
        
        $matchResult = $this->aiService->matchJobWithCandidate($request->user_skills, $job->required_skills);

        return response()->json([
            'status' => 'success',
            'match'  => $matchResult,
        ]);
    }
}