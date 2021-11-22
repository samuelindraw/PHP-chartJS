<?php
include "function.php";?>

<?php
$key = $_POST['datakey'];
$key2 = $_POST['dataparent'];
$name = $_POST['name'];
$nama = $_POST['nama'];
$_query = "SELECT * FROM master_karyawan WHERE Nama LIKE '%$nama%'";
$data_karyawan = mysqli_query($strcon, $_query);
$fetch_karyawan  = mysqli_fetch_array($data_karyawan);

$_query_parent = "SELECT * FROM jabatan WHERE `key`= '$key2'";
$data = mysqli_query($strcon, $_query_parent);
$fetch_data  = mysqli_fetch_array($data);
$parent_name = $fetch_data['name'];
if($parent_name == "")
{
   $parent_name = "" ;
}
else {
   $parent_name = $fetch_data['name'];
}
if($fetch_karyawan["NIK"] != null )
{
   $id_NIK = $fetch_karyawan['NIK'];
}
else
{
   $id_NIK = 0;
}

$query= "UPDATE jabatan SET `key`='$key',name='$name',parent='$key2',parentname ='$parent_name',id_NIK = '$id_NIK'
            WHERE `key` = '$key'";
mysqli_query($strcon, $query);
if(mysqli_affected_rows($strcon) > 0 )
{
   $Action = 'UPDATE'; 
   $date = date("d.m.Y, H:i:s");
   $waktu = date("Y-m-d H:i:s", strtotime($date));
   $query_history_jabatan_add = "INSERT INTO history_jabatan VALUES('',$key,'$name','$key2','$id_NIK','$Action'
   ,'$waktu','$parent_name')";
   mysqli_query($strcon, $query_history_jabatan_add);
}
//CREATE history
return mysqli_query($strcon, $query_history);
return header('Location: http://localhost:8080/teskhirPHP/test2.php');
?>