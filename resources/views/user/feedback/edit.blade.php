@extends('layouts.master')

@section('title', 'Edit Feedback - Ependri')

@section('page_title', 'Edit Feedback')

@section('admin_content')
<!-- Alert Messages -->
@if($errors->any())
<div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl text-red-300">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-emerald-600 to-teal-600 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Edit Feedback</h1>
            <p class="text-emerald-100 text-sm mt-1">Perbarui rating dan komentar feedback Anda</p>
        </div>
        <a href="{{ route('user.feedback.show', $feedback->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 text-white font-semibold rounded-xl hover:bg-white/30 transition-all">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <!-- Content -->
    <div class="p-6">
        <form action="{{ route('user.feedback.update', $feedback->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Display Info -->
            <div class="bg-gray-50 rounded-xl p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Layanan</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $feedback->layanan->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-500 mb-1">Tanggal</label>
                        <p class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($feedback->tanggal)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Rating Selection -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-4">
                    Rating <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-4">
                    @for($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ old('rating', $feedback->rating) == $i ? 'checked' : '' }} required>
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300 transition-all peer-checked:peer-hover:border-emerald-400">
                            <i class="fas fa-star text-2xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-300 transition-colors"></i>
                        </div>
                    </label>
                    @endfor
                </div>
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-sm text-gray-500">Rating: </span>
                    <span id="rating-label" class="text-sm font-semibold text-emerald-600">
                        @switch($feedback->rating)
                            @case(1) Sangat Buruk @break
                            @case(2) Buruk @break
                            @case(3) Cukup @break
                            @case(4) Baik @break
                            @case(5) Sangat Baik @break
                            @default Pilih rating
                        @endswitch
                    </span>
                </div>
                @error('rating')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Komentar -->
            <div>
                <label for="komentar" class="block text-sm font-semibold text-gray-700 mb-2">
                    Komentar <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <textarea name="komentar" id="komentar" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none @error('komentar') border-red-500 @enderror"
                    placeholder="Tulis komentar atau saran Anda...">{{ old('komentar', $feedback->komentar) }}</textarea>
                @error('komentar')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-400">Maksimal 1000 karakter</p>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
                <a href="{{ route('user.feedback.show', $feedback->id) }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Rating Label -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingLabels = {
        1: 'Sangat Buruk',
        2: 'Buruk',
        3: 'Cukup',
        4: 'Baik',
        5: 'Sangat Baik'
    };
    
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    const ratingLabel = document.getElementById('rating-label');
    
    ratingInputs.forEach(input => {
        input.addEventListener('change', function() {
            ratingLabel.textContent = ratingLabels[this.value];
        });
    });
});
</script>
@endsection