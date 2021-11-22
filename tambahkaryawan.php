<?php 
require 'function.php';
include('include/header.php');
$gelar = query("SELECT * FROM gelar");
$jabatan = query("SELECT * FROM jabatan");
if(isset($_POST["submit"]))
{
	if(tambahkaryawan($_POST) > 0)
	{
		echo"
		<script>
		 alert('Data Berhasil tambah');
         document.location.href ='karyawan.php';
		</script> ";
	}
	else
	{
        
		echo "
		<script>
		 alert('Data gagal tambah ');
         document.location.href ='karyawan.php';
		</script> ";
	}
}

?>
<div class="container-fluid">
    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Karyawan</h6>
        </div>
        <form action="" method="post">
            <br>
            <div class="form-group col-md-3">
                <button type="button" onclick="location.href='karyawan.php'" id="kembali" name="kembali"
                    class="btn btn-secondary"><i class="fa fa-arrow-left fa-fw fa-xs"></i> kembali</button>
                <button type="submit" id="submit" name="submit" class="btn btn-primary"><i
                        class="fa fa-save fa-fw fa-xs"></i> Simpan</button>
            </div>
            <div class="form-row col-md-12 mt-3">
                <div class="form-group col-md-6">
                    <label for="Nama">Nama</label>
                    <input type="text" class="form-control" id="Nama" name="Nama" required pattern="[a-zA-Z0-9\s]+.{3,50}"
                        title="3 Huruf atau lebih">
                    <small class="text-danger" id="errNama"></small>
                </div>
            </div>
            <div class="form-row col-md-12 mt-3">
                <div class="form-group col-md-6">
                    <label for="gelar ">Gelar yang karyawan</label>
                    <select class="form-control" name="gelar" required>
                        <option value=""> Pilih Gelar </option>
                        <?php foreach ($gelar as $rows ){
                        echo "<option value ='".$rows['id']."'>".$rows['namaGelar']."</option>";
                // echo $row->Kodejenis==$result['namaJenisBuku']?'selected':'';
                } 
                echo"</select>"?>
                    </select>
                </div>
            </div>
            <div class="form-row col-md-12 mt-3">
                <div class="form-group col-md-6">
                    <label for="gelar ">Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Gender" id="Gender" checked value="L">
                        <label class="form-check-label" for="Gender">
                            Laki Laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Gender" id="Gender" value="P">
                        <label class="form-check-label" for="Gender">
                            Perempuan
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-row col-md-12 mt-3">
                <div class="form-group col-md-6">
                    <label for="tgl_masuk">Tanggal Masuk</label>
                    <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" required  data-date-format="dd/mm/yyyy">
                </div>
            </div>
         <br>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php 
include('include/scripts.php');
include('include/footer.php');
?>