@php use App\Helpers\FormatHelper; @endphp

@extends('layouts.app')

@section('title', 'Chat — QuickChat')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}?v={{ time() }}">
@endpush

@section('body')
     @include('components.navbar')

    <div class="bg-[#0B1221] text-gray-300 flex overflow-hidden h-[calc(100vh-64px)]">

    @include('components.sidebar')
        <section class="flex-1 overflow-auto p-6 space-y-6">
            <h1 class="text-2xl font-semibold text-white mb-6">Mi perfil</h1>

            <div class="bg-[#0D1324] border border-white/5 rounded-2xl p-6 max-w-xl">

                {{-- User Info --}}
                <div class="flex items-center gap-4 mb-6">
                    <img src="https://i.pravatar.cc/80?u={{ Auth::guard('admin')->user()->id }}"
                         class="w-16 h-16 rounded-full border border-white/10">

                    <div>
                        <p class="text-lg text-white font-semibold">
                            {{ Auth::guard('admin')->user()->name }}
                        </p>
                        <p class="text-gray-400 text-sm">
                            {{ Auth::guard('admin')->user()->email }}
                        </p>
                        <p class="text-gray-500 text-xs mt-1">
                            Miembro desde:
                            {{ Auth::guard('admin')->user()->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="text-gray-300 text-sm mb-1 block">Nombre</label>
                        <input type="text" name="name"
                               value="{{ Auth::guard('admin')->user()->name }}"
                               class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-white border border-white/5
                                      focus:border-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="text-gray-300 text-sm mb-1 block">Email</label>
                        <input type="text" value="{{ Auth::guard('admin')->user()->email }}" readonly
                               class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-gray-400 border border-white/5">
                    </div>

                    <div>
                        <label class="text-gray-300 text-sm mb-1 block">Nueva contraseña (opcional)</label>
                        <input type="password" name="password"
                               placeholder="••••••••"
                               class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-white border border-white/5
                                      focus:border-blue-500 outline-none">
                    </div>

                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl transition-colors">
                        Guardar cambios
                    </button>

                </form>
            </div>
        </section>

    </div>
@endsection
