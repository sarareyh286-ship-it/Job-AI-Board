<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} | تفاصيل الوظيفة</title>
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
        .btn-custom {
            border-radius: 10px;
            font-weight: 700;
            padding: 8px 20px;
            transition: all 0.2s;
        }
        .job-details-card {
            border: none;
            border-radius: 20px;
            background: #ffffff;
        }
        .badge-skill {
            background-color: #f3f4f6;
            color: #1f2937;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 12px;
            display: inline-block;
        }
        .info-box {
            background-color: #f8fafc;
            border-radius: 14px;
            padding: 15px;
            text-align: center;
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
                        <a class="nav-link" href="{{ route('jobs.index') }}">الوظائف المتاحة</a>
                    </li>
                    @if(auth()->check() && auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link text-danger fw-bold" href="{{ route('admin.applications.index') }}">
                                <i class="fa-solid fa-user-shield me-1"></i> لوحة التحكم
                            </a>
                        </li>
                    @endif
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

    <!-- Main Content Container -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <!-- Back Link -->
                <a href="{{ route('jobs.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block fw-semibold">
                    <i class="fa-solid fa-arrow-right me-1"></i> العودة لقائمة الوظائف
                </a>

                <div class="card job-details-card shadow-sm p-4 p-md-5">
                    
                    <!-- Job Header Info -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill fs-6">
                            {{ $job->category->name ?? 'عام' }}
                        </span>
                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill">
                            متاحة للتقديم الآن
                        </span>
                    </div>

                    <h2 class="fw-bold text-dark mb-4">{{ $job->title }}</h2>

                    <!-- Job Quick Details Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="info-box">
                                <i class="fa-solid fa-location-dot text-danger fs-4 mb-2"></i>
                                <div class="text-muted small">الموقع</div>
                                <div class="fw-bold small">{{ $job->location ?? 'غير محدد' }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-box">
                                <i class="fa-solid fa-briefcase text-primary fs-4 mb-2"></i>
                                <div class="text-muted small">طبيعة العمل</div>
                                <div class="fw-bold small">{{ $job->work_type ?? 'دوام كامل' }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-box">
                                <i class="fa-solid fa-sack-dollar text-success fs-4 mb-2"></i>
                                <div class="text-muted small">الراتب الشهري</div>
                                <div class="fw-bold small">
                                    {{ $job->salary ? '$' . number_format($job->salary) : 'غير محدد' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-box">
                                <i class="fa-solid fa-calendar-check text-warning fs-4 mb-2"></i>
                                <div class="text-muted small">آخر موعد</div>
                                <div class="fw-bold small">
                                    {{ isset($job->deadline) ? \Carbon\Carbon::parse($job->deadline)->format('Y-m-d') : '2026-12-31' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <hr class="my-4 text-muted opacity-25">
                    <h5 class="fw-bold text-dark mb-3">📝 وصف الوظيفة</h5>
                    <p class="text-secondary leading-relaxed mb-4" style="line-height: 1.8;">
                        {{ $job->description }}
                    </p>

                    <!-- Requirements / Skills -->
                    <h5 class="fw-bold text-dark mb-3">⚡ المهارات المطلوبة</h5>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @if(!empty($job->skills))
                            @foreach(explode(',', $job->skills) as $skill)
                                <span class="badge-skill">{{ trim($skill) }} ✨</span>
                            @endforeach
                        @else
                            <span class="badge-skill">جميع المهارات ذات الصلة ✨</span>
                        @endif
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <!-- Alerts for Success or Error -->
                    @if(session('success'))
                        <div class="alert alert-success mt-3 rounded-4 shadow-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-circle-check fs-4"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-warning mt-3 rounded-4 shadow-sm d-flex align-items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                    @endif

                    <!-- Action Form Button Section -->
                    <div class="text-center text-md-end mt-4">
                        @auth
                            {{-- التحقق مما إذا كان المستخدم متقدمًا بالفعل على الوظيفة --}}
                            @if(isset($hasApplied) && $hasApplied)
                                
                                <!-- زرار إلغاء التقديم -->
                                <form action="{{ route('jobs.cancel', $job->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من إلغاء تقديمك على هذه الوظيفة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-lg rounded-pill px-5 py-3 fw-bold shadow">
                                        <i class="fa-solid fa-xmark me-2"></i> إلغاء التقديم على الوظيفة
                                    </button>
                                </form>

                            @else

                                <!-- زرار التقديم العادي -->
                                <form action="{{ route('jobs.apply', $job->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 py-3 fw-bold shadow">
                                        <i class="fa-solid fa-paper-plane me-2"></i> التقديم على هذه الوظيفة الآن
                                    </button>
                                </form>

                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-warning btn-lg rounded-pill px-5 py-3 fw-bold text-white shadow">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> قم بتسجيل الدخول للتقديم على الوظيفة
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>