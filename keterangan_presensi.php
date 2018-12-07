<?php
 if(empty($_SESSION['admin'])){
    echo '<script language="javascript">
            window.alert("ERROR! Anda tidak memiliki hak akses untuk melihat data ini");
            window.location.href="./admin.php?page=pres";
          </script>';
} else {
	?>
<style>
.td{
	text-align:center!important;
}
.td ,th{
	text-align:center;
}

</style>
<?php
	$id=mysqli_real_escape_string($config,$_REQUEST['id']);
	if($_SESSION['admin']!=1){
	$cekdiv=mysqli_query($config,"SELECT divisi FROM tbl_presensi WHERE id='$id'");
	list($divisis)=mysqli_fetch_array($cekdiv);
	if($divisis!=$_SESSION['divisi']){
        echo '<script>
        alert("Anda dilarang untuk melihat data selain divisi anda!");
        window.location.href="./admin.php?page=pres";
        </script>';
        
	}}
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    }

	else {
		

        if(isset($_REQUEST['sub'])){
            $sub = $_REQUEST['sub'];
            switch ($sub) {
                
                case 'del':
                    include "hapus_keterangan.php";
                    break;
				case 'managers':
                    include "lembur_managers.php";
                    break;
				
            }
        } else {
			
			
				$id=mysqli_real_escape_string($config,$_REQUEST['id']);
				
				if(isset($_REQUEST['accept'])){
					if($_SESSION['admin']==4 || $_SESSION['admin']==5){
					$itj=mysqli_query($config,"UPDATE tbl_keterangan_presensi SET status_gm=1 WHERE id_presensi='$id' AND divisi='".$_SESSION['divisi']."'");}
					else if($_SESSION['admin']==1){
					$itj=mysqli_query($config,"UPDATE tbl_keterangan_presensi SET status_gm=1 WHERE id_presensi='$id'");
					}
				}
				
				
				if(isset($_POST['tambahketerangan'])){
				$tanggal=mysqli_real_escape_string($config,$_POST['tanggal']);
				$keterangan=mysqli_real_escape_string($config,$_POST['keterangan']);
				$jam=mysqli_real_escape_string($config,$_POST['jam']);
				$menit=mysqli_real_escape_string($config,$_POST['menit']);
				if($_SESSION['admin']==4 || $_SESSION['admin']==5 || $_SESSION['admin']==3 || $_SESSION['admin']==2){
				$tambahketeranganr=mysqli_query($config,"INSERT INTO tbl_keterangan_presensi (id_presensi,id_user,keterangan,tanggal,jam,status_gm,divisi) VALUES('$id','".$_SESSION['id_user']."','$keterangan','$tanggal','$jam.$menit',1,'".$_SESSION['divisi']."')");}
				else {
				$tambahketeranganr=mysqli_query($config,"INSERT INTO tbl_keterangan_presensi (id_presensi,id_user,keterangan,tanggal,jam,divisi) VALUES('$id','".$_SESSION['id_user']."','$keterangan','$tanggal','$jam.$menit','".$_SESSION['divisi']."')");}
				
				
				$_SESSION['succEdit'] = 'SUKSES ! Keterangan berhasil diinput';
                                header("Location: ./admin.php?page=pres&act=ketpres&id=".$id."");
                                die();
				}
            //pagging
            $limit = 99999999;
            $pg = mysqli_real_escape_string($config,@$_GET['pg']);
                if(empty($pg)){
                    $curr = 0;
                    $pg = 1;
                } else {
                    $curr = ($pg - 1) * $limit;
                }

                $id = mysqli_real_escape_string($config,$_REQUEST['id']);

                $query = mysqli_query($config, "SELECT bulan FROM tbl_presensi WHERE id='$id'");
				list($bulan)=mysqli_fetch_array($query);
				$bulans=date('M Y',strtotime($bulan));
                

                   

                      echo '<!-- Row Start -->
                            <div class="row">
                                <!-- Secondary Nav START -->
                                <div class="col s12">
                                    <div class="z-depth-1">
                                        <nav class="secondary-nav">
                                            <div class="nav-wrapper blue-grey darken-5" style="background-color:#39424c!important">
                                                <div class="col m12">
                                                    <ul class="left">
                                                        <li class="waves-effect waves-light hide-on-small-only"><a href="#" id="tes" class="judul"><i class="material-icons">alarm_add</i> Keterangan Presensi</a></li>
                                                        
                                                      
														
                                                        <li class="waves-effect waves-light"><a href="?page=pres">
																						
														
														<i class="material-icons">arrow_back</i> Kembali</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                                <!-- Secondary Nav END -->
                            </div>
                            <!-- Row END -->

                            <!-- Perihal START -->
                            <div class="col s12">
                                <div class="card yellow darken">
                                    <div class="card-content">
                                        <p><p class="description">Presensi Bulan:</p><strong>'.$bulans.'<strong></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Perihal END -->';
							

                            if(isset($_SESSION['succAdd'])){
                                $succAdd = $_SESSION['succAdd'];
                                echo '<div id="alert-message" class="row">
                                        <div class="col m12">
                                            <div class="card green lighten-5">
                                                <div class="card-content notif">
                                                    <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succAdd.'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                unset($_SESSION['succAdd']);
                            }
                            if(isset($_SESSION['succEdit'])){
                                $succEdit = $_SESSION['succEdit'];
                                echo '<div id="alert-message" class="row">
                                        <div class="col m12">
                                            <div class="card green lighten-5">
                                                <div class="card-content notif">
                                                    <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succEdit.'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                unset($_SESSION['succEdit']);
                            }
                            if(isset($_SESSION['succDel'])){
                                $succDel = $_SESSION['succDel'];
                                echo '<div id="alert-message" class="row">
                                        <div class="col m12">
                                            <div class="card green lighten-5">
                                                <div class="card-content notif">
                                                    <span class="card-title green-text"><i class="material-icons md-36">done</i> '.$succDel.'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                unset($_SESSION['succDel']);
                            }?>
							
							<div class="col m12" id="colres">		
                            <table class="bordered" id="tblp">
                                <thead class="blue lighten-4" id="head" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-bottom:2px solid black">
                                   <tr>
                                               
                                                <th width="15%">Keterangan</th>
												<th width="16%">Tanggal</th>
                                                <th width="14%" colspan="2">Jam</th>
												<th width="16%">Tindakan</th>
                                            </tr>
											
										</thead>
										
										<form method="POST">
										<tbody style="background-color:rgba(255,255,0,0.7);box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
										<tr>
										<td style="text-align:center">
										<input type="text" name="keterangan" style="text-align:center" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')">
										
										</td>
										<td style="text-align:center">
										<input id="tgl_surat" class="datepicker" type="text" name="tanggal" style="text-align:center">
										</td>
										
										
										<td style="text-align:center">
										<input type="number" name="jam" style="text-align:center" min="00" max="23">
										</td>
										
										<td style="text-align:center">
										<input type="number" name="menit" style="text-align:center" min="00" max="59">
										</td>
										
										
										
										
										
										<td style="text-align:center">
										<button id="tambah" type="submit" name="tambahketerangan" class="btn-large" style="text-align:center;">TAMBAH</button>
										</td>
										</tr>
										</tbody>
										</form>
										</table>
										</div>
                           <?php 
						   if($_SESSION['admin']==1 || $_SESSION['admin']==4 || $_SESSION['admin']==5){
						   echo'<div class="col m12" style="text-align:center;margin-top:34px">
                           
                                    <form method="POST">
									<button class="btn small blue waves-effect waves-light tooltipped" name="accept" data-position="left" data-tooltip="Klik untuk Menyetujui" onclick="return confirm(\'Anda yakin ingin menyetujui semua data?\');">
										<i class="material-icons">warning</i> SETUJUI SEMUA DATA</button>
										</form>
									
                                
						   </div>';}
						   ?>

                             <div class="row jarak-form">

<div class="col m12" id="colres">
    <table class="bordered" id="tblb">
        <thead class="blue lighten-4" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)">
            <tr>
                <th width="1%">No</th>
                <th width="20%">Nama</th>
                <th width="10%">Tindakan</th>
            </tr>
            
        </thead>

        <tbody>
            <?php
            $tokenpresensi = bin2hex(mt_rand(0,9999));
            $_SESSION['tokenpresensi']=$tokenpresensi;
            $nos=1;
            if($_SESSION['admin']==1){
                $gk=mysqli_query($config,"SELECT DISTINCT id_user FROM tbl_keterangan_presensi WHERE id_presensi='$id'");  
            } else if ($_SESSION['admin']==5 || $_SESSION['admin']==4 || $_SESSION['admin']==3 || $_SESSION['admin']==2 ) {
                $gk=mysqli_query($config,"SELECT DISTINCT id_user FROM tbl_keterangan_presensi WHERE id_presensi='$id' AND divisi='".$_SESSION['divisi']."'");
            } else {
                $gk=mysqli_query($config,"SELECT DISTINCT id_user FROM tbl_keterangan_presensi WHERE id_presensi='$id' AND id_user='".$_SESSION['id_user']."'");
            }
            if(mysqli_num_rows($gk)<=0){
				echo '<tr>
				<td style="text-align:center!important" colspan="3"><h5>Tidak ada data untuk ditampilkan</h5></td>
				</tr>';	
			}

            while($row=mysqli_fetch_array($gk)){
                $ku=mysqli_query($config,"SELECT nama FROM tbl_user WHERE id_user='".$row['id_user']."'");
                list($namaz)=mysqli_fetch_array($ku);
                echo '<tr>
                <td style="text-align:center!important">'.$nos++.'</td>
                <td style="text-align:center!important">'.$namaz.'</td>
                <td style="text-align:center!important"><a id="ket'.$row['id_user'].'" data-pres="'.$id.'" class="btn green">lihat</a></td>
                </tr>
                </tbody>
                <script>
$(document).ready(function(){
$(\'#ket'.$row['id_user'].'\').click(function(){
    var token = '.$tokenpresensi.';
    var idz = $(this).data("pres");
    $.post(\'./js/ajaxketpres.php\', {idz : idz, user : '.$row['id_user'].', token : token}, function(data){
        $("#anjas").html(data);
    });
$(\'#modals\').openModal();
});
});
</script>';
            }
            ?>
       
        </table>
        </div>
        </div>




                           <?php
						   
						   echo '
                            <!-- Row form Start -->
                            
                            <div id="modals" class="modal" style="width:80%">
                            <div class="modal-content" id="anjas">
                           
                            </div>
                            </div>
                           

							
                            <!-- Row form END -->';
                    }
                
            
        }
    }
	
?>
<script type="text/javascript" src="asset/js/halamanlembur.js"></script>
