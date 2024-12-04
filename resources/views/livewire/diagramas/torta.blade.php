<div style="display: flex; justify-content: center; align-items: flex-start;">
    <!-- Contenedor del gráfico -->
    <div class="chart-container" style="height: 400px; width: 400px;">
        <canvas id="myChart"></canvas>
    </div>

    <!-- Contenedor de la lista de leyendas -->
    <div style="margin-left: 20px;">
        <h3>Postulantes</h3>
        <ul id="legendList" style="list-style-type: none; padding: 0;">
            <!-- Las leyendas se llenan dinámicamente con JavaScript -->
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const data = @json($graficaDatos); // Pasamos los datos desde Livewire

        // Colores para los postulantes (añadí más colores por si hay más postulantes)
        const colors = [
            'rgb(255, 99, 132)',
            'rgb(75, 192, 192)',
            'rgb(255, 205, 86)',
            'rgb(201, 203, 207)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
        ];

        // Crear gráfico (torta)
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie', // Gráfico tipo torta
            data: {
                labels: data.map(item => item.nombre), // Nombres de los postulantes
                datasets: [{
                    data: data.map(item => item.cantidad_votos), // Votos de cada postulante
                    backgroundColor: colors.slice(0, data
                    .length), // Colores asignados a cada postulante
                    hoverOffset: 4,
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
                                const postulante = data[tooltipItem.dataIndex];
                                return `${postulante.nombre} - Votos: ${postulante.cantidad_votos}, Blanco: ${postulante.voto_blanco}`;
                            }
                        }
                    }
                }
            }
        });

        // Generar la lista de leyendas (nombres, colores y datos)
        const legendList = document.getElementById('legendList');
        data.forEach((item, index) => {
            const listItem = document.createElement('li');
            listItem.style.display = 'flex';
            listItem.style.alignItems = 'center';
            listItem.style.marginBottom = '5px';

            const colorBox = document.createElement('span');
            colorBox.style.display = 'inline-block';
            colorBox.style.width = '15px';
            colorBox.style.height = '15px';
            colorBox.style.marginRight = '10px';
            colorBox.style.backgroundColor = colors[index];

            const textNode = document.createTextNode(
                `${item.nombre} - Votos: ${item.cantidad_votos} | Blanco: ${item.voto_blanco}`);

            listItem.appendChild(colorBox);
            listItem.appendChild(textNode);
            legendList.appendChild(listItem);
        });
    });
</script>
