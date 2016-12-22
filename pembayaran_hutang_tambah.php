<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_pembayaran_hutang = createId("pembayaran_hutang","id_pembayaran_hutang","PH",5);
	$tanggal_pembayaran_hutang = date("Y-m-d");
	$jumlah_pembayaran = 0;
	$id_pembelian_bahan = "";
	$tanggal_pembelian_bahan = date("Y-m-d");
	$id_pemesanan_bahan ="";
	$id_supplier = "";
	$total ="0";
	$jenis_pembayaran = "";
	$id_pengguna = $_SESSION["hans_id_pengguna"];
	$dibayar ="0";
	$tanggal_jatuh_tempo=date("Y-m-d",time()+(30*24*3600));
	$data_id_bahan_baku = array();
	$data_nama_bahan_baku = array();
	$data_jumlah = array();
	$data_id_satuan = array();
	$data_harga = array();
	$data_subtotal = array();
	
		if(isset($_GET["id_pembelian"]))
	{
		$id_pembelian = $_GET["id_pembelian"];
		$query = "select * from pembelian inner join supplier on pembelian.id_supplier=supplier.id_supplier where id_pembelian='$id_pembelian'";
		$result = mysql_query($query);
		if($row = mysql_fetch_array($result))
		{
			
			$id_pembelian = $row["id_pembelian"];
			$id_pemesanan_bahan = $row["id_pemesanan_bahan"];
			$tanggal_pembelian = $row["tanggal_pembelian"];
			$tanggal_jatuh_tempo = $row["tanggal_jatuh_tempo"];
			$id_supplier = $row["id_supplier"];
			$nama_supplier = $row["nama_supplier"];
			$total = $row["total"];
			$dibayar = $row["dibayar"];
			$jenis_pembayaran = $row["jenis_pembayaran"];
	
		}
		else{
			
			?><script>alert("Data tidak ditemukan");</script>
			<script>document.location.href='pembayaran_hutang.php'</script><?php
			die(0);
		}
	}
	else
	{
		?><script>alert("Data tidak ditemukan");</script>
		<script>document.location.href='pembayaran_hutang.php'</script><?php
		die(0);
	}
	
	
	
	if(isset($_POST["simpan"]))
	{
		$id_pembelian = $_POST["id_pembelian"];
		$id_pembayaran_hutang = $_POST["id_pembayaran_hutang"];
		$tanggal_pembayaran_hutang= balikTanggal($_POST["tanggal_pembayaran_hutang"]);
		$jumlah_pembayaran = $_POST["jumlah_pembayaran"];
		$error = 0;
		
		//pengecekan error
		
		
		if($error == 0)
		{
			$query = "insert into pembayaran_hutang(id_pembayaran_hutang,id_pembelian,tanggal_pembayaran_hutang,jumlah_pembayaran) values
							('$id_pembayaran_hutang','$id_pembelian','$tanggal_pembayaran_hutang','$jumlah_pembayaran')";
			mysql_query($query);
			
			$query = "update pembelian set dibayar=dibayar+'$jumlah_pembayaran' where id_pembelian='$id_pembelian'";
			mysql_query($query);
			
			
			?><script>alert("Data berhasil ditambah");</script>
			<script>document.location.href='pembayaran_hutang.php'</script><?php
			die(0);
		}
	}
	
?>
<!doctype html>
<html lang="en">
<head>
	<?php include("head.php"); ?>
	<script>
		$(function(){
		});
	</script>
</head>
<body>
	
	<?php include("header.php"); ?>
	
	<!-- bagian isi -->
	<div class="content container-fluid">
		<h3>Pembelian Bahan</h3>
		<br/>
		<form action="" method="post">
		<div  >
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id Pembayaran Hutang</td>
						<td><input required readonly style="width:150px"; class="form-control" name="id_pembayaran_hutang" id="id_pembayaran_hutang" placeholder="Id Pembayaran" value="<?php echo $id_pembayaran_hutang; ?>" /></td>
					</tr>
					<tr>
						<td>Tanggal Pembayaran</td>
						<td><input style="width: 150px" required class="datepicker form-control" name="tanggal_pembayaran_hutang" id="tanggal_pembayaran_hutang" placeholder="Tanggal Pembayaran Hutang" value="<?php echo balikTanggal($tanggal_pembelian_bahan); ?>" /></td>
					</tr>
					<tr>
						<td >Id Pembelian</td>
						<td><input required readonly style="width:150px"; class="form-control" name="id_pembelian" id="id_pembelian" placeholder="Id Pembelian" value="<?php echo $id_pembelian; ?>" /></td>
					</tr>
					<tr>
						<td>Tanggal Pembelian</td>
						<td><input style="width: 150px" readonly required class=" form-control" name="tanggal_pembelian" id="tanggal_pembelian" placeholder="Tanggal Pembelian" value="<?php echo balikTanggal($tanggal_pembelian_bahan); ?>" /></td>
					</tr>
					<tr>
						<td>Id supplier</td>
						<td><input type="text" readonly style="width:300px";   class="form-control" name="id_supplier" id="id_supplier" value="<?php echo $nama_supplier; ?>"></td>
					</tr>
					<tr class="data_kredit">
						<td>Tanggal Jatuh Tempo</td>
						<td><input style="width: 150px" readonly required class=" form-control" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo" placeholder="Tanggal Jatuh Tempo" value="<?php echo balikTanggal($tanggal_jatuh_tempo); ?>" /></td>
					</tr>
					<tr>
						<td>Total</td>
						<td><input style="width:250px;" required readonly class="form-control" name="total" id="total" placeholder="total " value="<?php echo $total; ?>" /></td>
					</tr>
					<tr>
						<td>Sudah Dibayar</td>
						<td><input style="width:250px;" required readonly class="form-control" name="dibayar" id="dibayar" placeholder="Sudah Dibayar " value="<?php echo $dibayar; ?>" /></td>
					</tr>
					<tr>
						<td>Sisa Hutang</td>
						<td><input style="width:250px;" required readonly class="form-control" name="sisa" id="sisa" placeholder="sisa " value="<?php echo $total-$dibayar; ?>" /></td>
					</tr>
					<tr>
						<td>Jumlah Pembayaran</td>
						<td><input style="width:250px;" min="0" max="<?php echo ($total-$dibayar); ?>" required type="number" class="form-control" name="jumlah_pembayaran" id="jumlah_pembayaran" placeholder="Jumlah Pembayaran " value="<?php echo $jumlah_pembayaran; ?>" /></td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="simpan" class="btn btn-success" onclick="return cekSave();">Simpan</button> 
 							<a href="pembelian.php" class="btn btn-danger">Batal</a>
						</td>
					</tr>
				</tbody>
				<tfoot>	<!-- bagian bawah table -->
				</tfoot>
			</table>
		</div>
		</form>
	</div>
	<!-- akhir bagian isi -->
	

	<?php include("footer.php"); ?>

</body>
</html>