<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$tanggal_awal = date("Y-m-01");
	$tanggal_akhir = date("Y-m-t");
	$id_bahan_baku = "";
	$nama_bahan_baku = "";
	if(isset($_POST["cari"]))
	{
		$tanggal_awal = balikTanggal($_POST["tanggal_awal"]);
		$tanggal_akhir = balikTanggal($_POST["tanggal_akhir"]);
		$id_bahan_baku = $_POST["id_bahan_baku"];
		$nama_bahan_baku = $_POST["nama_bahan_baku"];
	}
?>
<!doctype html>
<html lang="en">
<head>
	<?php include("head.php"); ?>
	<script>
		$(function(){
			
			
			$("#nama_bahan_baku").autocomplete({
				source: function( request, response ) {
					$.ajax({
						url: "ajax_get_bahan_baku.php",
						dataType: "json",
						type: "post",
						data: {
							cari: request.term
						},
						success: function( data ) {
							
							response( $.map( data, function( item ) {
								return {
									label: item.id_bahan_baku + ' - ' + item.nama_bahan_baku,
									value: item.nama_bahan_baku,
									id_bahan_baku: item.id_bahan_baku,
									nama_bahan_baku: item.nama_bahan_baku,
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
						$("#nama_bahan_baku").val("");
						$("#id_bahan_baku").val("");
					}
					else
					{
						$("#id_bahan_baku").val(ui.item.id_bahan_baku);
						$("#nama_bahan_baku").val(ui.item.nama_bahan_baku);
					}
				},
				search: function( event, ui ) {
					
				}
			})
			.blur(function(){
				if($("#id_bahan_baku").val() == "")
				{
					$("#id_bahan_baku").val("");
					$("#nama_bahan_baku").val("");
				}
			})
			.focus(function(){     
				$(this).autocomplete('search', '');
			});
		})
	</script>
</head>
<body>
	
	<?php include("header.php"); ?>
	
	<!-- bagian isi -->
	<div class="content container-fluid">
		<h3>Laporan Kartu Stok Bahan Baku</h3>
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
						<td>Bahan Baku</td>
						<td>
						<input type="text" required readonly style="width:100px; display:inline" placeholder="Id bahan baku"  class="form-control" name="id_bahan_baku" id="id_bahan_baku" value="<?php echo $id_bahan_baku; ?>">
							<input type="text"  style="width:300px; display:inline" placeholder="Cari nama bahan_baku.."  class="form-control" name="nama_bahan_baku" id="nama_bahan_baku" value="<?php echo $nama_bahan_baku; ?>">
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
						<th style="width: 100px;">Tanggal</th>
						<th style="width: 100px;">Keterangan</th>
						<th style="width: 100px;">Jumlah Masuk</th>
						<th style="width: 100px;">Jumlah Keluar</th>
						<th style="width: 100px;">Satuan</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$filter = " where tanggal >= '$tanggal_awal' and tanggal <= '$tanggal_akhir' and view_kartu_stok_bahan_baku.id_bahan_baku='$id_bahan_baku' ";
					$query = "select * from view_kartu_stok_bahan_baku inner join bahan_baku on view_kartu_stok_bahan_baku.id_bahan_baku=bahan_baku.id_bahan_baku
								$filter order by tanggal"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo balikTanggal($row["tanggal"]); ?></td>
						<td><?php echo $row["keterangan"]; ?></td>
						<td style="text-align: right"><?php echo isset($row["masuk"])?number_format($row["masuk"],2,",","."):''; ?></td>
						<td style="text-align: right"><?php echo isset($row["keluar"])?number_format($row["keluar"],2,",","."):''; ?></td>
						<td><?php echo $row["satuan_stok"]; ?></td>
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