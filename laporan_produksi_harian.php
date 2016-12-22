<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$tanggal_awal = date("Y-m-d");
	$tanggal_akhir = date("Y-m-t");
	$id_roti = "";
	$nama_roti = "";

	if(isset($_POST["cari"]))
	{
		$tanggal_awal = balikTanggal($_POST["tanggal_awal"]);
		$tanggal_akhir = balikTanggal($_POST["tanggal_akhir"]);
		$id_roti = $_POST["id_roti"];
		$nama_roti = $_POST["nama_roti"];
		
	}
?>
<!doctype html>
<html lang="en">
<head>
	<?php include("head.php"); ?>
	
	<script>
		$(function(){
			
			
			$("#nama_roti").autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: "ajax_get_roti.php",
						dataType: "json",
						type: "post",
						data: {
							cari: request.term
						},
						success: function( data ) {
							
							response( $.map( data, function( item ) {
								return {
									label: item.id_roti + ' - ' + item.nama_roti,
									value: item.nama_roti,
									id_roti: item.id_roti,
									nama_roti: item.nama_roti,
								}
							}));
							
						}
					});
				},
				minLength: 0,
				autoFocus: true,
				select: function( event, ui ) {
					if(!ui.item)
					{
						$("#nama_roti").val("");
						$("#id_roti").val("");
					}
					else
					{
						$("#id_roti").val(ui.item.id_roti);
						$("#nama_roti").val(ui.item.nama_roti);
					}
				},
				search: function( event, ui ) {
					
				}
			})
			.blur(function(){
				if($("#nama_roti").val() == "")
				{
					$("#id_roti").val("");
					$("#nama_roti").val("");
				}
			})
			.focus(function(){     
				$(this).autocomplete('search', '');
			});
		});
	</script>
</head>
<body>
	
	<?php include("header.php"); ?>
	
	<!-- bagian isi -->
	<div class="content container-fluid">
		<h3>Laporan Produksi</h3>
		<form action="" method="post">
			<table class="table table-bordered table-striped table-hover ">
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Periode</td>
						<td><input style="width: 150px; display: inline;" required class="datepicker form-control" name="tanggal_awal" id="tanggal_awal" placeholder="Tanggal Awal" value="<?php echo balikTanggal($tanggal_awal); ?>" />
						s/d
						<input style="width: 150px; display: inline;" required class="datepicker form-control" name="tanggal_akhir" id="tanggal_akhir" placeholder="Tanggal Akhir" value="<?php echo balikTanggal($tanggal_akhir); ?>" /></td>
					</tr>
					<tr>
						<td>Roti</td>
						<td>
							<input type="text" required readonly style="width:100px; display:inline" placeholder="Id roti"  class="form-control" name="id_roti" id="id_roti" value="<?php echo $id_roti; ?>">
							<input type="text"  style="width:300px; display:inline" placeholder="Cari nama roti"  class="form-control" name="nama_roti" id="nama_roti" value="<?php echo $nama_roti; ?>">
							* kosong = semua roti
						
						</td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="cari" class="btn btn-success">Cari</button> 
						</td>
					</tr>
				</tbody>
				<tfoot>	<!-- bagian bawah table -->
				</tfoot>
			</table>	
		</form>
		
		<button class="btn btn-primary no-print" onclick="window.print()">Cetak</button>
		<br/>
		<br/>
		<div >
			<table class="table table-bordered table-striped table-hover">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Produksi</th>
						<th style="width: 100px;">Tanggal Produksi</th>
						<th style="width: 100px;">Roti</th>
						<th style="width: 100px;">Jumlah Produksi</th>
						<th style="width: 100px;">Total HPP</th>
						<th style="width: 100px;">HPP / Roti</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$filter = " where tanggal_produksi >= '$tanggal_awal' and tanggal_produksi <= '$tanggal_akhir'  ";
					if($id_roti != "")
					{
						$filter .= " and detail_produksi.id_roti='$id_roti'";
					}
					$query = "select * from produksi 
								
									inner join detail_produksi on produksi.id_produksi=detail_produksi.id_produksi
									inner join roti on detail_produksi.id_roti=roti.id_roti $filter"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_produksi"]; ?></td>
						<td><?php echo balikTanggal($row["tanggal_produksi"]); ?></td>
						<td><?php echo $row["nama_roti"]; ?></td>
						<td style="text-align: right"><?php echo number_format($row["jumlah"],2,",","."); ?></td>
						<td style="text-align: right"><?php echo number_format($row["total_hpp"],2,",","."); ?></td>
						<td style="text-align: right"><?php echo number_format($row["total_hpp"]/$row["jumlah"],2,",","."); ?></td>
					</tr>
				<?php
					}
					
				?>
				</tbody>
				<tfoot>	<!-- bagian bawah table -->
				</tfoot>
			</table>
		</div>
	</div>
	<!-- akhir bagian isi -->
	

	<?php include("footer.php"); ?>

</body>
</html>