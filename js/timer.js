function countdown() {
    // 17 марта 2026 года
    // В JavaScript: март - это месяц 2 (так как январь = 0)
    const birthday = new Date(2026, 2, 18, 0, 0, 0); // 17 марта 2026, 00:00
    
    // Текущая дата и время в Армении (UTC+4)
    const now = new Date();
    const armeniaTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Yerevan' }));
    
    // Разница в миллисекундах
    let diff = birthday - armeniaTime;
    
    // Если день рождения уже прошел
    if (diff < 0) {
        document.getElementById('days').textContent = '00';
        document.getElementById('hours').textContent = '00';
        document.getElementById('minutes').textContent = '00';
        document.getElementById('seconds').textContent = '00';
        return;
    }
    
    // Расчет дней, часов, минут и секунд
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
    
    // Обновление DOM с добавлением ведущего нуля
    document.getElementById('days').textContent = String(days).padStart(2, '0');
    document.getElementById('hours').textContent = String(hours).padStart(2, '0');
    document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
    document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
}

// Запуск таймера
countdown();
setInterval(countdown, 1000);