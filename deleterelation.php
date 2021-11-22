<?php
include "function.php";?>

<?php
$key = $_POST['deadkey'];
echo $key;
$_query = "SELECT * FROM jabatan WHERE `key` = $key";
$data_jabatan = mysqli_query($strcon, $_query);
$fetchdata  = mysqli_fetch_array($data_jabatan);
$name = $fetchdata['name'];
$parent = $fetchdata['parent'];
$id_NIK = $fetchdata['id_NIK'];
$parent_name = "";
$key2 = 0;
$query= "UPDATE jabatan SET `key`= '$key',name='$name',parent=''
            WHERE `key` = '$key'";
mysqli_query($strcon, $query);
if(mysqli_affected_rows($strcon) > 0 )
{
   $Action = 'UPDATE'; 
   $date = date("d.m.Y, H:i:s");
   $waktu = date("Y-m-d H:i:s", strtotime($date));
   $query_history_jabatan_add = "INSERT INTO history_jabatan VALUES('','$key','$name','$key2','$id_NIK','$Action'
   ,'$waktu','$parent_name')";
   mysqli_query($strcon, $query_history_jabatan_add);
}
// //CREATE history
return header('Location: http://localhost:8080/teskhirPHP/test2.php');
?>