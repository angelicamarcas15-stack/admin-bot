@php use App\Helpers\FormatHelper; @endphp

@extends('layouts.app')

@section('title', 'Chat — QuickChat')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/config.css') }}?v={{ time() }}">
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}?v={{ time() }}">
@endpush


@section('body')

    @include('components.navbar')

    <div class="bg-[#0B1221] text-gray-300 flex overflow-hidden h-[calc(100vh-64px)]">

        @include('components.sidebar')

        <!-- IA -->
        <section class="flex-1 flex flex-col overflow-hidden">
            <div class="p-6 border-b border-white/5">
                <h1 class="text-2xl font-semibold text-white">Configuración del Asistente IA</h1>
                <p class="text-sm text-gray-400 mt-1">Personaliza el comportamiento y conocimiento base del asistente</p>
            </div>

            <div id="config" class="flex-1 overflow-auto p-6 space-y-6">

                <!-- Instrucciones Principales -->
                <div class="bg-[#0D1324] rounded-xl border border-white/5 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold text-white">Instrucciones Principales</h2>
                        <button id="editPromptBtn"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar
                        </button>
                    </div>
                    <div class="bg-[#1A2236] rounded-lg p-4 border border-white/5">
                        <p class="text-sm text-gray-300 leading-relaxed">
                            Eres un asistente especializado en el programa PNTE (Programa Nacional de Transformación
                            Empresarial) del gobierno peruano. Tu objetivo es ayudar a asesores y empresarios con
                            información precisa sobre normativas, procedimientos y mejores prácticas del programa. Debes ser
                            claro, profesional y siempre citar las fuentes oficiales cuando proporciones información
                            regulatoria.
                        </p>
                    </div>
                </div>

                <!-- Archivos de Conocimiento -->
                <div class="bg-[#0D1324] rounded-xl border border-white/5 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold text-white">Archivos de Conocimiento</h2>
                        <button
                            class="px-4 py-2 bg-white/5 text-gray-300 rounded-lg hover:bg-white/10 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" />
                            </svg>
                            Subir Archivo
                        </button>
                    </div>
                    <div class="space-y-3">
                        <!-- File 1 -->
                        <div
                            class="bg-[#1A2236] rounded-lg p-4 border border-white/5 flex items-center justify-between hover:border-blue-500/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">normativas_programa_PNTE.pdf</p>
                                    <p class="text-xs text-gray-400">2.4 MB • Actualizado hace 2 días</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="p-2 hover:bg-red-500/20 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- File 2 -->
                        <div
                            class="bg-[#1A2236] rounded-lg p-4 border border-white/5 flex items-center justify-between hover:border-blue-500/50 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-white">procedimientos.pdf</p>
                                    <p class="text-xs text-gray-400">1.8 MB • Actualizado hace 5 días</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="p-2 hover:bg-red-500/20 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Referencias para el Asistente -->
                <div class="bg-[#0D1324] rounded-xl border border-white/5 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-lg font-semibold text-white">Referencias Web</h2>
                        <button id="addRefBtn"
                            class="px-4 py-2 bg-white/5 text-gray-300 rounded-lg hover:bg-white/10 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" />
                            </svg>
                            Agregar URL
                        </button>
                    </div>
                    <p class="text-sm text-gray-400 mb-4">URLs de referencia que el asistente puede consultar para obtener
                        información actualizada</p>

                    <div class="space-y-3">
                        <!-- Reference 1 -->
                        <div class="bg-[#1A2236] rounded-lg p-4 border border-white/5">
                            <label class="block text-xs text-gray-400 mb-2">SUNAT - Superintendencia Nacional de Aduanas y
                                de Administración Tributaria</label>
                            <div class="flex items-center gap-2">
                                <input type="text" value="https://www.sunat.gob.pe" readonly
                                    class="flex-1 bg-[#0D1324] px-4 py-2 rounded-lg text-white border border-white/5 focus:border-blue-500 outline-none text-sm" />
                                <button class="p-2 hover:bg-red-500/20 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Reference 2 -->
                        <div class="bg-[#1A2236] rounded-lg p-4 border border-white/5">
                            <label class="block text-xs text-gray-400 mb-2">SUNARP - Superintendencia Nacional de los
                                Registros Públicos</label>
                            <div class="flex items-center gap-2">
                                <input type="text" value="https://www.sunarp.gob.pe" readonly
                                    class="flex-1 bg-[#0D1324] px-4 py-2 rounded-lg text-white border border-white/5 focus:border-blue-500 outline-none text-sm" />
                                <button class="p-2 hover:bg-red-500/20 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Reference 3 -->
                        <div class="bg-[#1A2236] rounded-lg p-4 border border-white/5">
                            <label class="block text-xs text-gray-400 mb-2">GOB.PE - Portal del Estado Peruano</label>
                            <div class="flex items-center gap-2">
                                <input type="text" value="https://www.gob.pe" readonly
                                    class="flex-1 bg-[#0D1324] px-4 py-2 rounded-lg text-white border border-white/5 focus:border-blue-500 outline-none text-sm" />
                                <button class="p-2 hover:bg-red-500/20 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end gap-3">
                    <button class="px-6 py-3 bg-white/5 text-gray-300 rounded-xl hover:bg-white/10 transition-colors">
                        Cancelar
                    </button>
                    <button class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                        Guardar Cambios
                    </button>
                </div>

            </div>
        </section>

        <!-- MODAL EDITAR PROMPT -->
        <div id="editModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4">
            <div class="bg-[#0D1324] rounded-2xl border border-white/10 w-full max-w-3xl">
                <div class="p-6 border-b border-white/10">
                    <h2 class="text-xl font-semibold text-white">Editar Instrucciones del Asistente</h2>
                    <p class="text-sm text-gray-400 mt-1">Personaliza el comportamiento y contexto del asistente IA</p>
                </div>

                <div class="p-6">
                    <label class="block text-sm text-gray-400 mb-2">Instrucciones principales del asistente</label>
                    <textarea id="promptTextarea" rows="12"
                        class="w-full bg-[#1A2236] px-4 py-3 rounded-xl text-white placeholder-gray-500 border border-white/5 focus:border-blue-500 outline-none resize-none"
                        placeholder="Escribe las instrucciones para el asistente...">Eres un asistente especializado en el programa PNTE (Programa Nacional de Transformación Empresarial) del gobierno peruano. Tu objetivo es ayudar a asesores y empresarios con información precisa sobre normativas, procedimientos y mejores prácticas del programa. Debes ser claro, profesional y siempre citar las fuentes oficiales cuando proporciones información regulatoria.</textarea>
                </div>

                <div class="p-6 border-t border-white/10 flex gap-3 justify-end">
                    <button id="cancelModalBtn"
                        class="px-5 py-2.5 bg-white/5 text-gray-300 rounded-xl hover:bg-white/10 transition-colors">
                        Cancelar
                    </button>
                    <button id="saveModalBtn"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const editModal = document.getElementById('editModal');
        const editPromptBtn = document.getElementById('editPromptBtn');
        const cancelModalBtn = document.getElementById('cancelModalBtn');
        const saveModalBtn = document.getElementById('saveModalBtn');

        editPromptBtn.addEventListener('click', () => {
            editModal.classList.remove('hidden');
        });

        cancelModalBtn.addEventListener('click', () => {
            editModal.classList.add('hidden');
        });

        saveModalBtn.addEventListener('click', () => {
            const newPrompt = document.getElementById('promptTextarea').value;

            console.log('Nuevo prompt:', newPrompt);
            editModal.classList.add('hidden');
            alert('Instrucciones guardadas correctamente');
        });

        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) {
                editModal.classList.add('hidden');
            }
        });
    </script>
@endpush
