<header class="w-full h-16 bg-[#0D1324] border-b border-white/5 flex items-center justify-between px-6">

    <div class="flex items-center gap-2">
        <div class="w-7 h-7 rounded-md bg-gradient-to-r from-blue-500 to-blue-300"></div>
        <span class="text-lg font-semibold tracking-wide text-white">PROGRAMA</span>
    </div>

    <div class="flex items-center gap-6 text-gray-300">

        <button class="hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="#9CA3AF" stroke-width="1.3" viewBox="0 0 24 24">
                <path d="M12 22a2 2 0 002-2H10a2 2 0 002 2z" />
                <path d="M18 16v-5a6 6 0 10-12 0v5l-2 2h16z" />
            </svg>
        </button>

        <div class="h-6 w-px bg-white/10"></div>

        <div class="relative">
            <button id="userMenuBtn" class="flex items-center gap-2 cursor-pointer select-none">
                <span class="text-sm text-white">{{ Auth::guard('admin')->user()->name }}</span>
                <img src="https://i.pravatar.cc/40?u={{ Auth::guard('admin')->user()->id }}"
                    class="w-8 h-8 rounded-full" />
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </button>

            <div id="userMenu"
                class="hidden absolute right-0 mt-2 w-40 bg-[#11192F] border border-white/10 rounded-xl shadow-xl z-50">

                <a class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/10 rounded-t-xl" href="#">Ver
                    perfil</a>

                <button onclick="document.getElementById('logoutForm').submit()"
                    class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-white/10 rounded-b-xl">
                    Cerrar sesión
                </button>

                <form id="logoutForm" action="/logout" method="POST" class="hidden">
                    @csrf
                </form>

            </div>
        </div>

    </div>

</header>


@push('scripts')
    <script>
        // User menu toggle
        const userBtn = document.getElementById('userMenuBtn');
        const userMenu = document.getElementById('userMenu');

        userBtn.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!userBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
@endpush
