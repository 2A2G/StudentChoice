<div style="display: flex; justify-content: center; align-items: flex-start;">
    <div wire:ignore>
        <div style="width: 800px;">
            <canvas id="acquisitions"></canvas>
        </div>
    </div>

    <div style="margin-left: 20px;">
        <h3>Postulantes</h3>
        <ul id="legendList" style="list-style-type: none; padding: 0;">
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('grafico', function({
            data
        }) {
            console.log('Evento recibido:', data);

            if (!Array.isArray(data) || data.length === 0) {
                console.error('Los datos no son válidos:', data);
                return;
            }

            const ctx = document.getElementById('acquisitions').getContext('2d');

            new Chart(ctx, {
                type: 'pie',
                radius: [0, '30%'],
                center: ['75%', '75%'],
                data: {
                    labels: data.map(item => item.nombre),
                    datasets: [{
                        label: 'Cantidad de Votos',
                        data: data.map(item => item.cantidad_votos),
                        backgroundColor: ['rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });

            const legendList = document.getElementById('legendList');
            legendList.innerHTML = '';
            data.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.nombre}: ${item.cantidad_votos} votos`;
                legendList.appendChild(li);
            });
        });
    });
</script>
