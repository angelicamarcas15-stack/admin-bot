<header class="w-full h-16 bg-[#0D1324] border-b border-white/5 flex items-center justify-between px-6">

    <!-- LEFT: LOGO -->
    <div class="flex items-center gap-2">
        <div class="w-7 h-7 rounded-md bg-gradient-to-r from-blue-500 to-blue-300"></div>
        <span class="text-lg font-semibold tracking-wide text-white">ABC</span>
    </div>

    <!-- RIGHT: ICONS + USER -->
    <div class="flex items-center gap-6 text-gray-300">

        <!-- Notification -->
        <button class="hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="#9CA3AF" stroke-width="1.3" viewBox="0 0 24 24">
                <path d="M12 22a2 2 0 002-2H10a2 2 0 002 2z" />
                <path d="M18 16v-5a6 6 0 10-12 0v5l-2 2h16z" />
            </svg>
        </button>

        <div class="h-6 w-px bg-white/10"></div>

        <!-- USER MENU -->
        <div class="relative">
            <button id="userMenuBtn" class="flex items-center gap-2 cursor-pointer select-none">
                <span class="text-sm text-white">Alexander</span>
                <img src="https://i.pravatar.cc/40?img=47" class="w-8 h-8 rounded-full" />
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </button>

            <div id="userMenu"
                class="hidden absolute right-0 mt-2 w-40 bg-[#11192F] border border-white/10 rounded-xl shadow-xl z-50">
                <a class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 rounded-t-xl" href="#">Ver
                    perfil</a>
                <a class="block px-4 py-2 text-sm text-red-400 hover:bg-white/10 rounded-b-xl" href="#">Cerrar
                    sesión</a>
            </div>
        </div>

    </div>

</header>
