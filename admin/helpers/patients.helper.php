<?php

function get_all_patients($conn)
{
    $sql = "SELECT `patient_details`.id, `patient_details`.firstname, `patient_details`.lastname, `patient_details`.email, `patient_details`.phone, `patient_details`.gender, `patient_details`.dob, `doctors`.name AS doc_name FROM `patient_details` LEFT JOIN `doctors` ON `doctors`.id=`patient_details`.`doctorId`;";
    $result = $conn->query($sql);
    if ($result) {
        if ($result->num_rows===0) {
            return false;
        } else {
            return $result;
        }
    } else {
        return false;
    }
}

function update_patient($conn, $firstname, $lastname, $email, $dob, $gender, $contactNumber, $id) {
    $sql = "UPDATE `patient_details` SET `firstname` = '" . $firstname . "', `lastname` = '" . $lastname . "', `dob` = '" . $dob . "', `gender` = '" . $gender . "', `phone` = '" . $contactNumber . "', `email` = '" . $email . "' WHERE `patient_details`.`id` = $id";
    $res = $conn->query($sql);
    if ($res) {
        return true;
    } else {
        return false;
    }
}

function delete_patient($conn, $id) {
    $sql="DELETE FROM patient_details WHERE id = $id";
    $result=$conn->query($sql);
    if ($result) {
        return true;
    } else {
        return false;
    }
}