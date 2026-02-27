document.querySelector('#send_data_btn').addEventListener('click', function (e) {
    e.preventDefault();

    // Получаем значения по классам
    const name = document.querySelector('input.getinputval_name')?.value || '';
    const guests = document.querySelector('input.getinputval_guestsCount')?.value || '';
    const selectedRadio = document.querySelector('input.radiobuttones:checked')?.value || 'не выбрано';

    // Все радио кнопки
    const allRadios = Array.from(document.querySelectorAll('input.radiobuttones')).map(r => ({
        value: r.value,
        checked: r.checked
    }));

    // Результат
    const result = {
        name: name,
        guestsCount: guests,
        selectedOption: selectedRadio,
        allRadios: allRadios
    };

    console.log('Данные формы:', result);

    // Отправляем данные на PHP
    // fetch('../backend/save_form.php', {  // Укажите правильный путь к вашему PHP файлу
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //     },
    //     body: JSON.stringify(result)
    // })
    //     .then(response => response.json())
    //     .then(data => {
    //         console.log('Ответ сервера:', data);
    //     })
    //     .catch(error => {
    //         console.error('Ошибка:', error);
    //         alert('❌ Ошибка при отправке данных');
    //     });
});

