
function renderTaskChart(completedCount, pendingCount) {
    const ctx = document.getElementById('taskChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending'],
            datasets: [{
                label: 'Task Status',
                data: [completedCount, pendingCount],
                backgroundColor: ['#4ade80', '#facc15'], // soft green, yellow
                borderColor: ['#22c55e', '#eab308'], // more subtle
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Task Completion Overview' }
            }
        }
    });
}
