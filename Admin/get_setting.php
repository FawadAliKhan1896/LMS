<?php
include('../config/db.php');

$settingsQuery = mysqli_query($conn, "SELECT * FROM page_settings LIMIT 1");
$settings = mysqli_fetch_assoc($settingsQuery);
?>
