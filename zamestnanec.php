<?php
require_once ("include/connect.php");
include ("include/sql.php");
$state = "OK";
$employeeid = filter_input(INPUT_GET, "employee_id", FILTER_VALIDATE_INT);

if ($employeeid === null) {
    http_response_code(400); //bad request
    $state = "BadRequest";
    $title = "BadRequest";
} else {

    $query = "SELECT employee.employee_id, employee.wage,employee.name AS name, employee.surname, employee.room, employee.job, room.phone, room.room_id, room.name AS room_name
FROM employee,room
WHERE employee_id=:employeeid AND room_id = employee.room";


    $pdo = DB::connect();
    $stmt = $pdo->prepare(sqlEmpl());
    $stmt2 = $pdo->prepare(sqlKeyEmpl());
    $stmt->execute(["employeeid" => $employeeid]);
    $stmt2->execute(["employeeid" => $employeeid]);

    if ($stmt->rowCount() == 0) {
        http_response_code(404);
        $state = "NotFound";
        $title = "NotFound";
    } else {
        $employee = $stmt->fetch();
        $title = "$employee->surname ".substr($employee->name,0,1).".";
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
    <title>Karta Zamestnance: <?php echo $title;?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<?php
if ($state === "OK") {
    echo "<h1>Karta Osoby: $employee->surname ".substr($employee->name,0,1).".</h1>";
    echo "Jmeno: " . $employee->name . "<br>";
    echo "Prijmeni: " . $employee->surname . "<br>";
    echo "Plat: " . $employee->wage ." Kč"."<br>";
    echo "Pozice: " . $employee->job . "<br>";
    echo "Mistnost: <a href='mistnost.php?room_id={$employee->room_id}'>$employee->room_name</a><br><br>";

    echo "Klíče: "."<br>";
    foreach ($stmt2 as $key) //nebo  while ($row = $stmt->fetch())
    {

        echo "<a href='mistnost.php?room_id={$key->room_id}'>$key->room_name</br>";
    }


}
elseif ($state === "NotFound") {
    echo "<h1>Místnost nenalezena</h1>";
}
elseif ($state === "BadRequest") {
    echo "<h1>Chybný požadavek</h1>";
}

echo "<br><br>"."<a href='zamestnanci.php'>"."zpět na hlavní stranu";
?>
</body>
</html>
