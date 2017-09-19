<html>

    <head>
        <title>GRUPO THEMIS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <style>

            @page { 
                size: auto;  
                margin-top: 5mm; 
                margin-left: 0mm; 
                margin-right: 0mm; 
            }

            .section { margin-top: 200px; }

            body {

                /* to centre page on screen*/
                margin-left: 10px;
                color: #000;
                font-family: 'Roboto', sans-serif;
                font-size: 13px;
            }

            img.barcode{
                height: 70px;
                width: 120px;
            }
            
            .barcode-item{
                width: 120px;
                margin: 0px auto 28px auto;
            }
            
            .barcode-id{
                width: 100%;
                text-align: center;
                margin-bottom: -13px;
            }
            

            .pagebreak { page-break-before: always; } 
        </style>

    </head>
    <body>
        <?php
        for ($i = 0; $i < sizeof($barcodes); $i++) {
            ?>
            <div class="barcode-item">
                <?php
                echo '<img class="barcode" src="data:image/png;base64,' . $barcodes[$i]->barcode . '"><br>' .
                '<div class="barcode-id">'.str_pad($barcodes[$i]->tramite->id, 13, '0', STR_PAD_LEFT) . '</div><br>' .
                'Grupo-Themis.<br>' .
                $barcodes[$i]->tramite->caratula . '<br>' .
                'Ing: ' . date('d-m-Y', strtotime($barcodes[$i]->tramite->fecha_creacion)) . '<br>';
                
                if (($i !== (sizeof($barcodes) - 1)) && (($i+1)%2 === 0)) {
                    
                    echo '<div class="pagebreak section"> </div>';
                }
                ?>
            </div>
            <?php
        }
        ?>
    </body>
</html>

