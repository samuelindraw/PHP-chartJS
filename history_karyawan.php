<?php 
session_start();
require 'function.php';
include('include/header.php');
include('include/scripts.php');
global $kunci;
global $kuncian;
global $waktu;
$history = query("SELECT * FROM history_karyawan ORDER BY `Date` DESC");
// $karyawan = query("SELECT karyawan.*, gelar.Kepanjang, gelar.namagelar, kota.namakota FROM karyawan INNER JOIN gelar on karyawan.id_gelar = gelar.id 
// INNER JOIN kota on karyawan.id_kota = kota.id");
//ini klo biar di refresh g ilang
if($_SESSION['key'] !='')
{
    $kuncian = $_SESSION['key'];
    $history = query("SELECT * FROM history_karyawan WHERE `Date` <= '$kuncian' ORDER BY `Date` DESC");        
}
if (isset($_POST["submit"]) ){
	$kunci = $_POST["keyword"];
    $waktu = date("Y-m-d H:i:s", strtotime($kunci));
    $kuncian = $_SESSION['key'] = $waktu;

    if($kunci != "")
     {
        $history = query("SELECT * FROM history_karyawan WHERE `Date` <= '$kuncian' ORDER BY `Date` DESC");     
     }
        
    }
?>
<!-- <script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
<script>
    // Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').dataTable( {
       order:[[0,'desc']]
  } );
});

</script>
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
                        class="fa fa-search fa-fw fa-xs"></i>Cari</button>&nbsp
                <a href="restorekaryawan.php?id=<?= $_SESSION['key'] ?>" class="btn btn-primary mb-2"><i
                        class="fa fa-search fa-fw fa-xs"></i>Restore !</a>
            </form>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table History Karyawan</h6>
        </div>
        <div class="card-body dataTable">
            <!-- <div class="table"> -->
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">Date</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">Action</th>
                        <th class="d-none d-sm-table-cell">NIK</th>
                        <th class="text-center" style="width: 15%;">Nama</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">id_gelar</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">JK</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">tgl_masuk</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">tgl_keluar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $history as $row ) : ?>
                    <tr>
                        <td class="font-w600"><?= date("d/m/Y H:i:s",strtotime($row["Date"]));?></td>
                        <td class="font-w600"><?= $row["Action"] ?></td>
                        <td class="font-w600"><?= $row["NIK"] ?></td>
                        <td class="font-w600"><?= $row["Nama"] ?></td>
                        <td class="font-w600"><?= $row["id_gelar"] ?></td>
                        <td class="font-w600"><?= $row["JK"] ?></td>
                        <td class="font-w600"><?= date("d/m/Y",strtotime($row["tgl_masuk"]));?></td>
                                <?php if($row["tgl_keluar"] == NULL) : ?>
                                <td class="font-w600">Masih bekerja</td>
                                <?php else : ?>
                                <td class="font-w600"><?= date("d/m/Y",strtotime($row["tgl_keluar"]));?></td>
                        <?php endif; ?>
                        
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- </div> -->
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php 

include('include/footer.php');
?>