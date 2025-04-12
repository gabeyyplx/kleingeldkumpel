import Chart from 'chart.js/auto'

const init = () => {
    initializeExpenseChart()
}

const initializeExpenseChart = () => {
    const dashboardPieChart = document.getElementById('expensesPieChart');
    if (dashboardPieChart === null) {
        return
    }
    const labels = JSON.parse(dashboardPieChart.getAttribute('data-labels'));
    if (labels.length === 0) {
        return
    }
    const values = JSON.parse(dashboardPieChart.getAttribute('data-values'));
    if (values.length === 0) {
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

export default { init }

