<?php
require 'function.php';
$id = $_GET["id"];
//manggil function hapus di require function hapus
echo $id;
// document.location.href ='karyawan.php';
if(restorekaryawan($id) > 0)
	{
		echo "
		<script>
		 alert('Data berhasil hapus');
		 document.location.href ='karyawan.php';
		</script> ";
	}
	else
	{
		echo "
		<script>
		 alert('Data gagal hapus');
         document.location.href ='karyawan.php';
		</script> ";
	}
?>