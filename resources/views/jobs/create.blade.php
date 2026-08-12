<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة وظيفة جديدة | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>body { font-family: 'Cairo', sans-serif; background-color: #f8fafc; }</style>
</head>
<body>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <h3 class="fw-bold text-dark mb-4">➕ إضافة وظيفة جديدة</h3>

                    <form action="{{ route('admin.jobs.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">عنوان الوظيفة</label>
                            <input type="text" name="title" class="form-control" placeholder="مثال: Frontend Developer" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">الموقع</label>
                                <input type="text" name="location" class="form-control" placeholder="Cairo, Egypt (Remote)" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">طبيعة العمل</label>
                                <select name="work_type" class="form-select" required>
                                    <option value="Full-time">Full-time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Remote">Remote</option>
                                    <option value="Freelance">Freelance</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">الراتب المتوقع ($)</label>
                            <input type="number" name="salary" class="form-control" placeholder="مثال: 1200">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">وصف الوظيفة والمهارات المطلوبة</label>
                            <textarea name="description" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">حفظ ونشر الوظيفة</button>
                            <a href="{{ route('admin.jobs.index') }}" class="btn btn-light border rounded-pill px-4">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>