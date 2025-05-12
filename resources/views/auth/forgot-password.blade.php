<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-pink-50 to-purple-100 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
                <h2 class="text-3xl font-display font-bold text-dating-primary">
                    Mot de passe oublié ?
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Pas de panique ! Nous allons vous envoyer un email pour réinitialiser votre mot de passe.
                </p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4">
                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div>
                    <label for="email" class="sr-only">Adresse email</label>
                    <input id="email" name="email" type="email" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-dating-primary focus:border-dating-primary sm:text-sm"
                           placeholder="Votre adresse email">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit"
                            class="w-full py-3 px-6 rounded-lg bg-dating-primary text-white hover:bg-dating-primary/90 transition-colors duration-200">
                        Envoyer le lien
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" 
                       class="text-sm font-medium text-dating-primary hover:text-dating-primary/80">
                        Retour à la connexion
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
