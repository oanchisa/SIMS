<?php
$hostname = 'localhost';
$username = 'root';
$password = '12345678';
$database = 'students';
$charset = 'utf8';

date_default_timezone_set('Asia/Bangkok');
$connection = @new mysqli($hostname, $username, $password, $database, $port);
if($connection->connect_errno !== 0){
    die('<script> Swal.fire("การเชื่อมต่อล้มเหลว", "' . $connection->connect_error . '") </script>');
}
if(!$connection->set_charset($charset)){
    die('<script> Swal.fire("รูปแบบ charset ไม่ถูกต้อง", "รูปแบบปัจุบันของคุณคือ ' . $charset . '") </script>');
}
?>