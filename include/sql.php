<?php
function sqlRoom(){
    return "SELECT room.no,room.name,room.phone,employee.name AS employee_name,employee.employee_id,employee.surname,employee.room,room.room_id FROM room,employee WHERE room_id=:roomId";
}
function sqlRoomEmp(){
    return "SELECT room.no,room.name,room.phone,employee.name AS employee_name,employee.employee_id,employee.surname,employee.room,room.room_id FROM room,employee WHERE room_id = employee.room AND room_id=:roomId";
}
function sqlRoomAVG(){
    return "SELECT AVG(employee.wage) as avgwage, employee.name AS employee_name,employee.room,room.room_id FROM room,employee WHERE room_id = employee.room AND room_id=:roomId";
}
function sqlEmpl(){
    return "SELECT employee.employee_id, employee.wage,employee.name AS name, employee.surname, employee.room, employee.job, room.phone, room.room_id, room.name AS room_name
FROM employee,room
WHERE employee_id=:employeeid AND room_id = employee.room";
}
function sqlKeyEmpl(){
    $query2  = "SELECT `key`.room AS key_room, `key`.key_id as key_id, `key`.employee AS key_employee, employee.employee_id AS employee_id, room.name AS room_name, room.room_id AS room_id FROM employee,`key`,room WHERE employee_id=:employeeid AND `key`.employee = employee_id AND `key`.room = room_id";
    return $query2;
}
function sqlKeyroom(){
    $query2  = "SELECT `key`.room AS key_room, `key`.key_id as key_id, `key`.employee AS key_employee, employee.employee_id AS employee_id,employee.name AS employee_name,employee.surname, room.name AS room_name, room.room_id AS room_id FROM employee,`key`,room WHERE room_id=:roomId AND `key`.employee = employee_id AND `key`.room = room_id";
    return $query2;
}
function sqlZamestnanci($case){

    switch ($case){
        case "name_asc": return 'SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room ORDER BY employee.surname ASC';
        case "name_desc": return 'SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room ORDER BY employee.surname DESC';
        case "room_asc": return 'SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room ORDER BY room.name ASC';
        case "room_desc": return 'SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room ORDER BY room.name DESC';
        case "phone_asc": return 'SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room ORDER BY room.phone ASC';
        case "phone_desc": return 'SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room ORDER BY room.phone DESC';
        case "job_asc": return 'SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room ORDER BY employee.job ASC';
        case "job_desc": return 'SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room ORDER BY employee.job DESC';
        default: return 'SELECT employee.employee_id, employee.name AS name, employee.surname, employee.room AS room, employee.job AS job, room.phone AS phone, room.room_id AS room_id, room.name AS room_name FROM employee,room WHERE room_id = employee.room';
    }
}
function sqlMistnosti($case){
    switch ($case){
        case "name_asc": return 'SELECT * FROM room ORDER BY room.name ASC';
        case "name_desc": return 'SELECT * FROM room ORDER BY room.name DESC';
        case "phone_asc": return 'SELECT * FROM room ORDER BY room.phone ASC';
        case "phone_asc": return 'SELECT * FROM room ORDER BY room.phone DESC';
        case "number_asc": return 'SELECT * FROM room ORDER BY room.no ASC';
        case "number_desc": return 'SELECT * FROM room ORDER BY room.no DESC';

        default: return 'SELECT * FROM room';
    }
}
?>