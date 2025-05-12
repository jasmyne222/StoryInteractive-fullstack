<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-pink-50 to-purple-100 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl transform hover:scale-105 transition-all duration-300">
            <!-- Logo/Icon -->
            <div class="text-center">
                <div class="mx-auto h-20 w-20 bg-dating-primary/10 rounded-full flex items-center justify-center">
                    <span class="text-4xl">💕</span>
                </div>
                <h2 class="mt-6 text-3xl font-bold text-dating-primary">
                    Date Simulator
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Prêt(e) pour une nouvelle aventure ?
                </p>
            </div>

            <!-- Formulaire -->
            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="relative">
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                           class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm
                                  focus:ring-dating-primary focus:border-dating-primary
                                  transition-colors duration-200"
                           placeholder="Email address">
                </div>

                <!-- Password -->
                <div class="relative">
                    <label class="text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" name="password" required
                           class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm
                                  focus:ring-dating-primary focus:border-dating-primary
                                  transition-colors duration-200"
                           placeholder="Password">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember"
                               class="h-4 w-4 rounded border-gray-300 text-dating-primary
                                      focus:ring-dating-primary">
                        <label class="ml-2 text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>
                    <a href="{{ route('password.request') }}"
                       class="text-sm font-medium text-dating-primary hover:text-dating-primary/80">
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full px-4 py-3 rounded-lg text-white bg-dating-primary
                               hover:bg-dating-primary/90 transition-colors duration-200
                               font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Se connecter
                </button>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Pas encore de compte ?
                        <a href="{{ route('register') }}"
                           class="font-medium text-dating-primary hover:text-dating-primary/80">
                            S'inscrire
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
