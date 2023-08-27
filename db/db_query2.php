<?php
$sql1 = "SELECT `car_id`, `start_date`, `end_date` FROM rc_bookings WHERE start_date < :stard_date AND end_date BETWEEN :start_date AND :end_date AND `status` = 1";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute(['start_date' => $monthObject->start_date, 'end_date' => $monthObject->end_date, 'stard_date' => $monthObject->start_date]);
$bookings1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
?>