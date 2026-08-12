
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            تحديث البيانات الشخصية والمهنية 👤
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            قم بتحديث معلومات ملفك الشخصي والمهارات والـ CV الخاص بك.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- الاسم -->
        <div>
            <x-input-label for="name" value="الاسم بالكامل" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- البريد الإلكتروني -->
        <div>
            <x-input-label for="email" value="البريد الإلكتروني" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- المسمى الوظيفي، السن، ورقم الهاتف -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="job_title" value="المسمى الوظيفي" />
                <x-text-input id="job_title" name="job_title" type="text" class="mt-1 block w-full" :value="old('job_title', $user->job_title)" placeholder="Full Stack Developer" />
                <x-input-error class="mt-2" :messages="$errors->get('job_title')" />
            </div>

            <div>
                <x-input-label for="age" value="السن" />
                <x-text-input id="age" name="age" type="number" class="mt-1 block w-full" :value="old('age', $user->age)" />
                <x-input-error class="mt-2" :messages="$errors->get('age')" />
            </div>

            <div>
                <x-input-label for="phone_number" value="رقم الهاتف" />
                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>
        </div>

        <!-- المهارات -->
        <div>
            <x-input-label for="skills" value="المهارات (افصلي بين كل مهارة بـ فارزة ، مثل: PHP, Laravel, HTML, CSS)" />
            <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills', $user->skills)" />
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        <!-- نبذة شخصية -->
        <div>
            <x-input-label for="profile_description" value="نبذة شخصية (Profile Description)" />
            <textarea id="profile_description" name="profile_description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('profile_description', $user->profile_description) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('profile_description')" />
        </div>

        <!-- الصورة الشخصية -->
        <div>
            <x-input-label for="profile_image" value="الصورة الشخصية" />
            <input id="profile_image" name="profile_image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
            @if($user->profile_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="w-16 h-16 rounded-full object-cover">
                </div>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
        </div>

        <!-- ملف السيرة الذاتية CV -->
        <div>
            <x-input-label for="resume" value="السيرة الذاتية (CV / Resume)" />
            <input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
            @if($user->resume)
                <p class="mt-2 text-sm text-green-600 font-bold">
                    📄 ملف الـ CV الحالي: <a href="{{ asset('storage/' . $user->resume) }}" target="_blank" class="underline">عرض الـ CV</a>
                </p>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('resume')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>حفظ التغييرات</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">تم الحفظ بنجاح.</p>
            @endif
        </div>
    </form>
</section>