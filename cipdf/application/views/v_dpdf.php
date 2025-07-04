<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<h1>MPDF</h1>
	<h3>Esto es una prueba de mpdf</h3>

	<form action="<?php echo base_url();?>Welcome/descargar" method="POST">
		<input type="text" name="txtPDF"><br>
		<input type="submit" name="btnDownload">
	</form>
</body>
</html>