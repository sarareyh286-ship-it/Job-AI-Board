<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة الوظائف الذكية | AI Job Board</title>
    <!-- Google Font Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f6f9;
        }
        .hero-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 80px 0 60px;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 10px 30px rgba(13, 110, 253, 0.15);
        }
        .job-card {
            border: none;
            border-radius: 16px;
            transition: all 0.3s ease;
            background: #ffffff;
        }
        .job-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08) !important;
        }
        .badge-category {
            background-color: #eef2ff;
            color: #4f46e5;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
        }
        .work-badge {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: 600;
            border-radius: 8px;
            padding: 4px 10px;
        }
        .salary-tag {
            font-size: 1.1rem;
            font-weight: 800;
            color: #10b981;
        }
        .btn-custom {
            border-radius: 10px;
            font-weight: 700;
            padding: 8px 20px;
            transition: all 0.2s;
        }
        /* AI Chatbot Styles */
        #ai-chat-widget {
            position: fixed;
            bottom: 25px;
            left: 25px;
            z-index: 1050;
        }
        #chat-toggle-btn {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);
            transition: transform 0.2s;
        }
        #chat-toggle-btn:hover {
            transform: scale(1.08);
        }
        #chat-box {
            width: 340px;
            position: absolute;
            bottom: 75px;
            left: 0;
            border-radius: 18px;
            border: none;
            overflow: hidden;
        }
        .chat-message-user {
            background-color: #0d6efd;
            color: white;
            border-radius: 12px 12px 0 12px;
            padding: 8px 12px;
            max-width: 85%;
            margin-right: auto;
        }
        .chat-message-ai {
            background-color: #f1f5f9;
            color: #1e293b;
            border-radius: 12px 12px 12px 0;
            padding: 8px 12px;
            max-width: 85%;
            margin-left: auto;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('jobs.index') }}">
                <i class="fa-solid fa-briefcase me-2"></i>منصة الوظائف
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('jobs.index') }}">الوظائف المتاحة</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-custom">
                            <i class="fa-solid fa-user me-1"></i> البروفايل
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-light text-danger btn-custom border">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> خروج
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-custom">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-custom">
                            <i class="fa-solid fa-user-plus me-1"></i> حساب جديد
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="hero-header text-center mb-5">
        <div class="container">
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill mb-3 fw-bold">🚀 مشروع تخرج ITI</span>
            <h1 class="display-4 fw-black mb-3">منصة الوظائف الذكية</h1>
            <p class="lead text-white-50">اكتشف أفضل الفرص الوظيفية المتاحة وانطلق نحو مستقبلك المهني</p>
        </div>
    </header>

    <!-- Jobs Section -->
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1 text-dark">💼 أحدث الوظائف المتاحة</h3>
                <p class="text-muted small mb-0">تم العثور على {{ $jobs->count() }} فرصة عمل جاهزة للتقديم</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse($jobs as $job)
                <div class="col-md-6 col-lg-4">
                    <div class="card job-card h-100 shadow-sm p-3">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge badge-category">
                                        <i class="fa-solid fa-layer-group me-1"></i> {{ $job->category->name ?? 'عام' }}
                                    </span>
                                    <span class="work-badge small">
                                        <i class="fa-solid fa-briefcase me-1"></i> {{ $job->work_type }}
                                    </span>
                                </div>

                                <h4 class="card-title fw-bold text-dark mb-2">{{ $job->title }}</h4>
                                
                                <p class="text-muted small mb-3">
                                    <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $job->location }}
                                </p>

                                <p class="card-text text-secondary mb-4" style="line-height: 1.6;">
                                    {{ Str::limit($job->description, 110) }}
                                </p>
                            </div>

                            <div class="border-top pt-3 mt-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="d-block text-muted small">الراتب المتوقع</span>
                                        <span class="salary-tag">
                                            {{ $job->salary ? '$' . number_format($job->salary) : 'غير محدد' }}
                                        </span>
                                    </div>
                                    <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-custom shadow-sm">
                                        التفاصيل <i class="fa-solid fa-arrow-left ms-1"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info py-4 rounded-4 shadow-sm">
                        <i class="fa-solid fa-circle-info fa-2x mb-3 d-block"></i>
                        <h5>لا توجد وظائف مسجلة حالياً</h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- 🤖 AI Chatbot Widget -->
    <div id="ai-chat-widget">
        <button id="chat-toggle-btn" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-robot"></i>
        </button>

        <div id="chat-box" class="card shadow-lg d-none">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-robot fs-5"></i>
                    <strong class="mb-0">المساعد الذكي للوظائف</strong>
                </div>
                <button type="button" class="btn-close btn-close-white" id="chat-close-btn"></button>
            </div>
            <div class="card-body d-flex flex-column gap-3" id="chat-messages" style="height: 300px; overflow-y: auto;">
                <div class="chat-message-ai small">
                    أهلاً بك! 👋 أنا مساعدك الذكي، يمكنك استفساري عن أي وظيفة أو مجال يبحث عن موظفين!
                </div>
            </div>
            <div class="card-footer p-2 bg-white border-top">
                <div class="input-group">
                    <input type="text" id="chat-input" class="form-control form-control-sm border-0 bg-light" placeholder="اكتب سؤالك هنا...">
                    <button class="btn btn-primary btn-sm rounded-3 px-3" id="send-btn">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AI Chatbot Logic -->
    <script>
        const chatToggleBtn = document.getElementById('chat-toggle-btn');
        const chatBox = document.getElementById('chat-box');
        const chatCloseBtn = document.getElementById('chat-close-btn');
        const sendBtn = document.getElementById('send-btn');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');

        chatToggleBtn.addEventListener('click', () => chatBox.classList.toggle('d-none'));
        chatCloseBtn.addEventListener('click', () => chatBox.classList.add('d-none'));

        async function sendMessage() {
            let message = chatInput.value.trim();
            if(!message) return;

            // إضافة رسالة المستخدم
            chatMessages.innerHTML += `<div class="chat-message-user small mb-1">${message}</div>`;
            chatInput.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // إضافة مؤشر التحميل
            let loadingId = 'loading-' + Date.now();
            chatMessages.innerHTML += `<div id="${loadingId}" class="chat-message-ai small text-muted"><i class="fa-solid fa-spinner fa-spin me-1"></i> جاري التفكير...</div>`;
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                let response = await fetch("{{ route('ai.chat') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ message: message })
                });

                let data = await response.json();
                document.getElementById(loadingId).remove();

                if(data.status === 'success') {
                    chatMessages.innerHTML += `<div class="chat-message-ai small mb-1">${data.reply}</div>`;
                } else {
                    chatMessages.innerHTML += `<div class="chat-message-ai small text-danger mb-1">عذراً، حدث خطأ أثناء معالجة الطلب.</div>`;
                }
            } catch (error) {
                document.getElementById(loadingId).remove();
                chatMessages.innerHTML += `<div class="chat-message-ai small text-danger mb-1">تعذر الاتصال بالسيرفر.</div>`;
            }
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        sendBtn.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', (e) => {
            if(e.key === 'Enter') sendMessage();
        });
    </script>
</body>
</html>