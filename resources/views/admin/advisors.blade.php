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


        <!-- Advisors -->
        <section class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-white/5 flex items-center justify-between">
                <div>
                <h1 class="text-2xl font-semibold text-white">Asesores</h1>
                <p class="text-sm text-gray-400 mt-1">Gestiona tu equipo de asesores</p>
                </div>
                <button id="addBtn" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Agregar Asesor
                </button>
            </div>

            <!-- Table -->
            <div class="flex-1 overflow-auto p-6">
                <div class="bg-[#0D1324] rounded-xl border border-white/5 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-white/5">
                    <tr class="text-left text-sm text-gray-400">
                        <th class="px-6 py-4 font-medium">Nombre</th>
                        <th class="px-6 py-4 font-medium">Contacto</th>
                        <th class="px-6 py-4 font-medium">Región</th>
                        <th class="px-6 py-4 font-medium">Provincia</th>
                        <th class="px-6 py-4 font-medium">Distrito</th>
                        <th class="px-6 py-4 font-medium text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody id="asesoresTable" class="text-sm">
                        @foreach($advisors as $advisor)
                            <tr class="border-b border-white/5">
                                <td class="px-6 py-4">{{ $advisor->name }}</td>
                                <td class="px-6 py-4">{{ $advisor->contact }}</td>
                                <td class="px-6 py-4">{{ $advisor->department_name }}</td>
                                <td class="px-6 py-4">{{ $advisor->province_name }}</td>
                                <td class="px-6 py-4">{{ $advisor->district_name }}</td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                    <button onclick='editAsesor(@json($advisor))' class="p-2 hover:bg-blue-500/20 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button type="button" onclick='deleteAsesor(@json($advisor))' class="p-2 hover:bg-red-500/20 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($advisors->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No se encontraron asesores
                                </td>
                            </tr>
                        @endif
                    </tbody>

                </table>
                </div>
            </div>
        </section>

        <!-- MODAL -->
        <div id="modal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50 p-4">
            <div class="bg-[#0D1324] rounded-2xl border border-white/10 w-full max-w-md">
            <div class="p-6 border-b border-white/10">
                <h2 id="modalTitle" class="text-xl font-semibold text-white">Agregar Asesor</h2>
            </div>

            <div class="p-6 space-y-4">
                <div>
                <label class="block text-sm text-gray-400 mb-2">Nombre del Asesor</label>
                <input id="nombreInput" type="text" class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-white placeholder-gray-500 border border-white/5 focus:border-blue-500 outline-none" placeholder="Ej: Juan Pérez" />
                </div>

                <div>
                <label class="block text-sm text-gray-400 mb-2">Número de Contacto</label>
                <input id="contactoInput" type="tel" class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-white placeholder-gray-500 border border-white/5 focus:border-blue-500 outline-none" placeholder="Ej: 987654321" />
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">Departamento</label>
                    <select id="regionSelect"
                        onchange="onChangeUbigeo(this.value, 'province')"
                        class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-white border border-white/5 focus:border-blue-500 outline-none">
                        <option value="">Seleccionar departamento</option>

                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id_depa }}">{{ $dept->department }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                <label class="block text-sm text-gray-400 mb-2">Provincia</label>
                <select id="provinciaSelect"
                onchange="onChangeUbigeo(this.value, 'district')"
                class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-white border border-white/5 focus:border-blue-500 outline-none">
                    <option value="">Seleccionar provincia</option>
                </select>
                </div>

                <div>
                <label class="block text-sm text-gray-400 mb-2">Distrito</label>
                <select id="distritoSelect" class="w-full bg-[#1A2236] px-4 py-2.5 rounded-xl text-white border border-white/5 focus:border-blue-500 outline-none">
                    <option value="">Seleccionar distrito</option>
                </select>
                </div>
            </div>

            <div class="p-6 border-t border-white/10 flex gap-3 justify-end">
                <button id="cancelBtn" class="px-5 py-2.5 bg-white/5 text-gray-300 rounded-xl hover:bg-white/10 transition-colors">
                Cancelar
                </button>
                <button id="saveBtn" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                Guardar
                </button>
            </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let editingId = null;

        const modal = document.getElementById('modal');
        const addBtn = document.getElementById('addBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');
        const modalTitle = document.getElementById('modalTitle');
        const table = document.getElementById('asesoresTable');

        const nombreInput = document.getElementById('nombreInput');
        const contactoInput = document.getElementById('contactoInput');
        const regionSelect = document.getElementById('regionSelect');
        const provinciaSelect = document.getElementById('provinciaSelect');
        const distritoSelect = document.getElementById('distritoSelect');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
            editingId = null;
            clearForm();
        }

        function clearForm() {
            nombreInput.value = '';
            contactoInput.value = '';
            regionSelect.value = '';
            provinciaSelect.value = '';
            distritoSelect.value = '';
        }

        addBtn.addEventListener('click', () => {
            modalTitle.textContent = 'Agregar Asesor';
            setSelectOptions(provinciaSelect, []);
            setSelectOptions(distritoSelect, []);
            openModal();
        });

        cancelBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });


        saveBtn.addEventListener('click', async () => {
            const nombre = nombreInput.value.trim();
            const contacto = contactoInput.value.trim();
            const region = regionSelect.value;
            const provincia = provinciaSelect.value;
            const distrito = distritoSelect.value;

            if (!nombre || !contacto || !region || !provincia || !distrito) {
                alert('Por favor completa todos los campos');
                return;
            }

            const formData = new FormData();
            formData.append('name', nombre);
            formData.append('contact', contacto);
            formData.append('id_depa', region);
            formData.append('id_prov', provincia);
            formData.append('id_dist', distrito);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            let url = '/advisors';
            let method = 'POST';

            if (editingId) {
                url = `/advisors/${editingId}`;
                formData.append('_method', 'PUT');
                method = 'POST';
            }

            const res = await fetch(url, {
                method: method,
                body: formData
            });

            if (res.ok) {
                closeModal();
                location.reload();
            } else {
                alert('Error al guardar');
            }
        });

        const getDepartments = () => axios.get(`/ubigeo/departments`);
        const getProvinces = (idDepa) => axios.get(`/ubigeo/provinces/${idDepa}`);
        const getDistricts = (idProv) => axios.get(`/ubigeo/districts/${idProv}`);

        function setSelectOptions(selectElement, items, labelKey = 'name', valueKey = 'id') {
            const placeholders = {
                province: 'provincia',
                district: 'distrito',
                department: 'departamento'
            };

            const placeholder = labelKey && placeholders[labelKey]
                ? `Seleccione ${placeholders[labelKey]}`
                : 'Seleccione';

            selectElement.innerHTML = `<option value="">${placeholder}</option>`;

            items.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valueKey];
                option.textContent = item[labelKey];
                selectElement.appendChild(option);
            });
        }

        const onChangeUbigeo = async (value, type) => {
            switch (type) {
                case 'province':
                    provinciaSelect.value = "";
                    distritoSelect.value = "";
                    setSelectOptions(distritoSelect, []);

                    const provinces = await getProvinces(value);
                    setSelectOptions(provinciaSelect, provinces.data, 'province', 'id_prov');
                    break;

                case 'district':
                    distritoSelect.value = "";
                    const districts = await getDistricts(value);
                    setSelectOptions(distritoSelect, districts.data, 'district', 'id_dist');
                    break;
            }
        }


        async function editAsesor(advisor) {
            editingId = advisor.id;
            modalTitle.textContent = "Editar Asesor";
            document.getElementById('nombreInput').value = advisor.name;
            document.getElementById('contactoInput').value = advisor.contact;
            document.getElementById('regionSelect').value = advisor.id_depa;

            const provinces = await getProvinces(advisor.id_depa);
            setSelectOptions(provinciaSelect, provinces.data, 'province', 'id_prov');
            document.getElementById('provinciaSelect').value = advisor.id_prov;
            const districts = await getDistricts(advisor.id_prov);
            setSelectOptions(distritoSelect, districts.data, 'district', 'id_dist');
            document.getElementById('distritoSelect').value = advisor.id_dist;
            openModal();
        }


        async function deleteAsesor({ id }) {
            if (!confirm('¿Estás seguro de eliminar este asesor?')) {
                return;
            }

            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            const res = await fetch(`/advisors/${id}`, {
                method: 'POST',
                body: formData
            });

            if (res.ok) {
                location.reload();
            } else {
                alert('Error al eliminar asesor');
            }
        };
    </script>
@endpush
