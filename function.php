<?php 
$strcon = mysqli_connect("localhost","root","","phpakhir");
global $notif;
function query ($query){
	//jangan lupa global
	global $strcon;
	$result = mysqli_query($strcon, $query);
	//rows digunakan untuk menampung array looping
	$rows = [];
	while ($row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}
function restorekaryawan($id)
{
    global $strcon;
    $query = "SELECT * FROM history_karyawan WHERE `Date` < '$id'";
    $result_data = mysqli_query($strcon, $query);
    foreach($result_data as $data_restore)
    {
        if($data_restore['Action'] == 'INSERT')
        {
            //dicek dulu ada datanya ga //VALIDASI
            $nik_id = $data_restore['NIK'];
            $query_cekDATA = "SELECT * FROM master_karyawan WHERE NIK = '$nik_id' LIMIT 1 ";
            $data_nik = mysqli_query($strcon, $query_cekDATA);
            $fetch_nik = mysqli_fetch_assoc($data_nik);
            $testnik = $fetch_nik['NIK'];
            if($testnik == '')
            {
                $NIK = $data_restore['NIK'];
                $Nama = $data_restore['Nama'];
                $id_gelar = $data_restore['id_gelar'];
                $JK = $data_restore['JK'];
                $tgl_masuk = $data_restore['tgl_masuk'];
                $tgl_keluar = $data_restore['tgl_keluar'];
                if($tgl_keluar == '')
                {
                    $query = "INSERT INTO master_karyawan VALUES('$NIK','$Nama','$id_gelar','$JK','$tgl_masuk', NULL)";
                    //RESTORE DI BIKIN HISTORY LAGI TIDAK 
                    mysqli_query($strcon, $query);
                }
                else
                {
                    $query = "INSERT INTO master_karyawan VALUES('$NIK','$Nama','$id_gelar','$JK','$tgl_masuk', tgl_keluar = '$tgl_keluar' )";
                    mysqli_query($strcon, $query);
                }
                
            }     
        }
        if($data_restore['Action'] == 'UPDATE')
        {
            //dicek dulu ada datanya ga //VALIDASI
            $nik_id = $data_restore['NIK'];
            $query_cekDATA = "SELECT * FROM master_karyawan WHERE NIK = '$nik_id' LIMIT 1 ";
            $data_nik = mysqli_query($strcon, $query_cekDATA);
            $fetch_nik = mysqli_fetch_assoc($data_nik);
            if($fetch_nik['NIK'] == $data_restore['NIK']){

                $NIK = $data_restore['NIK'];
                $Nama = $data_restore['Nama'];
                echo $Nama;
                $id_gelar = $data_restore['id_gelar'];
                $JK = $data_restore['JK'];
                $tgl_masuk = $data_restore['tgl_masuk'];
                $tgl_keluar = $data_restore['tgl_keluar'];
                echo $tgl_keluar;
                if($tgl_keluar != '')
                {
                    $query_update = "UPDATE master_karyawan SET NIK = '$NIK', Nama = '$Nama',id_gelar = '$id_gelar',JK = '$JK',tgl_masuk = '$tgl_masuk',tgl_keluar = '$tgl_keluar'
                    WHERE NIK = '$NIK'";
                    //RESTORE DI BIKIN HISTORY LAGI TIDAK 
                  
                    mysqli_query($strcon, $query_update);
                }
                else
                {
                    $query_update = "UPDATE master_karyawan SET NIK = '$NIK', Nama = '$Nama',id_gelar = '$id_gelar',JK = '$JK',tgl_masuk = '$tgl_masuk',tgl_keluar = NULL
                    WHERE NIK = '$NIK'";

                    mysqli_query($strcon, $query_update);
                }
            }
            
        }
        if($data_restore['Action'] == 'DELETE')
        {
            //dicek dulu ada datanya ga //VALIDASI
            $nik_id = $data_restore['NIK'];
            $query_cekDATA = "SELECT * FROM master_karyawan WHERE NIK = '$nik_id' LIMIT 1 ";
            $data_nik = mysqli_query($strcon, $query_cekDATA);
            $fetch_nik = mysqli_fetch_assoc($data_nik);
            if($fetch_nik['NIK'] == $data_restore['NIK']){

                $karyawan = mysqli_query($strcon,"DELETE FROM master_karyawan WHERE NIK = '$nik_id'");
                return mysqli_affected_rows($strcon);
            }
            else
            {
                return false;
            }
        }
    }
    return mysqli_affected_rows($strcon);
}
function restorejabatan($id)
{
    global $strcon;
    echo $id;
    $query = "SELECT * FROM history_jabatan WHERE `Date` < '$id'";
    $result_jabatan = mysqli_query($strcon, $query);
    $rows = [];
	while ($row = mysqli_fetch_assoc($result_jabatan) ) {
		$rows[] = $row;
	}
    print_r($rows);
    foreach($result_jabatan as $data_restore)
    {
        
        if($data_restore['Action'] == 'INSERT')
        {
            //dicek dulu ada datanya ga //VALIDASI
            $name = $data_restore['name'];
            $query_cekDATA = "SELECT * FROM jabatan WHERE `name` = '$name' LIMIT 1";
            $data_jab = mysqli_query($strcon, $query_cekDATA);
            $fetch_jab = mysqli_fetch_assoc($data_jab);
            $teskey = $fetch_jab['name'];
            if($teskey == '')
            {
                $name = $data_restore['name'];
                $parent = $data_restore['parent'];
                $id_NIK = $data_restore['id_NIK'];
                $parentname = $data_restore['parentname'];
                if($parentname == '')
                {
                    $parentname = "";
                }
                $query_add = "INSERT INTO jabatan VALUES('','$name','$parent','$parentname','$id_NIK')";
                mysqli_query($strcon, $query_add);     
            }     
        }
        if($data_restore['Action'] == 'UPDATE')
        {
            //dicek dulu ada datanya ga //VALIDASI
            $name = $data_restore['name'];
            $query_cekDATA = "SELECT * FROM jabatan WHERE `name` = '$name' LIMIT 1 ";
            $data = mysqli_query($strcon, $query_cekDATA);
            $fetch_jab = mysqli_fetch_assoc($data);
            if($fetch_jab['name'] == $data_restore['name']){

                $key = $fetch_jab['key'];
                echo $key;
                $name = $data_restore['name'];
                $parent_name = $data_restore['parentname'];
                $query_cekDATA = "SELECT * FROM jabatan WHERE `name` = '$parent_name' LIMIT 1 ";
                $data = mysqli_query($strcon, $query_cekDATA);
                $fetch_parent = mysqli_fetch_assoc($data);
                {
                    $parent = $fetch_parent['key'];
                    $nama = $fetch_parent['name'];
                }
                $id_NIK = $data_restore['id_NIK'];
                $query_update = "UPDATE jabatan SET `name` = '$name', parent = '$parent',parentname = '$nama', id_NIK = '$id_NIK'
                WHERE `key` = '$key'";
                echo $query_update;
                //RESTORE DI BIKIN HISTORY LAGI TIDAK 
                mysqli_query($strcon, $query_update);                
            }
            
        }
        if($data_restore['Action'] == 'DELETE')
        {
            //dicek dulu ada datanya ga //VALIDASI
            $name = $data_restore['name'];
            $query_cekDATA = "SELECT * FROM jabatan WHERE name = '$name' LIMIT 1 ";
            $data = mysqli_query($strcon, $query_cekDATA);
            $fetch = mysqli_fetch_assoc($data);
            if($fetch['name'] == $data_restore['name']){

                $jabatan = mysqli_query($strcon,"DELETE FROM jabatan WHERE `key` = '$key'"); 
            }

        }
       
    }  
    return mysqli_affected_rows($strcon);
}
function tambahkaryawan($data)
{
	global $strcon;
    $error = "";
    $resultNIK =  str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
    $dataNIK = query("SELECT * FROM master_karyawan WHERE NIK = '$resultNIK'");
    if($dataNIK != NULL){
        $resultNIK =  str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
    }
	$NIK = $resultNIK;
    $resultNama = preg_replace("/[^a-zA-Z ]+/", "", $data["Nama"]);
    // if(str_word_count($resultNama) <= 3)
    // {
    //     return false;
    // }
	$JK = htmlspecialchars($data["Gender"]);
    //nanti di fix pake strlower sama input nya selain L/P di cek
    if($JK == "l" || $JK == "L" || $JK == "Pria" || $JK == "Laki")
    {
        $JK = "L";
    }
    else if($JK == "P" || $JK == "p" || $JK == "Wanita" || $JK == "Perempuan")
    {
        $JK = "P";
    }
	$id_gelar = htmlspecialchars($data["gelar"]);
    $cekgelar = "SELECT * FROM gelar WHERE id = '$id_gelar'";
    $data_gelar = mysqli_query($strcon, $cekgelar);
    $fetch_gelar = mysqli_fetch_array($data_gelar);
    if($fetch_gelar['namaGelar'] == null)
    {
        $id_gelar = 0;  
    }
    else
    {
        $id_gelar = htmlspecialchars($data["gelar"]);
    }
    $tgl_masuk = htmlspecialchars($data["tgl_masuk"]);
    $tgl_keluar = $data["tgl_keluar"];
    
    echo $tgl_keluar;
    $query = "INSERT INTO master_karyawan VALUES('$NIK','$resultNama','$id_gelar','$JK','$tgl_masuk', NULL)";
    echo $query;
    mysqli_query($strcon, $query);
    if(mysqli_affected_rows($strcon) > 0 )
    {
       $Action = 'INSERT'; 
       $date = date("d.m.Y, H:i:s");
       $waktu = date("Y-m-d H:i:s", strtotime($date));
       if($tgl_keluar != '')
       {
           $query_history_add = "INSERT INTO history_karyawan VALUES('','$NIK','$resultNama','$id_gelar','$JK','$tgl_masuk', tgl_keluar = '$tgl_keluar','$Action'
            ,'$waktu')";
            mysqli_query($strcon, $query_history_add);
       }
       else
       {
        $query_history_add = "INSERT INTO history_karyawan VALUES('','$NIK','$resultNama','$id_gelar','$JK','$tgl_masuk', tgl_masuk = NULL ,'$Action'
        ,'$waktu')";
        mysqli_query($strcon, $query_history_add);
       }
       
       
    }
    return mysqli_affected_rows($strcon);
}
function hapuskaryawan($id)
{

	global $strcon;
    $query_karyawans = "SELECT * FROM master_karyawan WHERE NIK = '$id'";
    $data_karyawan = mysqli_query($strcon, $query_karyawans);
    $fetchdata = mysqli_fetch_array($data_karyawan);
    $NIK = $fetchdata['NIK'];
    $Nama = $fetchdata['Nama'];
    $id_gelar = $fetchdata['id_gelar'];
    $JK = $fetchdata['JK'];
    $tgl_masuk = $fetchdata['tgl_masuk'];
    $tgl_keluar = $fetchdata['tgl_keluar'];
    $karyawan = mysqli_query($strcon,"DELETE FROM master_karyawan WHERE NIK = '$id'");
    if(mysqli_affected_rows($strcon) > 0 )
    {
       $Action = 'DELETE'; 
       $date = date("d.m.Y, H:i:s");
       $waktu = date("Y-m-d H:i:s", strtotime($date));
       if($tgl_keluar = ''){
            $query_history_add = "INSERT INTO history_karyawan VALUES('','$NIK','$Nama','$id_gelar','$JK','$tgl_masuk',tgl_keluar = NULL ,'$Action'
            ,'$waktu')";
       }
       else
       {
            $query_history_add = "INSERT INTO history_karyawan VALUES('','$NIK','$Nama','$id_gelar','$JK','$tgl_masuk',tgl_keluar = '$tgl_keluar' ,'$Action'
            ,'$waktu')";
       }
      
       mysqli_query($strcon, $query_history_add);
    }
    return mysqli_affected_rows($strcon);

}
function hapusjabatan($id)
{
	global $strcon;
    global $strcon;
    $query_jabatan = "SELECT * FROM jabatan WHERE `key` = '$id'";
    $data_jabatan = mysqli_query($strcon, $query_jabatan);
    $fetchdata = mysqli_fetch_array($data_jabatan);
    $key = $fetchdata['key'];
    $name = $fetchdata['name'];
    $parent = $fetchdata['parent'];
    $id_NIK = $fetchdata['id_NIK'];
    $jabatan = mysqli_query($strcon,"DELETE FROM jabatan WHERE `key` = '$id'");
    if(mysqli_affected_rows($strcon) > 0 )
    {
       $Action = 'DELETE'; 
       $date = date("d.m.Y, H:i:s");
       $waktu = date("Y-m-d H:i:s", strtotime($date));
       $query_history_add = "INSERT INTO jabatan VALUES('','$key','$name','$parent','$id_NIK' ,'$Action'
       ,'$waktu')";
       mysqli_query($strcon, $query_history_add);
    }
    return mysqli_affected_rows($strcon);
}
function editkaryawan($data)
{
    global $strcon;
    $error = "";
	$NIK = $data["NIK"];
    $resultNama = preg_replace("/[^a-zA-Z ]+/", "", $data["Nama"]);
    // if(str_word_count($resultNama) <= 3)
    // {
    //     return false;
    // }
	$JK = htmlspecialchars($data["Gender"]);
    // if($JK != "L" || $JK != "P")
    // {
    //     $JK = "L";
    // }
	$id_gelar = htmlspecialchars($data["gelar"]);
    $cekgelar = "SELECT * FROM gelar WHERE id = '$id_gelar'";
    $data_gelar = mysqli_query($strcon, $cekgelar);
    $fetch_gelar = mysqli_fetch_array($data_gelar);
    if($fetch_gelar['namaGelar'] == null)
    {
        $id_gelar = 0;  
    }
    else
    {
        $id_gelar = htmlspecialchars($data["gelar"]);
    }
    $tgl_masuk = htmlspecialchars($data["tgl_masuk"]);
    $tgl_keluar = htmlspecialchars($data["tgl_keluar"]);    
    if($tgl_keluar != '')
        {
            $query= "UPDATE master_karyawan SET NIK = '$NIK', Nama = '$resultNama',id_gelar = '$id_gelar',JK = '$JK',tgl_masuk = '$tgl_masuk',tgl_keluar = '$tgl_keluar'
            WHERE NIK = '$NIK'";
        }
        else {
            $query= "UPDATE master_karyawan SET NIK = '$NIK', Nama = '$resultNama',id_gelar = '$id_gelar',JK = '$JK',tgl_masuk = '$tgl_masuk', tgl_keluar = NULL
            WHERE NIK = '$NIK'";
    }
    mysqli_query($strcon, $query);
    if(mysqli_affected_rows($strcon) > 0 )
    {
       $Action = 'UPDATE'; 
       $date = date("d.m.Y, H:i:s");
       $waktu = date("Y-m-d H:i:s", strtotime($date));
       if($tgl_keluar != '')
       {
            $query_history_add = "INSERT INTO history_karyawan VALUES('','$NIK','$resultNama','$id_gelar','$JK','$tgl_masuk','$tgl_keluar' ,'$Action'
            ,'$waktu')";
            mysqli_query($strcon, $query_history_add);
       }
       else
       {
            $query_history_add = "INSERT INTO history_karyawan VALUES('','$NIK','$resultNama','$id_gelar','$JK','$tgl_masuk',tgl_keluar = NULL ,'$Action'
            ,'$waktu')";
            mysqli_query($strcon, $query_history_add);
       }
      
    }
    return mysqli_affected_rows($strcon);
}
function editjabatan($data)
{
    global $strcon;
	$key = $data["key"];
    echo $key;
	$name = $data["name"];
    echo $name;
	$nik_lama = $data["nik_lama"];
    echo $nik_lama;
	$nik_baru = $data["nik_baru"];
    echo $nik_baru;
    $parent = $data["parent"];
    echo $parent;
    $query_cekjabatan = "SELECT * FROM jabatan WHERE name LIKE '%$name%'";
    $data_jabat = mysqli_query($strcon, $query_cekjabatan);
    $fetch_jabatans  = mysqli_fetch_array($data_jabat);
    $data_fetch_nama = $fetch_jabatans['name'];
    if($data_fetch_nama == "")
    {
        $nama_jabatan = $data["name"];
        
    }
    else
    {
        $nama_jabatan = $data_fetch_nama;       
    }
    if($nik_baru == null)
    {
        $nik = $nik_lama;
    }
    else
    {
        $nik = $nik_baru;
    }
	//di cek apakah ada name yang LIKE SAMA DENGAN YANG ADA DI DB
	//KLO MISAL MAU GANTI PEGAWAI BERARTI DI IF DULU ADA GA PEGAWAI YANG BARU KLO G ADA MASUKIN PEGAWAI YANG LAMA PAKAI ID NIK LAMA JANGAN LUPA NGISI HISTORY

    $query_edit= "UPDATE jabatan SET `key` ='$key',`name`='$nama_jabatan', id_NIK = '$nik', parent = '$parent'
    WHERE `key` = '$key'";
    echo $query_edit;
    mysqli_query($strcon, $query_edit);
    if(mysqli_affected_rows($strcon) > 0 )
    {
       $Action = 'UPDATE'; 
       $date = date("d.m.Y, H:i:s");
       $waktu = date("Y-m-d H:i:s", strtotime($date));
       $query_history_jabatan_add = "INSERT INTO history_jabatan VALUES('',$key,'$name','$parent','$nik','$Action'
       ,'$waktu')";
       mysqli_query($strcon, $query_history_jabatan_add);
    }
    return mysqli_affected_rows($strcon);  
}
function tambahjabatan($data)
{
    global $strcon;
    $name = htmlspecialchars($data['name']);
    echo $name;
    $query_cekjabatan = "SELECT * FROM jabatan WHERE name LIKE '%$name%'";
    $data_jabat = mysqli_query($strcon, $query_cekjabatan);
    $fetch_jabatans  = mysqli_fetch_array($data_jabat);
    $data_fetch_nama = $fetch_jabatans['name'];
    if($data_fetch_nama == "")
    {
        $nama_jabatan = $data["name"];
        
    }
    else
    {
        return false;
    }
    $id_NIK = $data['nik_baru'];
    $query_cekNIK = "SELECT * FROM jabatan WHERE id_NIK = '$id_NIK' ";
    $data_nik = mysqli_query($strcon, $query_cekNIK);
    $fetch_nik  = mysqli_fetch_array($data_nik);
    if($fetch_nik == "")
    {
        $id_NIK = $data['nik_baru'];
    }
    else
    {
        $id_NIK = 0;
    }
    if($data["parent"] == null )
    {
      $parent = 0;
    }
    else
    {
      $parent = htmlspecialchars($data["parent"]);
    }
    $parent_name = "";
    $query_add = "INSERT INTO jabatan VALUES('','$name','$parent','$parent_name','$id_NIK')";
    echo $query_add;
    mysqli_query($strcon, $query_add);
    if(mysqli_affected_rows($strcon) > 0 )
    {
       $Action = 'INSERT'; 
       $date = date("d.m.Y, H:i:s");
       $waktu = date("Y-m-d H:i:s", strtotime($date));
       $query_history_jabatan_add = "INSERT INTO history_jabatan VALUES('',NULL,'$name','$parent','$id_NIK','$Action'
       ,'$waktu','$parent_name')";
       mysqli_query($strcon, $query_history_jabatan_add);
    }
    //return mysqli_affected_rows($strcon);  
}
?>
