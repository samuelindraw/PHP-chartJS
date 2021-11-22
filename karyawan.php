<?php 
session_start();
require 'function.php';
include('include/header.php');
include('include/scripts.php');
global $aktif;
global $kunci;
$karyawan = query("SELECT master_karyawan.*, gelar.namagelar FROM master_karyawan INNER JOIN gelar on master_karyawan.id_gelar = gelar.id");
// $karyawan = query("SELECT karyawan.*, gelar.Kepanjang, gelar.namagelar, kota.namakota FROM karyawan INNER JOIN gelar on karyawan.id_gelar = gelar.id 
// INNER JOIN kota on karyawan.id_kota = kota.id");
//ini klo biar di refresh g ilang
if($_SESSION['key'] !='')
{
    $kuncian = $_SESSION['key'];
    $karyawan = query("SELECT master_karyawan.*,gelar.namagelar FROM master_karyawan INNER JOIN gelar on master_karyawan.id_gelar = gelar.id WHERE (tgl_masuk <= '$kuncian' AND tgl_keluar IS NULL) OR (tgl_masuk <= '$kuncian' AND tgl_keluar > '$kuncian')");         
}
if (isset($_POST["submit"]) ){
	$kunci = $_POST["keyword"];
    $kuncian = $_SESSION['key'] = $kunci;
    
    if($kunci != "")
     {
        $karyawan = query("SELECT master_karyawan.*,gelar.namagelar FROM master_karyawan INNER JOIN gelar on master_karyawan.id_gelar = gelar.id WHERE (tgl_masuk <= '$kuncian' AND tgl_keluar IS NULL) OR (tgl_masuk <= '$kuncian' AND tgl_keluar > '$kuncian')");
     }
        
    }
?>
<script>
    // Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').dataTable( {
       order:[[0,'desc']]
  } );
});

</script>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form class="form-inline" action="" method="post">
                <div class="form-group mb-2">
                    <label for="Tanggal">Tanggal</label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <?php if ($_SESSION['key'] != '') { ?>
                    <input type="date" class="form-control" id="keyword" name="keyword"
                        value="<?php echo $_SESSION['key']?>">
                    <?php } else { ?>
                    <input type="date" class="form-control" id="keyword" name="keyword">
                    <?php } ?>
                </div>
                <button type="submit" id="submit" name="submit" class="btn btn-primary mb-2"><i
                        class="fa fa-search fa-fw fa-xs"></i>Cari</button>
            </form>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <a href="tambahkaryawan.php" class="btn btn-primary bottom-buffer" id="btn-add-karyawan"
                    style="float:right;"><i class="fa fa-plus"></i> Tambah </a>
                <h6 class="m-0 font-weight-bold text-primary">Table Karyawan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th class="d-none d-sm-table-cell">Nama</th>
                                <th class="d-none d-sm-table-cell">Gelar</th>
                                <th class="d-none d-sm-table-cell">Jenis kelamin</th>
                                <th class="d-none d-sm-table-cell">Tanggal masuk</th>
                                <th class="d-none d-sm-table-cell">Tanggal keluar</th>
                                <th class="text-center" style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach( $karyawan as $row ) : ?>
                            <tr>

                                <td class="font-w600"><?= $row["NIK"] ?></td>
                                <td class="font-w600"><?= $row["Nama"] ?></td>
                                <td class="font-w600"><?= $row["namagelar"] ?></td>
                                <?php if($row["JK"] == "L") : ?>
                                <td class="font-w600">Laki Laki</td>
                                <?php else : ?>
                                <td class="font-w600">Perempuan</td>
                                <?php endif; ?>
                                <td class="font-w600"><?= date("d/m/Y",strtotime($row["tgl_masuk"]));?></td>
                                <?php if($row["tgl_keluar"] == NULL) : ?>
                                <td class="font-w600">Masih bekerja</td>
                                <?php else : ?>
                                <td class="font-w600"><?= date("d/m/Y",strtotime($row["tgl_keluar"]));?></td>
                                <?php endif; ?>
                                <td class="text-center">
                                    <a href="editkaryawan.php?id=<?=$row["NIK"];?>" title="edit"
                                        class="btn btn-xs btn-secondary"><i class="fa fa-edit fa-fw fa-xs"></i></a>
                                    <a href="hapuskaryawan.php?id=<?=$row["NIK"];?>" title="delete"
                                        class="btn btn-xs btn-danger"><i class="fa fa-trash fa-fw fa-xs"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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