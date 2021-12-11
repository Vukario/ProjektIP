<?php
require_once ("include/connect.php");
include ("include/sql.php");
$roomId = filter_input(INPUT_GET, "room_id", FILTER_VALIDATE_INT);

if ($roomId === null) {
    http_response_code(400); //bad request
    $state = "BadRequest";
    $title = "BadRequest";
} else {
    $pdo = DB::connect();
    $stmt = $pdo->prepare(sqlRoomEmp());
    $stmt4 = $pdo->prepare(sqlRoom());
    $stmt2 = $pdo->prepare(sqlKeyroom());
    $stmt3 = $pdo->prepare(sqlRoomAVG());
    $stmt->execute(["roomId" => $roomId]);
    $stmt2->execute(["roomId" => $roomId]);
    $stmt3->execute(["roomId"=>$roomId]);
    $stmt4->execute(["roomId"=>$roomId]);
    $AVG = $stmt3->fetch();
    if ($stmt4->rowCount() == 0) {
        http_response_code(404);
        $state = "NotFound";
        $title = "NotFound";
    } else {
        $room = $stmt4->fetch();
        $state = "OK";
        $title = $room->no;
    }

}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Karta místnosti č.<?php echo $title;?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
if ($state === "OK") {
    echo "<h1>Místnost č." . $room->no . "</h1>";
    echo "Číslo: " . $room->no . "<br>";
    echo "Název: " . $room->name . "<br>";
    if ($AVG->avgwage==0){
        echo "Průměrná mzda: -<br>";
    }
    else{
        echo "Průměrná mzda: " . round($AVG->avgwage) . " Kč<br>";
    }
    echo "Lidé: ";
    foreach ($stmt as $empl){
        echo "<a href='zamestnanec.php?employee_id={$empl->employee_id}'>$empl->surname ".substr($empl->employee_name,0,1).".</a></br>";
    }
    echo "<br>Tel: " . $room->phone. "<br><br>";
    echo "Klíče: "."<br>";
    foreach ($stmt2 as $key) //nebo  while ($row = $stmt->fetch())
    {

        echo "<a href='zamestnanec.php?employee_id={$key->employee_id}'>$key->surname ".substr($key->employee_name,0,1).".</br>";
    }
}
elseif ($state === "NotFound") {
    echo "<h1>Místnost nenalezena</h1>";
}
elseif ($state === "BadRequest") {
    echo "<h1>Chybný požadavek</h1>";
}

echo "<br><br>"."<a href='mistnosti.php'>"."zpět na hlavní stranu"
?>
</body>
</html>
