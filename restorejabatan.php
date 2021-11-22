<?php
require 'function.php';
$id = $_GET["id"];
//manggil function hapus di require function hapus
echo $id;
// document.location.href ='karyawan.php';
if(restorejabatan($id) > 0)
	{
		echo "
		<script>
		 alert('Data berhasil hapus');
         document.location.href ='test2.php';
		</script> ";
	}
	else
	{
		echo "
		<script>
		 alert('Data gagal hapus');
         document.location.href ='test2.php';
		</script> ";
	}
?>