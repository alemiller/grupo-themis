<html>

    <head>
        <title>GRUPO THEMIS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <style>

            @page { size: auto;  margin: 0mm; }

            body {

                /* to centre page on screen*/
                margin: 30px 5px 0px 20px;
                color: #000;
                font-family: 'Roboto', sans-serif;
                font-size: 10px;
            }
            
            img.barcode{
                height: 20px;
            }
        </style>

    </head>
    <body>
        <?php
        echo '<img class="barcode" src="data:image/png;base64,' . $barcode . '"><br>' .
        str_pad($tramite->id, 13, '0', STR_PAD_LEFT) . '<br>' .
        'Grupo-Themis. 011 4373 0739<br>' .
        $tramite->caratula . '<br>' .
        'Ing: ' . date('d-m-Y', strtotime($tramite->fecha_creacion)) . '<br>';
        ?>
    </body>
</html>

