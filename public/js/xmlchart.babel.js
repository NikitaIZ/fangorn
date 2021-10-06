function TotalRoomsChart(id, xml) {
    var ctx = document.getElementById(id).getContext('2d');
    var id = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total', 'minus'],
            datasets: [{
                label: 'Dia',
                data: [xml[0]['Dia'], xml[2]['Dia']],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            },{
                label: 'Mes',
                data: [xml[0]['Mes'], xml[2]['Mes']],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            },{
                label: 'Año',
                data: [xml[0]['Año'], xml[2]['Año']],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function RoomsPieChart(id, data) {
    var ctx = document.getElementById(id).getContext('2d');
    var id = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Total', 'Rooms Occupied', 'Available Rooms'],
            datasets: [{
                label: '$',
                data: [data[0], data[1], data[2]],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderColor: [
                    'rgba(253, 254, 254)',
                    'rgba(253, 254, 254)',
                    'rgba(253, 254, 254)',
                    'rgba(253, 254, 254)',
                    'rgba(253, 254, 254)',
                    'rgba(253, 254, 254)'
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
                title: {
                    display: true,
                    text: 'Día'
                }
            }
        }
    });
}
