<aside class="w-60 bg-[#0D1324] border-r border-white/5 flex flex-col py-6 px-4">
    <nav class="flex-1 space-y-1">

        <a href="/dashboard"
           class="flex items-center gap-3 px-3 py-2 rounded-xl
           {{ request()->is('dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-white/10' }}">
            Inbox
        </a>

        <a href="/map"
           class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10">
            Analytics
        </a>

        <a href="{{ route('admin.advisors') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-xl
           {{ request()->is('advisors*') ? 'bg-blue-600 text-white' : 'hover:bg-white/10' }}">
            Asesores
        </a>

        <a href="{{ route('admin.ai_assistant_settings') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-xl
           {{ request()->is('ai-assistant*') ? 'bg-blue-600 text-white' : 'hover:bg-white/10' }}">
            Configurar Asistente
        </a>

    </nav>

    <div class="mt-8 bg-white/5 py-2 px-3 rounded-xl flex justify-between text-sm">
        <button id="lightBtn" class="hover:text-white transition-colors">Light</button>
        <button id="darkBtn" class="hover:text-white transition-colors">Dark</button>
    </div>
</aside>
