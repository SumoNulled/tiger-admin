<?php
$id = $_POST['id'];
echo $id;
Mysql_Update("UPDATE cadets SET username = 'green' WHERE id = $id")
?>
