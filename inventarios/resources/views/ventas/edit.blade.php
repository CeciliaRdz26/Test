@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Editar venta</h1>
        <form method="POST" action="{{ route('ventas.update', $venta->id_venta) }}">
            @csrf
            @method('PUT')
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Categoria</label>
                    <select name="id_categoria" id="id_categoria" class="w-full p-2 border rounded">
                        @foreach ($categorias as $item)
                            <option value="{{ $item->id_categoria }}"
                                {{ $venta->categoria_id == $item->id_categoria ? 'selected' : '' }}>
                                {{ $item->nombre_categoria }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Cliente</label>
                    <select name="id_cliente" id="id_cliente" class="w-full p-2 border rounded">
                        @foreach ($clientes as $item)
                            <option value="{{ $item->id_cliente }}"
                                {{ $venta->cliente_id == $item->id_cliente ? 'selected' : '' }}>
                                {{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Tipo de pago</label>
                    <select name="id_pago" id="id_pago" class="w-full p-2 border rounded">
                        @foreach ($pagos as $item)
                            <option value="{{ $item->id }}" {{ $venta->pago_id == $item->id ? 'selected' : '' }}>
                                {{ $item->tipo }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Vendedor</label>
                    <select name="id_vendedor" id="id_vendedor" class="w-full p-2 border rounded">
                        @foreach ($vendedores as $item)
                            <option value="{{ $item->id }}" {{ $venta->vendedor_id == $item->id ? 'selected' : '' }}>
                                {{ $item->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Fecha</label>
                    <input type="date" name="fecha" value="{{ $venta->fecha_venta }}"
                        class="w-full p-2 border rounded" required>
                </div>
            </div>

            <div class="mb-4 grid grid-cols-4 gap-4">
                <table class="min-w-full bg-white border">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Producto</th>
                            <th class="py-2 px-4 border-b">Cantidad</th>
                            <th class="py-2 px-4 border-b">Precio</th>
                            <th class="py-2 px-4 border-b">Total</th>
                        </tr>
                    </thead>
                    @php
                        // Obtiene los productos de la cotización
                        $ventaproducto = ('App\Models\VentaProducto')::where('id_venta', $venta->id_venta)->get();
                    @endphp
                    <input type="hidden" name="totalCampos" id="totalCampos" value="">
                    <tbody>
                        <!-- Muestra los productos de la cotización-->
                        @foreach ($ventaproducto as $item)
                            <tr>
                                <input type="hidden" name="producto-id-{{ $item->id_producto }}"
                                    id="producto-id-{{ $item->id_producto }}">
                                <td class="py-2 px-4 border-b">
                                    <center>{{ $item->producto->nombre }}</center>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <center>
                                        <input type="number" id="cantidad-id-{{ $item->id_producto }}"
                                            name="cantidad-id-{{ $item->id_producto }}" value="{{ $item->cantidad }}"
                                            class="w-16 p-2 border rounded" required>
                                    </center>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <center>$ {{ $item->precio_venta }}</center>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <center>$ <b
                                            id="total-{{ $item->id_producto }}">{{ $item->precio_venta * $item->cantidad }}</b>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Agrega los productos nuevos -->
                <div id="dataproducto">
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <button type="button" onclick="addProducto()"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar nuevo
                    producto</button>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
            </div>
        </form>

        <script>
            // Lista de productos tomados
            let productosTomados = [];
            var totalDatos = 0; // Total de datos nuevos

            // Agrega los productos ya seleccionados
            @foreach ($ventaproducto as $producto)
                productosTomados.push('{{ $producto->id_producto }}');
            @endforeach
        
            // Calcula el total de la cotización
            @foreach ($ventaproducto as $producto)
                document.getElementById('cantidad-id-{{ $producto->id_producto }}').addEventListener('input', function() {
                    var cantidad = document.getElementById('cantidad-id-{{ $producto->id_producto }}').value;
                    var precio = {{ $producto->precio_venta }};
                    var total = cantidad * precio;
                    document.getElementById('total-{{ $producto->id_producto }}').innerHTML = total;
                });
            @endforeach

            function addProducto() {
                // Incrementa el total de datos
                totalDatos = totalDatos + 1;
                document.getElementById('totalCampos').value = totalDatos;

                // Crea el cuadro de productos
                let div = document.getElementById('dataproducto');
                const cuadro = document.createElement('div');
                cuadro.className = "mb-4 flex items-center space-x-4";
                cuadro.id = "cuadro-" + totalDatos;

                // Agrega el select de productos
                const optionsProducto = document.createElement('select');
                optionsProducto.id = "producto-" + totalDatos;
                optionsProducto.name = "producto-" + totalDatos;
                optionsProducto.options[0] = new Option("Seleccione un producto", "");
                // Agrega los productos
                @foreach ($productos as $producto)
                    @if($producto->categoria_id == $venta->categoria_id)
                        optionsProducto.options[optionsProducto.options.length] = new Option("{{ $producto->nombre }}",
                        "{{ $producto->id_producto }}");
                    @endif
                @endforeach
                optionsProducto.onchange = function() {
                    // Verifica si el producto ya ha sido seleccionado
                    if (productosTomados.includes(this.value)) {
                        alert("El producto ya ha sido guardado seleccionado otro producto");
                        this.selectedIndex = 0;
                    }
                };
                optionsProducto.className = "w-full p-2 border rounded text-gray-700";
                cuadro.appendChild(optionsProducto);

                // Agrega la cantidad del producto
                const btnCantidad = document.createElement('input');
                btnCantidad.id = "cantidad-" + totalDatos;
                btnCantidad.name = "cantidad-" + totalDatos;
                btnCantidad.placeholder = "Cantidad";
                btnCantidad.min = 0;
                btnCantidad.type = "number";
                btnCantidad.className = "w-auto p-2 border rounded text-gray-700 font-bold rounded";
                cuadro.appendChild(btnCantidad);

                // Agrega el boton para eliminar el producto
                const btn = document.createElement('input');
                btn.type = "button";
                btn.value = "X";
                btn.onclick = function() {
                    // Elimina el producto
                    document.getElementById('cuadro-' + totalDatos).remove();
                    totalDatos = totalDatos - 1;
                };
                btn.className =
                    "w-auto p-2 border rounded text-gray-700 bg-red-500 hover:bg-red-700 text-white font-bold rounded";
                cuadro.appendChild(btn);

                div.appendChild(cuadro);
            }
        </script>

    </div>
@endsection
