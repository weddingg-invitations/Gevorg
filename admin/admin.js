// Получить все данные из базы
function getAllData() {
    fetch('../backend/get_data.php')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                console.log('Все данные из БД:', result.data);
                console.log('Количество записей:', result.count);
                
                // Используем данные
                result.data.forEach(item => {
                    console.log('Запись:', item);
                });
                
                // Можно отобразить данные на странице
                displayData(result.data);
            } else {
                console.error('Ошибка:', result.message);
            }
        })
        .catch(error => console.error('Ошибка запроса:', error));
}

// Получить одну запись по ID
function getDataById(id) {
    fetch(`../backend/get_single_data.php?id=${id}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                console.log('Данные записи:', result.data);
                
                // Заполняем форму полученными данными
                fillFormWithData(result.data);
            } else {
                alert('Ошибка: ' + result.message);
            }
        })
        .catch(error => console.error('Ошибка:', error));
}

// Отобразить данные на странице
function displayData(data) {
    const container = document.getElementById('data-container');
    if (!container) return;
    
    container.innerHTML = '<h3>Данные из базы:</h3>';
    
    data.forEach(item => {
        container.innerHTML += `
            <div class="record">
                <p><strong>ID:</strong> ${item.id}</p>
                <p><strong>Имя:</strong> ${item.name}</p>
                <p><strong>Гостей:</strong> ${item.guestsCount}</p>
                <p><strong>Выбрано:</strong> ${item.selectedOption}</p>
                <p><strong>Дата:</strong> ${item.createdAt}</p>
                <button onclick="getDataById(${item.id})">Загрузить в форму</button>
                <hr>
            </div>
        `;
    });
}

// Заполнить форму данными
function fillFormWithData(data) {
    // Заполняем текстовые поля
    const nameField = document.querySelector('input.getinputval_name');
    const guestsField = document.querySelector('input.getinputval_guestsCount');
    
    if (nameField) nameField.value = data.name;
    if (guestsField) guestsField.value = data.guestsCount;
    
    // Отмечаем радио кнопку
    if (data.allRadios && Array.isArray(data.allRadios)) {
        data.allRadios.forEach(radio => {
            if (radio.checked) {
                const radioToCheck = document.querySelector(`input.radiobuttones[value="${radio.value}"]`);
                if (radioToCheck) radioToCheck.checked = true;
            }
        });
    }
    
    alert('Данные загружены в форму!');
}

// Вызвать при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    // Создаем контейнер для данных, если его нет
    if (!document.getElementById('data-container')) {
        const container = document.createElement('div');
        container.id = 'data-container';
        document.body.appendChild(container);
    }
    
    // Добавляем кнопку для загрузки данных
    const btn = document.createElement('button');
    btn.textContent = 'Показать все данные из БД';
    btn.onclick = getAllData;
    document.body.insertBefore(btn, document.getElementById('data-container'));
});