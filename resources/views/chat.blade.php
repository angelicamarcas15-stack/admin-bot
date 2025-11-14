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

            <input class="w-full bg-[#1A2236] px-4 py-3 rounded-xl placeholder-gray-500" placeholder="Search" />

            <div class="flex-1 overflow-y-auto space-y-3 pr-1">
                @foreach ($users as $user)
                    @php
                        $nombreCompleto = trim(($user->nombres ?? '') . ' ' . ($user->apellidos ?? ''));
                        $phone = FormatHelper::cleanPhone($user->phone ?? '');
                        $displayName = $nombreCompleto !== '' ? $nombreCompleto : $phone;
                    @endphp

                    <div onclick="selectUser({{ $user->id }}, '{{ addslashes($displayName) }}')"
                        id="user-{{ $user->id }}"
                        class="flex items-center justify-between p-3 rounded-xl bg-[#1A2236] hover:bg-[#1f2a45] cursor-pointer">
                        <div class="flex items-center gap-3">
                            <img src="https://i.pravatar.cc/40?img=12" class="w-11 h-11 rounded-full" />
                            <div>
                                <p class="font-medium text-[15px]">{{ $displayName }}</p>
                            </div>
                        </div>
                        <span class="bg-red-500 text-xs px-2 py-0.5 rounded-full">2</span>
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
                    placeholder="Message..." />

                <button id="send-btn" class="px-5 py-3 bg-blue-600 rounded-2xl text-white">
                    Send
                </button>
            </div>

        </section>

    </div>

@endsection



@push('scripts')
    <script>
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
        //   MENSAJES CON TU DISEÑO EXACTO (LO QUE ME MOSTRASTE)
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

            const avatar = document.createElement("img");
            avatar.src = isUser ?
                "https://i.pravatar.cc/40?img=5" :
                "https://i.pravatar.cc/40?img=12";
            avatar.className = "w-10 h-10 rounded-full";

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
                    "bg-blue-600 text-white px-4 py-2 rounded-2xl inline-block text-right" :
                    "bg-[#1A2236] px-4 py-2 rounded-2xl inline-block";
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


        async function selectUser(id, name) {
            setActiveUser(id);
            selectedUser = id;
            header.textContent = `Conversación con ${name}`;
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
