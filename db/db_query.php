<?php
$sql = "SELECT `car_id`, `start_date`, `end_date` FROM rc_bookings WHERE start_date BETWEEN :start_date AND :end_date AND `status` = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(['start_date' => $monthObject->start_date, 'end_date' => $monthObject->end_date]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
