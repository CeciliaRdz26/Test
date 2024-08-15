@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Dashboard - Estadisticas de compras</h1>
        <div class="mb-4">
            
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @endif

        <div>
            <canvas id="grafico_compras" height="80px"></canvas>
        </div>
        <br>
        <h1 class="text-2xl font-bold mb-4">Dashboard - Estadisticas de ventas</h1>
        
        <div>
            <canvas id="grafico_ventas" height="80px"></canvas>
        </div>

        <script>
            fetch('/report/grafica/compras')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('grafico_compras').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'doughnut', // Tipo de gráfico 'doughnut'
                        data: {
                            labels: data.map(item => 'Producto ' + item.nombre), // Etiquetas (productos)
                            datasets: [{
                                label: 'Productos mas comprados',
                                data: data.map(item => item.total_ingresos), // Datos de mas comprados
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.2)', // Verde azulado
                                    'rgba(255, 159, 64, 0.2)', // Naranja
                                    'rgba(153, 102, 255, 0.2)', // Morado
                                    'rgba(255, 205, 86, 0.2)', // Amarillo
                                    'rgba(201, 203, 207, 0.2)', // Gris
                                    'rgba(54, 162, 235, 0.2)', // Azul
                                    'rgba(231, 76, 60, 0.2)', // Rojo
                                    'rgba(46, 204, 113, 0.2)', // Verde
                                    'rgba(241, 196, 15, 0.2)', // Amarillo brillante
                                    'rgba(52, 73, 94, 0.2)' // Azul oscuro
                                ],
                                borderColor: [
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 205, 86, 1)',
                                    'rgba(201, 203, 207, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(231, 76, 60, 1)',
                                    'rgba(46, 204, 113, 1)',
                                    'rgba(241, 196, 15, 1)',
                                    'rgba(52, 73, 94, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return 'Ingresos: ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                });

                fetch('/report/grafica/ventas')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('grafico_ventas').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico 'bar' para una gráfica de barras
            data: {
                labels: data.map(item => item.nombre), // Etiquetas (productos) usando el nombre del producto
                datasets: [{
                    label: 'Ventas Totales por Producto',
                    data: data.map(item => item.total_ingresos), // Datos de ingresos
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)', // Verde azulado
                        'rgba(255, 159, 64, 0.2)', // Naranja
                        'rgba(153, 102, 255, 0.2)', // Morado
                        'rgba(255, 205, 86, 0.2)', // Amarillo
                        'rgba(201, 203, 207, 0.2)', // Gris
                        'rgba(54, 162, 235, 0.2)', // Azul
                        'rgba(231, 76, 60, 0.2)', // Rojo
                        'rgba(46, 204, 113, 0.2)', // Verde
                        'rgba(241, 196, 15, 0.2)', // Amarillo brillante
                        'rgba(52, 73, 94, 0.2)' // Azul oscuro
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(231, 76, 60, 1)',
                        'rgba(46, 204, 113, 1)',
                        'rgba(241, 196, 15, 1)',
                        'rgba(52, 73, 94, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Ingresos: ' + tooltipItem.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true // Asegura que el eje Y comience en 0
                    }
                }
            }
        });
    });



        </script>

    </div>
@endsection
