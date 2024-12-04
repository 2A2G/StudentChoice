<div style="display: flex; justify-content: center; align-items: flex-start;">
    <x-notificacion />
    <!-- Contenedor para el gráfico -->
    <div wire:ignore>
        <div style="width: 300px;">
            <canvas id="acquisitions"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('grafico', function({
            data
        }) {
            console.log('Evento recibido:', data);

            if (data && data.length > 0) {
                const nombres = data.map(item => item.nombre);
                const votos = data.map(item => item.cantidad_votos);

                function getRandomColor() {
                    const r = Math.floor(Math.random() * 256);
                    const g = Math.floor(Math.random() * 256);
                    const b = Math.floor(Math.random() * 256);
                    return `rgba(${r}, ${g}, ${b}, 0.6)`;
                }

                const colors = data.map((_, index) => getRandomColor());
                const borderColors = colors.map(color => color.replace('0.6', '1'));

                const votoEnBlancoIndex = nombres.indexOf("Voto en blanco");
                if (votoEnBlancoIndex !== -1) {
                    const votoEnBlancoColor = 'rgba(255, 99, 132, 0.6)';
                    colors[votoEnBlancoIndex] = votoEnBlancoColor;
                    borderColors[votoEnBlancoIndex] = 'rgba(255, 99, 132, 1)';
                }

                const modifiedVotos = votos.map(voto => voto === 0 ? !0 : voto);
                const modifiedNombres = nombres.map((nombre, index) => {
                    if (votos[index] === 0) {
                        return `${nombre}`;
                    }
                    return nombre;
                });

                new Chart(document.getElementById('acquisitions'), {
                    type: 'pie',
                    data: {
                        labels: modifiedNombres,
                        datasets: [{
                            label: 'Cantidad de votos',
                            data: modifiedVotos,
                            backgroundColor: colors,
                            borderColor: borderColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw +
                                            ' votos';
                                    }
                                }
                            },
                            legend: {
                                display: true
                            }
                        }
                    }
                });
            } else {
                console.log('No data available to render the chart.');
            }
        });
    });
</script>
