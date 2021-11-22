<?php 
require 'function.php';
include('include/header.php');
$jabatan_nik = query("SELECT jabatan.*, master_karyawan.NIK, master_karyawan.Nama FROM jabatan RIGHT JOIN 
master_karyawan on jabatan.id_NIK = master_karyawan.NIK WHERE jabatan.key IS NULL");
if(isset($_POST["submit"]))
{
	if(tambahjabatan($_POST) > 0 )
	{
		echo"
		<script>
		 alert('Data Berhasil tambah');
         document.location.href ='test2.php';
		</script> ";
	}
	else
	{
		echo "
		<script>
		 alert('Data gagal tambah');
         document.location.href ='test2.php';
		</script> ";
	}
}
?>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Jabatan</h6>
        </div>
        <form action="" method="post">
            <br>
            <div class="form-group col-md-3">
                    <button type="button" onclick="location.href='test2.php'" id="kembali" name="kembali"
                    class="btn btn-secondary"><i class="fa fa-arrow-left fa-fw fa-xs"></i> kembali</button>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary"><i
                    class="fa fa-save fa-fw fa-xs"></i> Simpan</button>
            </div>
            <div class="form-row col-md-12 mt-3">
                <div class="form-group col-md-6">
                    <label for="name">Jabatan</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        pattern="[a-zA-Z0-9\s]+.{3,50}" title="3 Huruf atau lebih">
                    <small class="text-danger" id="errNama"></small>
                </div>
            </div>
            <div class="form-row col-md-12 mt-3">
                    <div class="form-group col-md-6">
                        <label for="nama">Ganti Pegawai</label>
                        <select class="form-control" name="nik_baru">
                            <option value=""> Piih Nama </option>
                            <?php foreach ($jabatan_nik as $row ){
                            // echo "<option value ='".$row['Kodejenis']." selected'>".$bukuku['jenisBuku']."</option>";
                            echo "<option value ='".$row['NIK']."'>".$row['Nama']."</option>";
                        }
                        ?>
                        </select>
                    </div>
                </div>
            </div>
           
         </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<?php 
include('include/scripts.php');
include('include/footer.php');
?>