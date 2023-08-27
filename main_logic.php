<?php
// Стартую сессию для подальшей передачи данных в неё
session_start();

// Конекчу классы: Для роботы з месяцем его днями и валидацию для инпутов на стороне сервера
require_once 'oop_things\month_transformer.php';
require_once 'oop_things\validator.php';

// Собираю данные из формы

$year = $_POST['year'];
$month = $_POST['month'];

// Делаю валидацию

$Validator = new YearMonthValidator($year, $month);
if (!$Validator->validate()) {
    $_SESSION['error'] = 'Неправильний формат дати(рік повинен бути числом і не більше 4 символів, а місяць від 1 до 12 і також число)';
    header('Location: index.php');
    exit;
}


// Создаю объект месяца

$monthObject = new Month($year, $month);
$daysInMonth = date("t", strtotime($monthObject->start_date));

// Решил сразу данные отправить для index.php, что бы не запутаться

$_SESSION['start_date'] = $monthObject->start_date;
$_SESSION['end_date'] = $monthObject->end_date;

// Подключаюсь к ДБ и делаю запросы
require_once 'db/db_pdo.php';
require_once 'db/db_query.php';
require_once 'db/db_query2.php';

//$bookings - это где храняться данные з БД, что я вынял первым запросом
//$bookings1 - это где храняться данные з БД, что я вынял вторым запросом

$data = array_merge($bookings, $bookings1);

// Тут я делаю так что бы дата начала и конца аренды не выходила за пределы месяца

$monthObject->start_date = strtotime($monthObject->start_date);
$monthObject->end_date = strtotime($monthObject->end_date);

foreach ($data as &$rent) {
    $rentStartDate = strtotime($rent['start_date']);
    $rentEndDate = strtotime($rent['end_date']);

    // Заміна start_date, якщо він раніше $monthObject->start_date
    if ($rentStartDate < $monthObject->start_date) {
        $rent['start_date'] = date('Y-m-d 00:00:01', $monthObject->start_date);
    }

    // Заміна end_date, якщо він пізніше $monthObject->end_date
    if ($rentEndDate > $monthObject->end_date) {
        $rent['end_date'] = date('Y-m-d 23:59:59', $monthObject->end_date);
    }
}


// Цикл проходится по всем данным и считает количество дней, когда машина была арендована более 4 часов, я решил играть от обратного

$rentsByCar = [];

foreach ($data as $rent) {
    $carId = $rent['car_id'];
    $startDate = strtotime($rent['start_date']);
    $endDate = strtotime($rent['end_date']);
    $days = ceil(($endDate - $startDate) / (60 * 60 * 24)) + 1;

    $daysWithMoreThan4Hours = 0;

    for ($i = 0; $i < $days; $i++) {
        $currentDate = strtotime("+{$i} days", $startDate);
        $startTime = max(strtotime(date('Y-m-d 09:00:00', $currentDate)), $startDate);
        $endTime = min(strtotime(date('Y-m-d 21:00:00', $currentDate)), $endDate);

        $timeDiff = $endTime - $startTime;
        if ($timeDiff > 4 * 60 * 60) {
            $daysWithMoreThan4Hours++;
        }
    }

    if ($daysWithMoreThan4Hours > 0) {
        if (isset($rentsByCar[$carId])) {
            $rentsByCar[$carId] += $daysWithMoreThan4Hours;
        } else {
            $rentsByCar[$carId] = $daysWithMoreThan4Hours;
        }
    }
}

// Переношу данные в сессию и редирект на главную, там уже всё выведу

$_SESSION['rentsByCar'] = $rentsByCar;
$_SESSION['daysInMonth'] = $daysInMonth;
$_SESSION['carId'] = $carId;
header('Location: index.php');

?>
