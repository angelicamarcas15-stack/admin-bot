@php
    use App\Helpers\FormatHelper;
@endphp

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

            <div class="flex-1 overflow-auto p-6 space-y-6 s-scroll">

                <!-- Instrucciones Principales -->
                <div class="bg-[#0D1324] rounded-xl border border-white/5 p-5">

                    <div id="prompt" class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-white">Instrucciones Principales</h2>

                        <button id="editPromptBtn"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            {{ isset($config) && $config->id ? 'Editar' : 'Agregar' }}
                        </button>
                    </div>

                    @if (!empty($config->instructions))
                        <div class="bg-[#1A2236] rounded-lg p-4 border border-white/5 mt-3 h-64 overflow-auto s-scroll">
                            <p class="text-sm text-gray-300 leading-relaxed">
                                {{ $config->instructions }}
                            </p>
                        </div>
                    @endif

                </div>

                <!-- Archivos de Conocimiento -->
                <div class="bg-[#0D1324] rounded-xl border border-white/5 p-5">

                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-white">Archivos de Conocimiento</h2>

                        <button type="button" onclick="document.getElementById('knowledgeFile').click();"
                            class="px-4 py-2 bg-white/5 text-gray-300 rounded-lg hover:bg-white/10 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" />
                            </svg>
                            Subir Archivo (pdf)
                        </button>
                    </div>

                    <form id="uploadForm" action="{{ route('admin.knowledge.upload') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <input id="knowledgeFile" type="file" name="file" class="hidden"
                            onchange="document.getElementById('uploadForm').submit();">
                    </form>

                    <div class="space-y-3 mt-3">
                        @foreach ($files as $file)
                            <div
                                class="bg-[#1A2236] rounded-lg p-4 border border-white/5 flex items-center justify-between hover:border-blue-500/50 transition-colors">

                                <div class="flex items-center gap-3">

                                    <!-- Icono PDF -->
                                    <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-white">
                                            {{ $file->file_name }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ number_format($file->file_size / 1048576, 1) }} MB •
                                            Actualizado {{ $file->updated_at->diffForHumans() }}
                                        </p>
                                    </div>

                                </div>

                                <div class="flex items-center gap-2">

                                    <a href="{{ asset($file->file_path) }}" target="_blank"
                                        class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.knowledge.delete', $file->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 hover:bg-red-500/20 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>

                <!-- Referencias para el Asistente -->
                <div class="bg-[#0D1324] rounded-xl border border-white/5 p-5">

                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-white">Referencias Web</h2>

                        <button id="addRefBtn"
                            class="px-4 py-2 bg-white/5 text-gray-300 rounded-lg hover:bg-white/10 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 4v16m8-8H4" />
                            </svg>
                            Agregar URL
                        </button>
                    </div>

                    @if (count($webrefs) > 0)
                        <p class="text-sm text-gray-400 mb-4 mt-3">
                            URLs de referencia que el asistente puede consultar para obtener información actualizada
                        </p>
                    @endif

                    <div class="space-y-3">
                        @foreach ($webrefs as $ref)
                            <div class="bg-[#1A2236] rounded-lg p-4 border border-white/5">

                                <label class="block text-xs text-gray-400 mb-2">
                                    {{ $ref->title }}
                                </label>

                                <div class="flex items-center gap-2">
                                    <input type="text" value="{{ $ref->url }}" readonly
                                        class="flex-1 bg-[#0D1324] px-4 py-2 rounded-lg text-white border border-white/5 focus:border-blue-500 outline-none text-sm" />

                                    <form method="POST" action="{{ route('admin.webref.delete', $ref->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 hover:bg-red-500/20 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </section>

        <!-- MODAL EDITAR PROMPT -->
        <div id="editModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4">
            <div class="bg-[#0D1324] rounded-2xl border border-white/10 w-full max-w-3xl">

                <div class="p-6 border-b border-white/10">
                    <h2 class="text-xl font-semibold text-white">
                        {{ isset($config) && $config->id ? 'Editar' : 'Agregar' }} Instrucciones del Asistente
                    </h2>
                    <p class="text-sm text-gray-400 mt-1">Personaliza el comportamiento y contexto del asistente IA</p>
                </div>

                <div class="p-6">
                    <label class="block text-sm text-gray-400 mb-2">
                        Instrucciones principales del asistente
                    </label>

                    <textarea id="promptTextarea" rows="12"
                        class="w-full bg-[#1A2236] px-4 py-3 rounded-xl text-white placeholder-gray-500 border border-white/5 focus:border-blue-500 outline-none resize-none"
                        placeholder="Escribe las instrucciones para el asistente...">{{ $config->instructions ?? '' }}</textarea>
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

        <!-- MODAL: AGREGAR REFERENCIA WEB -->
        <div id="modalAddWebReference" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4">
            <div class="bg-[#0D1324] rounded-2xl border border-white/10 w-full max-w-md">

                <!-- Header -->
                <div class="p-6 border-b border-white/10">
                    <h2 id="modalAddWebReferenceTitle" class="text-xl font-semibold text-white">Agregar URL de Referencia
                    </h2>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-4">

                    <!-- TÍTULO -->
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Título</label>
                        <input id="webRefTitleInput" type="text"
                            class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-white placeholder-gray-500 border border-white/5
                        focus:border-blue-500 outline-none"
                            placeholder="Ej: GOB.PE - Portal del Estado Peruano" />
                    </div>

                    <!-- URL -->
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">URL</label>
                        <input id="webRefUrlInput" type="text"
                            class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-white placeholder-gray-500 border border-white/5
                        focus:border-blue-500 outline-none"
                            placeholder="https://www.gob.pe" />
                    </div>

                </div>

                <!-- Footer -->
                <div class="p-6 border-t border-white/10 flex gap-3 justify-end">
                    <button id="modalAddWebReferenceCancel"
                        class="px-5 py-2.5 bg-white/5 text-gray-300 rounded-xl hover:bg-white/10 transition-colors">
                        Cancelar
                    </button>

                    <button id="modalAddWebReferenceSave"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                        Guardar
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
            const configId = "{{ $config->id ?? null }}";
            const url = configId ? `/bot-config/${configId}` : "/bot-config";
            const method = configId ? "PUT" : "POST";

            fetch(url, {
                    method: method,
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        instructions: newPrompt
                    })
                })
                .then(res => res.json())
                .then(() => {
                    editModal.classList.add('hidden');
                    location.reload();
                })
                .catch(err => console.error(err));
        });

        editModal.addEventListener('click', (e) => {
            if (e.target === editModal) editModal.classList.add('hidden');
        });

        const modalAddWebReference = document.getElementById("modalAddWebReference");
        const cancelBtn = document.getElementById("modalAddWebReferenceCancel");
        const saveBtn = document.getElementById("modalAddWebReferenceSave");

        const titleInput = document.getElementById("webRefTitleInput");
        const urlInput = document.getElementById("webRefUrlInput");

        document.getElementById("addRefBtn").addEventListener("click", () => {
            openAddWebReferenceModal();
        });

        // Abrir modal
        function openAddWebReferenceModal() {
            titleInput.value = "";
            urlInput.value = "";
            modalAddWebReference.classList.remove("hidden");
        }

        // Cerrar modal
        function closeAddWebReferenceModal() {
            modalAddWebReference.classList.add("hidden");
        }

        cancelBtn.addEventListener("click", closeAddWebReferenceModal);

        // Guardar nueva referencia
        saveBtn.addEventListener("click", async () => {
            const title = titleInput.value.trim();
            const url = urlInput.value.trim();

            if (!title || !url) {
                alert("Completa ambos campos");
                return;
            }

            const res = await fetch("{{ route('admin.webref.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    title,
                    url
                })
            })

            if (res.ok) {
                closeAddWebReferenceModal();
                location.reload();
            } else {
                alert('Error al guardar');
            }
        });
    </script>
@endpush
