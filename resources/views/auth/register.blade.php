<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-pink-50 to-purple-100 px-4 py-12 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="text-center">
                <h2 class="text-3xl font-display font-bold text-dating-primary">
                    Créez votre compte
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Rejoignez-nous et commencez votre aventure romantique !
                </p>
            </div>

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="sr-only">Nom</label>
                    <input id="name" name="name" type="text" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-dating-primary focus:border-dating-primary sm:text-sm"
                           placeholder="Votre nom">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="sr-only">Adresse email</label>
                    <input id="email" name="email" type="email" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-dating-primary focus:border-dating-primary sm:text-sm"
                           placeholder="Adresse email">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="sr-only">Mot de passe</label>
                    <input id="password" name="password" type="password" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-dating-primary focus:border-dating-primary sm:text-sm"
                           placeholder="Mot de passe">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="sr-only">Confirmez le mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-dating-primary focus:border-dating-primary sm:text-sm"
                           placeholder="Confirmez le mot de passe">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-dating-primary hover:bg-dating-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dating-primary">
                        S'inscrire
                    </button>
                </div>

                <div class="text-center text-sm">
                    <p class="text-gray-600">
                        Vous avez déjà un compte ?
                        <a href="{{ route('login') }}" class="font-medium text-dating-primary hover:text-dating-primary/80">
                            Connectez-vous
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
