<?php
	require_once("connect.php");
	
	//jika belum login -> kembalikan ke halaman login
	if(!isset($_SESSION["hans_id_pengguna"]))
	{
		?><script>alert('Silahkan login dahulu');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
	else
	{
		session_destroy();
		?><script>alert('Logout sukses');</script><?php
		?><script>document.location.href='index.php';</script><?php
		die(0);
	}
?>