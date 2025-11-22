<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>MarketVista - Login</title>

    <style>
        body.light-mode {
            background-color: #f5f7fa;
        }

        body.light-mode .bg-\[\#0B1221\] {
            background-color: #f5f7fa;
        }

        body.light-mode .bg-\[\#0D1324\] {
            background-color: #ffffff;
        }

        body.light-mode .bg-\[\#1A2236\] {
            background-color: #e5e7eb;
        }

        body.light-mode .text-gray-300 {
            color: #4b5563;
        }

        body.light-mode .text-gray-400 {
            color: #6b7280;
        }

        body.light-mode .text-white {
            color: #1f2937;
        }

        body.light-mode .border-white\/5,
        body.light-mode .border-white\/10 {
            border-color: rgba(0, 0, 0, 0.1);
        }

        body.light-mode .bg-white\/5 {
            background-color: rgba(0, 0, 0, 0.05);
        }

        body.light-mode .bg-blue-600 {
            background-color: #60a5fa !important;
        }
    </style>
</head>

<body class="bg-[#0B1221] min-h-screen flex items-center justify-center p-4">
    <div class="absolute top-6 right-6 bg-white/5 py-2 px-3 rounded-xl flex gap-2 text-sm text-gray-300">
        <button id="lightBtn" class="hover:text-white transition-colors">Light</button>
        <span class="text-gray-600">|</span>
        <button id="darkBtn" class="hover:text-white transition-colors">Dark</button>
    </div>

    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-8">
            <div
                class="w-16 h-16 rounded-2xl bg-gradient-to-r from-blue-500 to-blue-300 mb-4 flex items-center justify-center">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Asesor Virtual</h1>
            <p class="text-gray-400 text-sm">Sistema de Seguimiento</p>
        </div>

        <div class="bg-[#0D1324] rounded-2xl border border-white/5 shadow-2xl overflow-hidden">

            <div class="p-8">
                <h2 class="text-2xl font-semibold text-white mb-2">Iniciar Sesión</h2>
                <p class="text-gray-400 text-sm mb-6">Ingresa tus credenciales para continuar</p>

                <form method="POST" action="/login" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Correo electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" required value="admin@admin.com"
                                class="w-full bg-[#1A2236] pl-12 pr-4 py-3 rounded-xl text-white placeholder-gray-500 border border-white/5 focus:border-blue-500 outline-none transition-colors"
                                placeholder="tu@email.com" />
                        </div>
                    </div>


                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>

                            <input type="password" id="password" name="password" required value="123123123"
                                class="w-full bg-[#1A2236] pl-12 pr-12 py-3 rounded-xl text-white placeholder-gray-500 border border-white/5 focus:border-blue-500 outline-none transition-colors"
                                placeholder="••••••••" />

                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-300">
                                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>


                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-gray-600 bg-[#1A2236] text-blue-600 focus:ring-blue-500 focus:ring-offset-0" />
                            <span class="ml-2 text-sm text-gray-400">Recordarme</span>
                        </label>
                    </div>


                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <span>Iniciar Sesión</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>


                    @if ($errors->any())
                        <p class="text-red-400 text-sm mt-2">{{ $errors->first() }}</p>
                    @endif

                </form>

            </div>

        </div>

        <!-- Additional Info -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                Al iniciar sesión, aceptas nuestros
                <a href="#" class="text-gray-400 hover:text-gray-300 underline">Términos de Servicio</a> y
                <a href="#" class="text-gray-400 hover:text-gray-300 underline">Política de Privacidad</a>
            </p>
        </div>

    </div>

    <script>
        document.getElementById('lightBtn').addEventListener('click', () => {
            document.body.classList.add('light-mode');
        });

        document.getElementById('darkBtn').addEventListener('click', () => {
            document.body.classList.remove('light-mode');
        });

        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;

            // Change icon
            if (type === 'text') {
                eyeIcon.innerHTML =
                    '<path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                eyeIcon.innerHTML =
                    '<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        });
    </script>

</body>

</html>
