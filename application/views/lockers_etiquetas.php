<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Imprimir Etiquetas Lockers</title>
    <style>
        @media print {
            .no-print { display: none; }
            .label-page { page-break-after: always; }
        }
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #eee; }
        .label-container { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 20px; 
            justify-content: center;
        }
        .label-box { 
            background: white; 
            width: 300px; 
            height: 400px; 
            border: 2px solid #000; 
            padding: 20px; 
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .locker-num { 
            font-size: 100px; 
            font-weight: bold; 
            margin: 0;
            line-height: 1;
        }
        .qr-code img {
            width: 180px;
            height: 180px;
        }
        .footer-text { font-size: 12px; color: #555; }
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #00a65a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">
        <i class="fa fa-print"></i> Imprimir Etiquetas
    </button>

    <div class="label-container">
        <?php foreach ($lockers as $l): 
            $public_url = base_url('lockers/ver/' . $l['token']);
            $qr_api = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($public_url);
        ?>
        <div class="label-box">
            <div class="locker-num"><?php echo $l['numero']; ?></div>
            <div class="qr-code">
                <img src="<?php echo $qr_api; ?>" alt="QR Locker <?php echo $l['numero']; ?>">
            </div>
            <div class="footer-text">ESCANEÁ PARA VER ESTADO</div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
