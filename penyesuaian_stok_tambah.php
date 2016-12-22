<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	
	$id_penyesuaian_stok = createId("penyesuaian_stok","id_penyesuaian_stok","PS",5);
	$tanggal_penyesuaian_stok = date("Y-m-d");
	$id_bahan_baku ="";
	$nama_bahan_baku = "";
	$id_satuan = "";
	$jumlah_penyesuaian ="0";
	$stok = "";
	$id_pengguna = $_SESSION["hans_id_pengguna"];
	
	
	if(isset($_POST["simpan"]))
	{
		$id_penyesuaian_stok = $_POST["id_penyesuaian_stok"];
		$tanggal_penyesuaian_stok = balikTanggal($_POST["tanggal_penyesuaian_stok"]);
		$id_bahan_baku = $_POST["id_bahan_baku"];
		$nama_bahan_baku = $_POST["nama_bahan_baku"];
		$stok = $_POST["stok"];
		$id_satuan = $_POST["id_satuan"];
		$jumlah_penyesuaian = $_POST["jumlah_penyesuaian"];
		$error = 0;
		
		//pengecekan error
		
		
		if($error == 0)
		{
			$query = "insert into penyesuaian_stok(id_penyesuaian_stok,tanggal_penyesuaian_stok,id_bahan_baku,jumlah_penyesuaian,id_pengguna) values 
			('$id_penyesuaian_stok','$tanggal_penyesuaian_stok','$id_bahan_baku','$jumlah_penyesuaian','$id_pengguna')";
			mysql_query($query);
			
			if($jumlah_penyesuaian > 0)
			{
				
				$query = "update bahan_baku set stok=stok+'$jumlah_penyesuaian' where id_bahan_baku='$id_bahan_baku'";
				mysql_query($query);
			}
			else if($jumlah_penyesuaian < 0)
			{
				$jumlah_min = $jumlah_penyesuaian*-1;
				
				$query = "update bahan_baku set stok=stok-'$jumlah_min' where id_bahan_baku='$id_bahan_baku'";
				mysql_query($query);
			}
			
			?><script>alert("Data berhasil ditambah");</script>
			<script>document.location.href='penyesuaian_stok.php'</script><?php
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
									satuan_stok: item.satuan_stok,
									stok: item.stok,
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
						$("#id_satuan").val("");
						$("#stok").val("");
						$("#jumlah_penyesuaian").removeAttr("min");
					}
					else
					{
						$("#id_bahan_baku").val(ui.item.id_bahan_baku);
						$("#nama_bahan_baku").val(ui.item.nama_bahan_baku);
						$("#id_satuan").val(ui.item.satuan_stok);
						$("#stok").val(ui.item.stok);
						minstok = -1*parseFloat(ui.item.stok);
						$("#jumlah_penyesuaian").attr("min",minstok);
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
						$("#id_satuan").val("");
						$("#stok").val("");
						$("#jumlah_penyesuaian").removeAttr("min");
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
		<h3>Penyesuaian Stok</h3>
		<br/>
		<form action="" method="post">
		<div  >
			<table class="table table-bordered table-striped table-hover ">
				<thead>	<!-- kop table -->
				</thead>
				</tbody> <!-- isi table -->
					<tr>
						<td style="width:150px;">Id Penyesuaian</td>
						<td><input required readonly style="width:150px"; class="form-control" name="id_penyesuaian_stok" id="id_penyesuaian_stok" placeholder="Id Roti" value="<?php echo $id_penyesuaian_stok; ?>" /></td>
					</tr>
					<tr>
						<td>Tanggal</td>
						<td><input required style="width:150px"; class="datepicker form-control" name="tanggal_penyesuaian_stok" id="tanggal_penyesuaian_stok" placeholder="Nama Roti" value="<?php echo balikTanggal($tanggal_penyesuaian_stok); ?>" /></td>
					</tr>
					<tr>
						<td>Id bahan baku</td>
						<td>
							<input type="text" required readonly style="width:100px; display:inline" placeholder="Id bahan"  class="form-control" name="id_bahan_baku" id="id_bahan_baku" value="<?php echo $id_bahan_baku; ?>">
							<input type="text"  style="width:300px; display:inline" placeholder="Cari nama bahan baku"  class="form-control" name="nama_bahan_baku" id="nama_bahan_baku" value="<?php echo $nama_bahan_baku; ?>"></td>
					</tr>
					<tr>
						<td>Stok akhir</td>
						<td>
						<input type="text" readonly style="width:120px; display: inline;" class="form-control" id="stok" name="stok" value="<?php echo $stok; ?>" placeholder="Stok" />
						</td>
					</tr>
					<tr>
						<td>Jumlah penyesuaian</td>
						<td><input step=".01"  type="number"  style="width:250px; display: inline;"   class="form-control" name="jumlah_penyesuaian" id="jumlah_penyesuaian" placeholder="Jumlah penyesuaian " value="<?php echo $jumlah_penyesuaian; ?>" />
						<input type="text" readonly style="width:120px; display: inline;" class="form-control" id="id_satuan" name="id_satuan" value="<?php echo $id_satuan; ?>" placeholder="Satuan" />
						</td>
					</tr>
					<tr>
						<td> </td>
						<td>
							<button type="submit" name="simpan" class="btn btn-success" onclick="return cekSave();">Simpan</button> 
 							<a href="penyesuaian_stok.php" class="btn btn-danger">Batal</a>
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