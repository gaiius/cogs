<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	$id_roti2 = "";
	$nama_roti = "";
	if(isset($_POST["cari"]))
	{
		$id_roti2 = $_POST["id_roti2"];
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
						$("#id_roti2").val("");
					}
					else
					{
						$("#id_roti2").val(ui.item.id_roti);
						$("#nama_roti").val(ui.item.nama_roti);
					}
				},
				search: function( event, ui ) {
					
				}
			})
			.blur(function(){
				if($("#id_roti").val() == "")
				{
					$("#id_roti2").val("");
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
		<h3>Laporan Bill of Material</h3>
		<form class="form-inline no-print" action="" method="post">
		  <div class="form-group">
			<label for="id_roti2">Roti</label>
				<input type="text" readonly style="width:100px; display:inline" placeholder="Id roti"  class="form-control" name="id_roti2" id="id_roti2" value="<?php echo $id_roti2; ?>">
				<input type="text"  style="width:300px; display:inline" placeholder="Cari nama roti.."  class="form-control" name="nama_roti" id="nama_roti" value="<?php echo $nama_roti; ?>">
					<span style="color:red"></span>
		  </div>
		  <button type="submit" name="cari" class="btn btn-success">Cari</button>
		</form>
		<br/><br/>
		<button class="btn btn-primary no-print" onclick="window.print()">Cetak</button>
		<br/>
		<br/>
		<div >
		<?php
			$filter = "";
			if($id_roti2 != "")
			{
				$filter=  " where id_roti='$id_roti2'";
			}
			$query = "select * from roti $filter";
			$resultRoti = mysql_query($query);
			while($rowRoti = mysql_fetch_array($resultRoti))
			{
		?>
			<h4>Resep roti <?php echo $rowRoti["nama_roti"]; ?></h4>
			<table class="table table-bordered table-striped table-hover">
				<thead>	<!-- kop table -->
					<tr>
						<th style="width: 100px;">Id Bahan Baku</th>
						<th style="width: 250px;">Nama Bahan Baku</th>
						<th style="width: 100px;">Jumlah Resep</th>
						<th style="width: 100px;">Satuan</th>
					</tr>
				</thead>
				</tbody> <!-- isi table -->
				<?php
					$query = "select * from resep_roti inner join bahan_baku on resep_roti.id_bahan_baku=bahan_baku.id_bahan_baku
								where resep_roti.id_roti='$rowRoti[id_roti]'"; //ambil smua data table satuan
					$result = mysql_query($query); //eksekusi query
					if(mysql_num_rows($result) <= 0)
					{
				?>
				<tr>
					<td colspan="4"><i>Resep belum dimasukkan</i></td>
				</tr>
				<?php
					}
					while($row = mysql_fetch_array($result)) //loop setiap baris data
					{
				?>
					<tr>
						<td><?php echo $row["id_bahan_baku"]; ?></td>
						<td><?php echo $row["nama_bahan_baku"]; ?></td>
						<td><?php echo $row["jumlah_bahan_baku"]; ?></td>
						<td><?php echo $row["satuan_stok"]; ?></td>
					</tr>
				<?php
					}
					
				?>
				</tbody>
				<tfoot>	<!-- bagian bawah table -->
				</tfoot>
			</table>
			<hr/>
		<?php
			}
		?>
		</div>
	</div>
	<!-- akhir bagian isi -->
	

	<?php include("footer.php"); ?>

</body>
</html>