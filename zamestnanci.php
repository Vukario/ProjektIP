<?php

require_once ("include/connect.php");
include ("include/sql.php");
$order = filter_input(INPUT_GET, 'order');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
$pdo = DB::connect();

//$stmt = $pdo->query('SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room');
$stmt = $pdo->query(sqlZamestnanci($order));
if ($stmt->rowCount() == 0)
{
    echo "Databáze neobsahuje žádná data";
} else {
    echo "<table class='table table-light'><thead><tr>
        <td>Jméno<a href='zamestnanci.php?order=name_asc'>↓</a> <a href='zamestnanci.php?order=name_desc'>↑</a></td>
        <td>Místnost<a href='zamestnanci.php?order=room_asc'>↓</a> <a href='zamestnanci.php?order=room_desc'>↑</a></td>
        <td>Telefon<a href='zamestnanci.php?order=phone_asc'>↓</a> <a href='zamestnanci.php?order=phone_desc'>↑</a></td>
        <td>Pozice<a href='zamestnanci.php?order=job_asc'>↓</a> <a href='zamestnanci.php?order=job_desc'>↑</a></td>
        </tr></thead><tbody>";

    foreach ($stmt as $row) //nebo  while ($row = $stmt->fetch())
    {
        echo "<tr>";
        echo "<td><a href='zamestnanec.php?employee_id={$row->employee_id}'>$row->surname,$row->name</td>";
        echo "<td> $row->room_name </td>";
        echo "<td> $row->phone </td>";
        echo "<td> $row->job</td>";
        echo "</tr>";
    }

    echo "</tbody>";

    echo "</table>";
}


?></body>
</html>
