
<?php 
	if(isset($_POST['cek'])){
		$dari_tgl = sanitize($_POST['date-from']);
		$sampai_tgl = sanitize($_POST['date-to']);
		$id_pegawai = sanitize($_POST['id_pegawai']);

	}
	if (!empty($id_pegawai)) {
		$data1 = $mysqli->query("SELECT * FROM tbl_transaksi WHERE id_pegawai = '$id_pegawai' and is_paid=1 and paid_at BETWEEN '$dari_tgl' and '$sampai_tgl' ");
	}else{
		$data1 = $mysqli->query("SELECT * FROM tbl_transaksi WHERE is_paid = 1 and paid_at BETWEEN '$dari_tgl' and '$sampai_tgl' ");		
	}
?>
<!-- Template Umum Jivi-->
<body onload="printIni()">
<div class="app-title">
	<div>
		<h1><a href="?page=transaksi" class="btn btn-sm btn-default"><i class="fa fa-chevron-left"></i> </a><i class="fa fa-print"></i> Cetak Report</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item"><a href="javascript:void(0)">Cetak Report</a></li> <!-- Ini Sesuaikan menu -->
	</ul>
</div>
<div class="tile row">
		
   <!---------------------------------------- Ini yang di edit dari bawah -------------------------------------------->
   <div class="table-responsive">
   	<h5 class="text-center">Laporan  
        <?php if(!empty($dari_tgl)){echo 'dari  '. date('d-m-Y', strtotime($dari_tgl));}?> sampai <?=date('d-m-Y', strtotime($sampai_tgl))?> :</h5>
   	<table class="table " width="100%"  style="font-size:12px">
   		<tr>
   			<th>No.</th>
   			<th>Nama Kasir</th>
   			<th>Total Harga</th>
   			<th>Waktu Transaksi</th>
   		</tr>

   		<?php $no = 0;
   		if (mysqli_num_rows($data1) > 0) {
   		 while($data = mysqli_fetch_assoc($data1)) { 
			$data2 = $mysqli->query("SELECT nama_pegawai FROM tbl_pegawai WHERE id_pegawai = '$data[id_pegawai]' ");		
			$as = mysqli_fetch_assoc($data2);


   		 	$no++;?>
   		<tr>
   			<td><?= $no;?></td>
   			<td><?= $as['nama_pegawai'];?></td>
   			<td>Rp. <?= buatRupiah($data['total_harga']);?></td>
   			<td><?= $data['paid_at'];?></td>
   		</tr>
   	<?php }}?>
   	</table>
   </div>
</div>
</body>
