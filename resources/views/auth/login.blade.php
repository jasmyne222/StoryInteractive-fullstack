<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-pink-50 to-purple-100 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
                <h2 class="text-3xl font-display font-bold text-dating-primary">
                    Connectez-vous
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Prêt(e) pour une nouvelle aventure ?
                </p>
            </div>

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="sr-only">Adresse email</label>
                    <input id="email" name="email" type="email" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-dating-primary focus:border-dating-primary sm:text-sm"
                           placeholder="Adresse email">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input id="password" name="password" type="password" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-dating-primary focus:border-dating-primary sm:text-sm"
                           placeholder="Mot de passe">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember"
                               class="h-4 w-4 rounded border-gray-300 text-dating-primary focus:ring-dating-primary">
                        <label class="ml-2 text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}"
                       class="text-sm font-medium text-dating-primary hover:text-dating-primary/80">
                        Mot de passe oublié ?
                    </a>
                </div>

                <button type="submit"
                        class="w-full px-4 py-3 rounded-lg text-white bg-dating-primary hover:bg-dating-primary/90 transition-colors duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Se connecter
                </button>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Pas encore de compte ?
                        <a href="{{ route('register') }}" class="font-medium text-dating-primary hover:text-dating-primary/80">
                            S'inscrire
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
