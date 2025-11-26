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

        <!-- CHAT LIST -->
        <section class="w-96 border-r border-white/5 flex flex-col p-4 gap-4">

            <input id="searchInput" class="w-full bg-[#1A2236] px-4 py-3 rounded-xl placeholder-gray-500"
                placeholder="Buscar empresario" />

            <div id="chatlist" class="flex-1 overflow-y-auto space-y-3 pr-1">
                @foreach ($users as $user)
                    @php
                        $nombreCompleto = trim(($user->nombres ?? '') . ' ' . ($user->apellidos ?? ''));
                        $phone = FormatHelper::cleanPhone($user->phone ?? '');
                        $displayName = $nombreCompleto !== '' ? $nombreCompleto : $phone;
                        $initial = $nombreCompleto !== '' ? strtoupper(substr($nombreCompleto, 0, 1)) : null;
                    @endphp

                    <div onclick='selectUser(@json($user))'
                        id="user-{{ $user->id }}"
                        class="flex items-center justify-between p-3 rounded-xl bg-[#1A2236] hover:bg-[#1f2a45] cursor-pointer">

                        <div class="flex items-center gap-3">
                            @if ($initial)
                                <div class="w-11 h-11 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-lg">
                                    {{ $initial }}
                                </div>
                            @else
                                <div class="w-11 h-11 rounded-full bg-gray-500 flex items-center justify-center text-white font-semibold text-lg">
                                    <span class="text-xs">?</span>
                                </div>
                            @endif

                            <div>
                                <p class="font-medium text-[15px]">{{ $displayName }}</p>
                            </div>
                        </div>

                        <span class="bg-red-500 text-xs px-2 py-0.5 rounded-full">
                            {{ $user->messages_count }}
                        </span>

                    </div>
                @endforeach
            </div>


        </section>


        <!-- CHAT PANEL -->
        <section class="flex-1 flex flex-col">

            <h2 id="chat-header" class="text-lg font-semibold px-10 py-4 border-b border-white/5">
                Selecciona un usuario
            </h2>

            <!-- CONTENEDOR DE MENSAJES -->
            <div id="messages" class="flex flex-col h-full overflow-y-auto space-y-3 p-4">
                <p class="text-gray-500 text-center">Selecciona un usuario para ver el chat.</p>
            </div>

            <!-- INPUT BAR -->
            <div class="p-5 border-t border-white/5 flex items-center gap-3">
                <input id="message-input" class="flex-1 bg-[#1A2236] px-4 py-3 rounded-2xl placeholder-gray-500"
                    placeholder="Mensaje..." />

                <button id="send-btn" class="px-5 py-3 bg-blue-600 rounded-2xl text-white">
                    Responder
                </button>
            </div>

        </section>

    </div>

@endsection



@push('scripts')
    <script>
        // ---------------------
        //   BUSCADOR EN VIVO
        // ---------------------
        const searchInput = document.getElementById("searchInput");
        const chatlist = document.getElementById("chatlist");

        searchInput.addEventListener("input", function() {
            const text = this.value.toLowerCase().trim();

            document.querySelectorAll("#chatlist > div").forEach(item => {
                const name = item.innerText.toLowerCase();

                // Mostrar u ocultar
                if (name.includes(text)) {
                    item.style.display = "flex";
                } else {
                    item.style.display = "none";
                }
            });
        });


        // ---------------------
        //  DEFENSIVE CSRF FIX
        // ---------------------
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

        const messagesDiv = document.getElementById('messages');
        const input = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-btn');
        const header = document.getElementById('chat-header');

        let selectedUser = null;
        let lastMessageCount = 0;
        let selectedUserName = null;


        function clearMessages() {
            messagesDiv.innerHTML = '';
        }

        function formatTime(dateStr) {
            const d = new Date(dateStr);
            if (isNaN(d)) return "";
            return d.toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit"
            });
        }

        function setActiveUser(id) {
            document.querySelectorAll('[id^="user-"]').forEach(el =>
                el.classList.remove("active-user")
            );
            const el = document.getElementById(`user-${id}`);
            if (el) el.classList.add("active-user");
        }



        // ----------------------------------------------------------
        //   MENSAJES CON TU DISEÑO EXACTO (LO QUE ME MOSTRASTE) //
        // ----------------------------------------------------------

        let lastMessageDate = null;
        let lastMessageTime = null;

        function formatFullDate(dateStr) {
            const d = new Date(dateStr);
            return d.toLocaleDateString("es-PE", {
                day: "2-digit",
                month: "long",
                year: "numeric"
            });
        }



        function appendMessage(msg) {
            const isUser = Number(msg.is_bot) === 0;

            const wrapper = document.createElement("div");
            wrapper.className = isUser ?
                "flex items-start justify-end gap-3" :
                "flex items-start gap-3";

            let avatar;

            if (isUser) {
                avatar = document.createElement("img");
                avatar.src = "/img/bot.jpg";
                avatar.className = "w-10 h-10 rounded-full";

            } else {
                const avatarWrapper = document.createElement("div");
                avatarWrapper.className =
                    "w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold text-lg";

                if (selectedUserName && selectedUserName.trim() !== "") {
                    avatarWrapper.classList.add("bg-blue-600");
                    avatarWrapper.textContent = selectedUserName.charAt(0).toUpperCase();
                } else {
                    avatarWrapper.classList.add("bg-gray-500");
                    avatarWrapper.innerHTML = `<span class="text-sm">?</span>`;
                }

                avatar = avatarWrapper;
            }

            const info = document.createElement("div");

            // ------------------------------
            // FORMATEO DE HORA Y FECHA
            // ------------------------------
            const d = new Date(msg.created_at);
            const msgDate = d.toDateString();
            const msgTime = d.toLocaleTimeString([], {
                hour: "2-digit",
                minute: "2-digit"
            });

            const time = document.createElement("p");
            time.className = "text-xs text-gray-500 mb-1";

            let showTime = false;

            // Si es otro día → mostrar fecha completa
            if (msgDate !== lastMessageDate) {
                time.textContent = formatFullDate(msg.created_at);
                lastMessageDate = msgDate;
                lastMessageTime = msgTime; // reinicia agrupación
                showTime = true;

            } else if (msgTime !== lastMessageTime) {
                // mismo día pero distinta hora → mostrar hora
                time.textContent = msgTime;
                lastMessageTime = msgTime;
                showTime = true;
            }

            // Si no se muestra fecha/hora → no agregamos el elemento time

            // ----------------------------------------
            // BURBUJA NORMAL O STICKER
            // ----------------------------------------
            const bubble = document.createElement("p");

            if (msg.message.startsWith("[STICKER]")) {
                const file = msg.message.replace("[STICKER]", "").trim();
                const img = document.createElement("img");
                img.src = `/stickers/${file}`;
                img.className = "w-28 h-28 rounded-xl";
                bubble.className = "bg-transparent inline-block";
                bubble.appendChild(img);
            } else {
                bubble.className = isUser ?
                    "max-w-[372px] bg-blue-600 text-white px-4 py-2 rounded-2xl inline-block text-right" :
                    "max-w-[372px] bg-[#1A2236] px-4 py-2 rounded-2xl inline-block";
                bubble.textContent = msg.message;
            }

            // ----------------------------------------
            // ARMADO VISUAL
            // ----------------------------------------

            if (isUser) {
                info.className = "text-right";
                if (showTime) info.appendChild(time);
                info.appendChild(bubble);
                wrapper.appendChild(info);
                wrapper.appendChild(avatar);

            } else {
                if (showTime) info.appendChild(time);
                info.appendChild(bubble);
                wrapper.appendChild(avatar);
                wrapper.appendChild(info);
            }

            messagesDiv.appendChild(wrapper);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }



        async function loadMessages(id) {
            const res = await fetch(`/messages/${id}`);
            if (!res.ok) return [];
            return await res.json();
        }


        function setActiveUser(id) {
            document.querySelectorAll('[id^="user-"]').forEach(el =>
                el.classList.remove("active-user")
            );
            const el = document.getElementById(`user-${id}`);
            if (el) el.classList.add("active-user");
        }

        function cleanPhone(phone) {
            if (!phone) return '';

            let p = String(phone).trim();

            if (p.includes('@')) {
                p = p.split('@')[0];
            }

            p = p.replace(/\D/g, '');

            if (p.startsWith('51')) {
                p = p.substring(2);
            }

            return p;
        }


        async function selectUser({ id, nombres, apellidos, phone }, name) {
            const nombreCompleto = `${nombres ?? ''} ${apellidos ?? ''}`.trim();
            const cleanedPhone = cleanPhone(phone);
            const displayName = nombreCompleto !== '' ? nombreCompleto : cleanedPhone;
            const initial = nombreCompleto !== '' ? nombreCompleto.substring(0, 1).toUpperCase() : null;
            setActiveUser(id);
            selectedUser = id;
            selectedUserName = initial ? displayName : null;
            header.textContent = `Conversación con ${displayName}`;
            clearMessages();

            const msgs = await loadMessages(id);
            lastMessageCount = msgs.length;
            msgs.forEach(appendMessage);
        }


        async function pollMessages() {
            if (!selectedUser) return;

            const msgs = await loadMessages(selectedUser);

            if (msgs.length > lastMessageCount) {
                msgs.slice(lastMessageCount).forEach(appendMessage);
                lastMessageCount = msgs.length;
            }
        }

        setInterval(pollMessages, 3000);



        sendBtn.addEventListener("click", async () => {
            if (!selectedUser) return alert("Selecciona un usuario primero");

            const message = input.value.trim();
            if (!message) return;

            input.value = "";

            await fetch("/messages", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    user_id: selectedUser,
                    message,
                })
            });
        });
    </script>
@endpush
