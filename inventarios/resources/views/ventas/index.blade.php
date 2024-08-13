@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Ventas</h1>
        <div class="mb-4">
            <button onclick="document.getElementById('modal').classList.remove('hidden')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar Venta</button>
        </div>

        <style>
            .details {
                display: none;
            }
        </style>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif

        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">N°</th>
                    <th class="py-2 px-4 border-b">Categoría</th>
                    <th class="py-2 px-4 border-b">Cliente</th>
                    <th class="py-2 px-4 border-b">Vendedor</th>
                    <th class="py-2 px-4 border-b">Tipo de pago</th>
                    <th class="py-2 px-4 border-b">Fecha de Venta</th>
                    <th class="py-2 px-4 border-b">Subtotal</th>
                    <th class="py-2 px-4 border-b">IVA</th>
                    <th class="py-2 px-4 border-b">Total</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    @php
                        $ventaproducto = ('App\Models\VentaProducto')::where('id_venta', $venta->id_venta)->get();
                        $total = 0;
                    @endphp
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4 border-b">{{ $venta->categoria->nombre_categoria }}</td>
                        <td class="py-2 px-4 border-b">{{ $venta->cliente->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $venta->vendedor->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $venta->pago->tipo }}</td>
                        <td class="py-2 px-4 border-b">{{ $venta->fecha_venta }}</td>
                        <td class="py-2 px-4 border-b">{{ $venta->subtotal }}</td>
                        <td class="py-2 px-4 border-b">{{ $venta->iva }}</td>
                        <td class="py-2 px-4 border-b">{{ $venta->total }}</td>
                        <th class="py-2 px-4 border-b">
                            <button onclick="mostrarDetalles('detalles_{{ $venta->id_venta }}')"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">
                                Ver
                            </button>
                            <a href="{{ route('ventas.edit', $venta->id_venta) }}"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded editVenta">Editar</a>
                            <form id="button-borrar-{{ $venta->id_venta }}" method="POST" action="{{ route('ventas.destroy', $venta->id_venta) }}"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmar({{ $venta->id_venta }})"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Eliminar</button>
                            </form>
                        </th>
                    </tr>
                    <tr id="detalles_{{ $venta->id_venta }}" class="details">
                        <td colspan="9">
                            <table class="min-w-full bg-white border">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 border-b">Producto</th>
                                        <th class="py-2 px-4 border-b">Cantidad</th>
                                        <th class="py-2 px-4 border-b">Precio</th>
                                        <th class="py-2 px-4 border-b">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventaproducto as $item)
                                        <tr>
                                            <td class="py-2 px-4 border-b">
                                                <center>{{ $item->producto->nombre }}</center>
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                <center>{{ $item->cantidad }}</center>
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                <center>$ {{ $item->precio_venta }}</center>
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                <center>$ {{ $item->precio_venta * $item->cantidad * 1.16 }}</center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div id="modal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center overflow-auto hidden">
            <div class="bg-white p-4 rounded-lg shadow-lg max-h-full max-w-md w-full">
                <h2 class="text-xl font-bold mb-4" id="modalTitle">Agregar Venta</h2>
                <form id="ventaForm" method="POST" action="{{ route('ventas.store') }}">
                    @csrf
                    <input type="hidden" name="id_venta" id="id_venta">
                    <div class="mb-4">
                        <label class="block text-gray-700">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="w-full p-2 border rounded" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Producto</label>
                        <select name="producto_id" id="producto_id" class="w-full p-2 border rounded" required>
                            <option value="">Seleccione un producto</option>
                        </select>
                        <input id="productos" name="productos" value="" type="hidden">
                        <input id="cantidades" name="cantidades" value="" type="hidden">
                        <input type="button" id="btn-add" value="Add"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-6" />
                    </div>
                    <div id="dataproducto">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Cliente</label>
                        <select name="cliente_id" id="cliente_id" class="w-full p-2 border rounded" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id_cliente }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Vendedor</label>
                        <select name="vendedor_id" id="vendedor_id" class="w-full p-2 border rounded" required>
                            <option value="">Seleccione un vendedor</option>
                            @foreach ($vendedores as $persona)
                                <option value="{{ $persona->id }}">{{ $persona->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Tipo de pago</label>
                        <select name="pago_id" id="pago_id" class="w-full p-2 border rounded" required>
                            <option value="">Seleccione un tipo de pago</option>
                            @foreach ($pagos as $pago)
                                <option value="{{ $pago->id }}">{{ $pago->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Fecha de Venta</label>
                        <input type="date" name="fecha_venta" id="fecha_venta" class="w-full p-2 border rounded"
                            required>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="document.getElementById('modal').classList.add('hidden')"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancelar</button>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmar(id) {
            Swal.fire({
                title: 'Confirmacion!',
                text: '¿Estas seguro de eliminar la venta?',
                icon: 'warning',
                confirmButtonText: 'Aceptar',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('button-borrar-' + id).submit()
                }
            });
        }

        // Variables
        let salida = [];
        let cantidades = [];
        let productos = new Map();

        // Agrega los productos a la lista
        @foreach ($productos as $producto)
            productos.set('{{ $producto->categoria->nombre_categoria }}-{{ $producto->id_producto }}', {
                id: '{{ $producto->id_producto }}',
                nombre: '{{ $producto->nombre }}'
            });
        @endforeach

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.editVenta').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id_venta = this.getAttribute('data-id');
                    fetch(`{{ url('ventas') }}/${id_venta}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modalTitle').innerText = 'Editar Venta';
                            document.getElementById('id_venta').value = data.venta.id_venta;
                            document.getElementById('producto_id').value = data.venta
                                .producto_id;
                            document.getElementById('categoria_id').value = data.venta
                                .categoria_id;
                            document.getElementById('cliente_id').value = data.venta.cliente_id;
                            document.getElementById('fecha_venta').value = data.venta
                                .fecha_venta;
                            document.getElementById('modal').classList.remove('hidden');
                        });
                });
            });
        });

        // Agrega un producto a la lista
        document.getElementById('btn-add').addEventListener('click', function() {
            let producto = document.getElementById('producto_id').value;
            let nameproducto = document.getElementById('producto_id').options[document.getElementById('producto_id')
                .selectedIndex].text;
            var productos = document.getElementById('productos').value;
            let div = document.getElementById('dataproducto');

            // Verifica si el producto ya fue agregado
            if (!salida.includes(producto) && producto != "") {
                salida.push(producto);

                const cuadro = document.createElement('div');
                cuadro.className = "mb-4 flex items-center space-x-4";

                // Agrega el producto al input
                const label = document.createElement('p');
                label.id = "${producto}_label";
                label.textContent = nameproducto;
                label.className = "w-full p-2 border rounded text-gray-700";
                cuadro.appendChild(label);

                // Agrega la cantidad del producto
                const btnCantidad = document.createElement('input');
                btnCantidad.placeholder = "Cantidad";
                btnCantidad.min = 0;
                btnCantidad.id = producto;
                btnCantidad.onchange = function() {
                    // Agrega la cantidad al input
                    cantidades[salida.indexOf(producto)] = this
                    .value; // Guarda la cantidad en el array dependiendo de donde esta el producto
                    document.getElementById('cantidades').value = cantidades;
                };
                btnCantidad.type = "number";
                btnCantidad.className = "w-auto p-2 border rounded text-gray-700 font-bold rounded";
                cuadro.appendChild(btnCantidad);

                // Agrega el boton para eliminar el producto
                const btn = document.createElement('input');
                btn.type = "button";
                btn.onclick = function() {
                    // Elimina el producto del input
                    document.getElementById('productos').value = document.getElementById('productos').value
                        .replace(producto + ',', '');
                    salida.splice(salida.indexOf(producto), 1);
                    cuadro.remove();
                };
                btn.value = "X";
                btn.className =
                    "w-auto p-2 border rounded text-gray-700 bg-red-500 hover:bg-red-700 text-white font-bold rounded";
                cuadro.appendChild(btn);

                div.appendChild(cuadro);

                // Agrega el producto al input
                document.getElementById('productos').value = salida;
            }
        });

        // Actualiza los productos al cambiar la categoría
        document.getElementById('categoria_id').addEventListener('change', function() {

            document.getElementById('producto_id').innerHTML = '<option value="">Seleccione un producto</option>';
            var categoria = this.options[this.selectedIndex].text;

            // Agrega los productos de la categoría seleccionada
            for (let [key, value] of productos) {
                if (key.includes(categoria)) {
                    var producto = document.createElement('option');
                    producto.value = value.id;
                    producto.text = value.nombre;

                    if (key.startsWith(categoria)) {
                        document.getElementById('producto_id').appendChild(producto);
                    }
                }
            }

        });

        // Muestra los detalles de la cotización
        function mostrarDetalles(id) {
            var detalles = document.getElementById(id);
            if (detalles.style.display === "none") {
                detalles.style.display = "table-row";
            } else {
                detalles.style.display = "none";
            }
        }
    </script>
@endsection
