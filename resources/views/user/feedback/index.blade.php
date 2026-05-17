@extends('layouts.master')

@section('title', 'Feedback Saya - Ependri')

@section('page_title', 'Feedback Saya')

@section('admin_content')
<!-- Inline Script for Delete Confirmation -->
<script>
function confirmDelete(button) {
    if (confirm('Apakah Anda yakin ingin menghapus feedback ini?')) {
        button.closest('form').submit();
    }
}
</script>

<!-- Alert Messages -->
@if(session('success'))
<div class="mb-6 p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-xl text-emerald-300 flex items-center gap-3">
    <i class="fas fa-check-circle text-xl"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl text-red-300 flex items-center gap-3">
    <i class="fas fa-exclamation-circle text-xl"></i>
    {{ session('error') }}
</div>
@endif

<!-- Main Card -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-5 bg-gradient-to-r from-emerald-600 to-teal-600 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">Feedback Saya</h1>
            <p class="text-emerald-100 text-sm mt-1">Kelola feedback layanan Anda</p>
        </div>
        <a href="{{ route('user.feedback.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-emerald-600 font-semibold rounded-xl hover:bg-emerald-50 transition-all shadow-lg">
            <i class="fas fa-plus"></i>
            Berikan Feedback
        </a>
    </div>

    <!-- Content -->
    <div class="p-6">
        @if($feedback->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($feedback as $key => $item)
                    <tr class="hover:bg-gray-50 transition-all">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-900">{{ $feedback->firstItem() + $key }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-concierge-bell text-teal-600 text-sm"></i>
                                </div>
                                <span class="text-sm text-gray-700">{{ $item->layanan->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $item->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500">{{ $item->rating }}/5 - {{ $item->rating_label }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600 line-clamp-1">{{ $item->komentar ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('user.feedback.show', $item->id) }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="{{ route('user.feedback.edit', $item->id) }}" class="text-emerald-600 hover:text-emerald-800 font-medium inline-flex items-center gap-1 ml-3">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('user.feedback.destroy', $item->id) }}" method="POST" class="inline ml-3">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" class="text-red-600 hover:text-red-800 font-medium inline-flex items-center gap-1">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $feedback->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-comment-dots text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Feedback</h3>
            <p class="text-gray-500 mb-6">Anda belum memberikan feedback untuk layanan apapun</p>
            <a href="{{ route('user.feedback.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-all shadow-lg">
                <i class="fas fa-plus"></i>
                Berikan Feedback Baru
            </a>
        </div>
        @endif
    </div>
</div>
@endsection