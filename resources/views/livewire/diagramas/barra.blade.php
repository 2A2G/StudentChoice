<div style="width: auto; height: auto;">
    <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener los datos desde Livewire
        let cursosEstudiantes = @json($cursosEstudiantes);

        // Extraer datos de hombres y mujeres
        let seriesMasculino = [];
        let seriesFemenino = [];
        let categorias = [];

        cursosEstudiantes.forEach(item => {
            categorias.push(item.nombre_curso);
            seriesMasculino.push(item.cantidadHombres);
            seriesFemenino.push(item.cantidadMujeres);
        });

        // Crear el gráfico
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categorias,
                datasets: [{
                    label: 'Masculino',
                    data: seriesMasculino,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Femenino',
                    data: seriesFemenino,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad de estudiantes'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw +
                                    ' estudiantes';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
