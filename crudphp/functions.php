<?php
function validateNumber($value) {
    return is_numeric($value) && (float)$value >= 0;
}
 
function checkAvailability($stock) {
    return $stock > 0 ? 'Yes' : 'No';
}
 
function redirectTo($page) {
    header("Location: $page");
    exit();
}
?>
 