<!-- resources/views/layouts/navigation.blade.php -->
<nav class="bg-white border-r border-gray-100 w-64">
    <!-- Logo -->
    <div class="shrink-0 flex items-center p-4">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
        </a>
    </div>

    <!-- Lista de Enlaces de Navegación -->
    <div class="flex flex-col p-4 space-y-2">
        <x-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.index')">
            {{ __('Dashboard') }}
        </x-nav-link>
        <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.index')">
            {{ __('Productos') }}
        </x-nav-link>
        <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.index')">
            {{ __('Categorías') }}
        </x-nav-link>
        <x-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.index')">
            {{ __('Clientes') }}
        </x-nav-link>
        <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.index')">
            {{ __('Ventas') }}
        </x-nav-link>
        <x-nav-link :href="route('inventarios.index')" :active="request()->routeIs('inventarios.index')">
            {{ __('Inventarios') }}
        </x-nav-link>
        <x-nav-link :href="route('cotizaciones.index')" :active="request()->routeIs('cotizaciones.index')">
            {{ __('Cotizaciones') }}
        </x-nav-link>
        <x-nav-link :href="route('formasdepago.index')" :active="request()->routeIs('formasdepago.index')">
            {{ __('Formas de pago') }}
        </x-nav-link>
        <x-nav-link :href="route('vendedor.index')" :active="request()->routeIs('vendedor.index')">
            {{ __('Vendedor') }}
        </x-nav-link>
        <x-nav-link :href="route('proveedor.index')" :active="request()->routeIs('proveedor.index')">
            {{ __('Proveedor') }}
        </x-nav-link>
        
        <x-nav-link :href="route('compras.index')" :active="request()->routeIs('compras.index')">
            {{ __('Compras') }}
        </x-nav-link>
    </div>

    <!-- Opciones de Configuración -->
    <div class="flex flex-col p-4 border-t border-gray-200">
        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <x-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-nav-link>
        </form>
    </div>
</nav>
