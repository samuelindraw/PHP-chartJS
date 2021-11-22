<?php 
require 'function.php';
include('include/header.php');

$karyawan = query("SELECT gelar.namaGelar, COUNT((SELECT master_karyawan.JK WHERE master_karyawan.JK = 'L')) as pria, 
COUNT((SELECT master_karyawan.JK WHERE master_karyawan.JK = 'P')) as wanita
FROM master_karyawan
LEFT JOIN gelar ON gelar.id = master_karyawan.id_gelar 
GROUP BY gelar.namaGelar");
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table Count Gelar Karyawan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Gelar</th>
                            <th>Laki-laki</th>
                            <th>Perempuan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $karyawan as $row ) : ?>
                        <tr>
                            <td><?= $row["namaGelar"] ?></td>
                            <td><?= $row["pria"] ?></td>
                            <td><?= $row["wanita"] ?></td>
                            <td><?= $row["pria"] + $row["wanita"] ?></td>
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