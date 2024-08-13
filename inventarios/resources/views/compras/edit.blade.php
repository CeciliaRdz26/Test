@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Editar compra</h1>
        <form method="POST" action="{{ route('compras.update', $compras->id_compra) }}">
            @csrf
            @method('PUT')
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Proveedor</label>
                    <select name="id_proveedor" id="id_proveedor" class="w-full p-2 border rounded">
                        @foreach ($proveedor as $item)
                            <option value="{{ $item->id }}"
                                {{ $compras->id_proveedor == $item->id ? 'selected' : '' }}>
                                {{ $item->nombre_contacto }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Fecha de compra</label>
                    <input type="date" name="fecha_compra" value="{{ $compras->fecha_compra }}"
                        class="w-full p-2 border rounded" required>
                </div>
            </div>

            <div class="mb-4 grid grid-cols-5 gap-5">
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
                        $comprasproducto = ('App\Models\CompraProducto')
                            ::where('id_compra', $compras->id_compra)
                            ->get();
                    @endphp
                    <input type="hidden" name="total_campos" id="total_campos" value="">
                    <tbody>
                        <!-- Muestra los productos de la cotización -->
                        @foreach ($comprasproducto as $item)
                            <tr>
                                <input type="hidden" name="producto-id-{{ $item->id }}"
                                    id="producto-id-{{ $item->id }}">
                                <td class="py-2 px-4 border-b">
                                    <center>{{ $item->producto->nombre }}</center>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <center>
                                        <input type="number" min="0" id="cantidad-id-{{ $item->id }}"
                                            name="cantidad-id-{{ $item->id }}" value="{{ $item->cantidad }}"
                                            class="w-16 p-2 border rounded" required>
                                    </center>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <center>$ {{ $item->precio_venta }}</center>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <center>$ <b
                                            id="total-{{ $item->id }}">{{ $item->precio_venta * $item->cantidad }}</b>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                
            </div>
            <!-- Agrega los productos nuevos -->
            <div id="dataproducto"></div>

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
            @foreach ($comprasproducto as $item)
                // Agrega el producto a la lista de productos tomados
                productosTomados.push('{{ $item->id_producto }}');
            @endforeach

            // Calcula el total de la cotización
            @foreach ($comprasproducto as $item)
                // Calcula el total
                document.getElementById('cantidad-id-{{ $item->id }}').addEventListener('input', function() {
                    var cantidad = document.getElementById('cantidad-id-{{ $item->id }}').value;
                    var precio = {{ $item->precio_venta }};
                    var total = cantidad * precio;
                    document.getElementById('total-{{ $item->id }}').innerHTML = total;
                });
            @endforeach

            function addProducto() {
                // Incrementa el total de datos
                totalDatos = totalDatos + 1;
                document.getElementById('total_campos').value = totalDatos;
                
                // Crea el cuadro de productos
                let div = document.getElementById('dataproducto');
                const cuadro = document.createElement('div');
                cuadro.className = "mb-4 flex items-center space-x-4";
                cuadro.id = "cuadro-"+totalDatos;

                // Agrega el select de productos
                const optionsProducto = document.createElement('select');
                optionsProducto.id = "producto-"+totalDatos;
                optionsProducto.name = "producto-"+totalDatos;
                optionsProducto.options[0] = new Option("Seleccione un producto", "");
                // Agrega los productos
                @foreach ($productos as $producto) 
                    optionsProducto.options[optionsProducto.options.length] = new Option("{{ $producto->nombre }}", "{{ $producto->id_producto }}");
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
                btnCantidad.id = "cantidad-"+totalDatos;
                btnCantidad.name = "cantidad-"+totalDatos;
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
                    document.getElementById('cuadro-'+totalDatos).remove();
                };
                btn.className = "w-auto p-2 border rounded text-gray-700 bg-red-500 hover:bg-red-700 text-white font-bold rounded";
                cuadro.appendChild(btn);
                
                div.appendChild(cuadro);
            }
        </script>

    </div>
@endsection
