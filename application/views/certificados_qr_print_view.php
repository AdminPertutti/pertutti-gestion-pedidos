<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Imprimir QR - <?php echo $tipo['nombre']; ?></title>
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
      body { text-align: center; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
      .print-container { 
          width: 100%; 
          max-width: 600px; 
          margin: 50px auto; 
          border: 2px solid #333; 
          padding: 40px; 
          border-radius: 10px;
      }
      h1 { font-size: 36px; margin-bottom: 10px; font-weight: bold; }
      h2 { font-size: 24px; margin-bottom: 40px; color: #555; }
      #qrcode { 
          display: flex; 
          justify-content: center; 
          margin: 20px 0; 
      }
      .footer { margin-top: 30px; color: #777; font-size: 14px; }
      @media print {
          .no-print { display: none; }
          .print-container { border: none; margin: 0; width: 100%; }
      }
  </style>
</head>
<body>

<div class="print-container">
    <h1><?php echo $tipo['nombre']; ?></h1>
    <h2>Escanea para ver certificado vigente</h2>
    
    <div id="qrcode"></div>
    
    <div class="footer">
        Pertutti Lomas
    </div>
</div>

<div class="no-print">
    <button onclick="window.print()" class="btn btn-primary btn-lg">Imprimir</button>
    <br><br>
    <a href="javascript:window.close()">Cerrar ventana</a>
</div>

<script type="text/javascript">
var qrcode = new QRCode(document.getElementById("qrcode"), {
    text: "<?php echo base_url('certificados/publico/'.$tipo['id']); ?>",
    width: 300,
    height: 300,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});
</script>

</body>
</html>
