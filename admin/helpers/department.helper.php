<?php
// Get a list of Departments
function get_all_department($conn)
{
    $sql = "SELECT * FROM `departments`;";
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