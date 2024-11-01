<div wire:ignore id="chart" style="width: 100%; height: auto;"></div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

        var options = {
            series: [{
                name: 'Masculino',
                data: seriesMasculino
            }, {
                name: 'Femenino',
                data: seriesFemenino
            }],
            chart: {
                type: 'bar',
                height: 350,
                width: '100%',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: categorias,
            },
            yaxis: {
                title: {
                    text: 'Cantidad de estudiantes'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return " " + val + " estudiantes";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
</script>
