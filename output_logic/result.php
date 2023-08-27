<?
if (isset($_SESSION['start_date']) && isset($_SESSION['end_date'])) {

    echo '<p>Звіт за період з ' . $_SESSION['start_date'] . ' по ' . $_SESSION['end_date'] . '</p>';
    unset($_SESSION['start_date']);
    unset($_SESSION['end_date']);

}

if(isset($_SESSION['rentsByCar'])){
echo '<table border="1">
<tr>
<th>№</th>
<th>Car ID</th>
<th>Кількість днів, коли авто - зайняте</th>
<th>Кількість днів,коли авто - вільне</th>
<th>Кількість днів у місяці</th>
</tr>';

$counter = 1;
foreach ($_SESSION['rentsByCar'] as $_SESSION['carId'] => $numDays) {

    /* Екранизировал от html injection но не уверен что это нужно,
    хотя там есть столбцы где данные от пользователя и если они узнают что оно выводиться в Admin Panel,
    то могут попробовать что-то ввести, например злой JS скрипт*/
    echo '<tr>';
    echo '<td>' . htmlentities($counter)  . '</td>';
    echo '<td>' . htmlentities($_SESSION['carId']) . '</td>';
    echo '<td>' . htmlentities($numDays) . '</td>';
    $carFreeDays = $_SESSION['daysInMonth'] - $numDays;
    echo '<td>' . htmlentities($carFreeDays) . '</td>';
    echo '<td>' . htmlentities($_SESSION['daysInMonth'])  . '</td>';
    echo '</tr>';
    $counter++;
}
echo '</table>';
unset($_SESSION['rentsByCar']);
unset($_SESSION['carId']);
unset($_SESSION['daysInMonth']);
}
?>