  <meta charset="utf-8">
  <title>Hans Bakery</title>
  
  <!-- included css -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="jquery-ui/jquery-ui.css">
  <link rel="stylesheet" href="datatables/css/dataTables.bootstrap.css">
   <style>
  .ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 200px;
  }
  </style>
  <!-- included javascript -->
  <script src="jquery/jquery.js"></script>
  <script src="bootstrap/js/bootstrap.js"></script>
  <script src="jquery-ui/jquery-ui.js"></script>
  <script src="datatables/js/jquery.dataTables.js"></script>
  <script src="datatables/js/dataTables.bootstrap.js"></script>
  
  <!-- our custom css -->
  <link rel="stylesheet" href="style.css" media="screen">
  <link rel="stylesheet" href="print.css" media="print">
  <script>
  $(function() {
	//kalender
	$(".datepicker").datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
	});
	
	$(".table-sort").DataTable({
		
	});
	
	//$(".not-alphabet")
  });
  </script>