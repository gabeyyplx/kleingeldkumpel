import './bootstrap';
import Chart from 'chart.js/auto'


document.addEventListener('DOMContentLoaded', () => {
    initializeExpenseChart();
})

const initializeExpenseChart = () => {
    const dashboardPieChart = document.getElementById('expensesPieChart');
    if (dashboardPieChart) {
        const labels = JSON.parse(dashboardPieChart.getAttribute('data-labels'));
        if(labels.length === 0){
            return
        }
        const values = JSON.parse(dashboardPieChart.getAttribute('data-values'));
        if(values.length === 0) {
            return;
        }
        
        new Chart(dashboardPieChart, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                }]
            }
        });
    }
}

