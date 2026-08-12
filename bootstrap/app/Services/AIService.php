<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class AIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = trim(env('GROQ_API_KEY', ''));
    }

    public function chatBotResponse($userMessage, $contextJobs)
    {
        if (empty($this->apiKey)) {
            return "تنبيه: مفتاح GROQ_API_KEY غير متوفر في ملف .env";
        }

        $jobsText = !empty($contextJobs) ? json_encode($contextJobs, JSON_UNESCAPED_UNICODE) : "لا توجد وظائف حالياً";

        $prompt = "أنت مساعد ذكي لمنصة توظيف باللغة العربية. البيانات المتاحة عن الوظائف هي:\n" . $jobsText . "\nسؤال المستخدم: " . $userMessage;

        return $this->callGroq($prompt);
    }

    private function callGroq($prompt)
    {
        try {
            $url = "https://api.groq.com/openai/v1/chat/completions";

            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->post($url, [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? "لم أستطع معالجة الإجابة.";
            }

            return "حدث خطأ من السيرفر (" . $response->status() . "): " . $response->body();

        } catch (Exception $e) {
            return "خطأ استثناء: " . $e->getMessage();
        }
    }
}