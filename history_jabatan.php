<?php 
session_start();
require 'function.php';
include('include/header.php');
include('include/scripts.php');
global $kunci;
global $kuncian;
global $waktu;
$history = query("SELECT * FROM history_jabatan ORDER BY `Date` DESC");
if($_SESSION['key'] !='')
{
    $kuncian = $_SESSION['key'];
    $history = query("SELECT * FROM history_jabatan WHERE `Date` <= '$kuncian' ORDER BY `Date` DESC ");        
}
if (isset($_POST["submit"]) ){
	$kunci = $_POST["keyword"];
    $waktu = date("Y-m-d H:i:s", strtotime($kunci));
    $kuncian = $_SESSION['key'] = $waktu;

    if($kunci != "")
     {
        $history = query("SELECT * FROM history_jabatan WHERE `Date` <= '$kuncian' ORDER BY `Date` DESC ");            
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
                <a href="restorejabatan.php?id=<?= $_SESSION['key'] ?>" class="btn btn-primary mb-2"><i
                        class="fa fa-search fa-fw fa-xs"></i>Restore !</a>
            </form>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table History Jabatan</h6>
        </div>
        <div class="card-body dataTable">
            <!-- <div class="table"> -->
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">Date</th>  
                            <th class="d-none d-sm-table-cell" style="width: 15%;">Action</th>            
                            <th class="text-center" style="width: 15%;">name</th>
                            <th class="d-none d-sm-table-cell"style="width: 15%;">parent</th>   
                            <th class="d-none d-sm-table-cell" style="width: 15%;">id_NIK</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $history as $row ) : ?>
                        <tr>
                            <td class="font-w600"><?= date("d/m/Y H:i:s",strtotime($row["Date"]));?></td>
                            <td class="font-w600"><?= $row["Action"] ?></td>
                            <td class="font-w600"><?= $row["name"] ?></td>
                            <td class="font-w600"><?= $row["parentname"] ?></td>
                            <td class="font-w600"><?= $row["id_NIK"] ?></td>
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
include('include/scripts.php');
include('include/footer.php');
?>