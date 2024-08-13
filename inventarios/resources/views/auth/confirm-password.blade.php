<x-guest-layout>

    <!-- Mensaje de texto que se muestra al usuario -->
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

        <!-- Formulario para confirmar la contraseña del usuario -->
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Campo para la contraseña -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <!-- Campo de entrada para la contraseña -->
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

     <!-- Mostrar errores de validación para el campo de contraseña -->                 
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

     <!-- Botón para enviar el formulario -->
        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
