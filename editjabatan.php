<?php
include "function.php";?>

<?php
$key1 = $_POST['key1'];
$key2 = $_POST['key2'];
echo $key1;
$_query = "SELECT * FROM jabatan WHERE `key` = $key1";
$data_jabatan = mysqli_query($strcon, $_query);
$fetchdata  = mysqli_fetch_array($data_jabatan);
$nama = $fetchdata['name'];
$id_NIK = $fetchdata['id_NIK']; 

$_query_parent = "SELECT * FROM jabatan WHERE `key`= '$key2'";
$data = mysqli_query($strcon, $_query_parent);
$fetch_data_jabatan  = mysqli_fetch_array($data);
$parent_name = $fetch_data_jabatan['name'];
$query= "UPDATE jabatan SET `key`= '$key1',name='$nama',
parent='$key2', parentname = '$parent_name ' WHERE `key` = '$key1'";
mysqli_query($strcon, $query);

if(mysqli_affected_rows($strcon) > 0 )
{
   $Action = 'UPDATE'; 
   $date = date("d.m.Y, H:i:s");
   $waktu = date("Y-m-d H:i:s", strtotime($date));
   $query_history_jabatan_add = "INSERT INTO history_jabatan VALUES('',$key1,'$nama','$key2','$id_NIK','$Action' ,'$waktu','$parent_name')";
   echo $query_history_jabatan_add;
   mysqli_query($strcon, $query_history_jabatan_add);
}
//CREATE history
return header('Location: http://localhost:8080/teskhirPHP/test2.php');
?>