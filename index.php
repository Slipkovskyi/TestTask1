<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Filter for car</title>
</head>
<body>
</form>
    <div class="filters">

        <form action="main_logic.php" method="post">
            <div class="filterinput">
            <h1>Фільтри</h1>
            <div class="year">
            <label for="year">Рік</label>
            <input maxlength="4" type="number" name="year" id="year" placeholder="Приклад:2023">
            </div>

            <div class="month">
            <label for="color">Місяць</label>
            <input type="number" name="month" id="month" placeholder="Приклад:1">
            </div>
            <button id="button" type="submit">Відправити дані</button>
            <?php require_once 'output_logic/error.php'; ?>
            </div>
        </form>
    </div>

    <div class="results">
    <h1>Результати</h1>
        <div class="tablediv"><?php require_once 'output_logic/result.php'; ?></div>
    </div>

</body>
</html>