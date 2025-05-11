<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-love-100 to-dating-light px-4 py-12 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl">
            <div class="text-center">
                <h2 class="text-3xl font-display font-bold text-dating-primary">
                    Welcome Back
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Ready to continue your dating adventure?
                </p>
            </div>

            <!-- Afficher les erreurs de connexion -->
            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            Ces identifiants ne correspondent à aucun compte. 
                            <a href="{{ route('register') }}" class="font-medium underline hover:text-red-600">
                                Créer un compte
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-dating-primary focus:border-dating-primary sm:text-sm"
                               placeholder="Email address">
                    </div>

                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required
                               class="appearance-none rounded-lg relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-dating-primary focus:border-dating-primary sm:text-sm"
                               placeholder="Password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                               class="h-4 w-4 text-dating-primary focus:ring-dating-primary border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Remember me
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-dating-primary hover:text-love-600">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-dating-primary hover:bg-love-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-dating-primary">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="text-center text-sm mt-4">
                <p class="text-gray-600">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="font-medium text-dating-primary hover:text-love-600">
                        S'inscrire
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
