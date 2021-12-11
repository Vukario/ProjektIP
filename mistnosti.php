
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
<body><?php
$pdo = DB::connect();
$stmt = $pdo->query(sqlMistnosti($order));

if ($stmt->rowCount() == 0)
{
    echo "Databáze neobsahuje žádná data";
} else {
    echo "<table class='table table-light'><thead><tr>
        <td>Název <a href='mistnosti.php?order=name_asc'>↓</a> <a href='mistnosti.php?order=name_desc'>↑</a></td>
        <td>Číslo <a href='mistnosti.php?order=number_asc'>↓</a> <a href='mistnosti.php?order=number_desc'>↑</a></td>
        <td>Telefon <a href='mistnosti.php?order=phone_asc'>↓</a> <a href='mistnosti.php?order=phone_desc'>↑</a></td>
        </thead><tbody>";


    echo "<tbody>";
    while ($row = $stmt->fetch()) //nebo foreach ($stmt as $row)
    {
        echo "<tr>";
        echo "<td><a href='mistnost.php?room_id={$row->room_id}'>$row->name</td>";
        echo "<td> $row->no </td>";
        echo "<td>" . ($row->phone ?: "&mdash;") . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";

    echo "</table>";
}


?></body>
</html>
