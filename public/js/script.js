function refreshOrders() {
    const loading = document.getElementById('loading');
    const ordersTable = document.getElementById('ordersTable').getElementsByTagName('tbody')[0];
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    
    loading.style.display = 'block';
    
    fetch(`/?dateFrom=${dateFrom}&dateTo=${dateTo}`)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTableBody = doc.querySelector('#ordersTable tbody');
            
            ordersTable.innerHTML = newTableBody.innerHTML;
            loading.style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);
            loading.style.display = 'none';
            alert('Произошла ошибка при загрузке данных');
        });
}

document.getElementById('refreshButton').addEventListener('click', refreshOrders);

document.getElementById('todayButton').addEventListener('click', () => {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('dateFrom').value = today;
    document.getElementById('dateTo').value = today;
});

document.getElementById('yesterdayButton').addEventListener('click', () => {
    const yesterday = new Date(Date.now() - 86400000).toISOString().split('T')[0];
    document.getElementById('dateFrom').value = yesterday;
    document.getElementById('dateTo').value = yesterday;
});

// Устанавливаем сегодняшнюю дату при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('dateFrom').value = today;
    document.getElementById('dateTo').value = today;
});
