<?php

function get_all_doctors($conn) {
    $sql = "SELECT `doctors`.id, `doctors`.name AS doc_name, `doctors`.email, `doctors`.phone, `doctors`.department, `doctors`.joined_on, `departments`.name AS dep_name FROM doctors LEFT JOIN departments ON `doctors`.department = `departments`.id;";
    $result = $conn->query($sql);
    if ($result) {
        if($result -> num_rows !== 0) {
            return $result;
        } else {
            return false;
        }
    } else {
        return  false;
    }
}

function get_doctor_info($conn, $id) {
    $sql = "SELECT `doctors`.id, `doctors`.name AS doc_name, `doctors`.email, `doctors`.phone, DATE(`doctors`.joined_on) AS joining_date, `departments`.id AS dep_id,`departments`.name AS dep_name FROM doctors LEFT JOIN departments ON `departments`.id = `doctors`.department WHERE `doctors`.id = $id;";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows===0) {
            return false;
        } else {
            return $result->fetch_assoc();
        }
    } else {
        return false;
    }
}

function update_doctor($conn,$name, $email, $contactNumber, $department, $joining,$id) {
    $sql = "UPDATE `doctors` SET `name` = '$name', `email` = '$email', `phone` = '$contactNumber', `department` = '$department', `joined_on` = '$joining' WHERE `doctors`.`id` = $id;";
    $res = $conn->query($sql);
    if ($res) {
        return true;
    } else {
        return false;
    }
}

function delete_doctor($conn, $id)
{
    $sql="DELETE FROM doctors WHERE id = $id";
    $result=$conn->query($sql);
    if ($result) {
        return true;
    } else {
        return false;
    }
}