<html>
    <head>
        <title>Aviso de Pago</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <?php
        $logo_image = $this->config->item('logo_email');
        ?>
        <style>
            header{
                width: 100%;
                border-bottom: 7px solid #1D70B7;
                float: left;
            }

            #logo{
                width: 230px;
                height: 100px;
                margin: 10px 20px;
                background-image: url("<?php echo $logo_image; ?>");
                float: left
            }

            #title{
                width: 215px;
                height: 20px;
                margin: 78px 0px 0px 50px;
                font-size: 20px;
                float: left;
                font-family: 'Roboto', sans-serif;
            }

            #content{
                margin: 5px 30px;
                padding: 10px;
                font-family: 'Roboto', sans-serif;
                font-size: 14px;
                float: left;
                color: #000;
            }

            #fecha{
                width: 100%;
                text-align: right;
                padding-right: 40px;
            }

            #pie-pagina{
                font-size: 12px;
            }

            footer{
                width: 100%;
                padding: 10px;
                border-top: 2px solid #ddd;
                font-family: 'Roboto', sans-serif;
                font-size: 12px;
                float: left;
                text-align: center;

            }
        </style>

    </head>
    <body>
        <header>
            <div id="logo"></div>
            <div id="title">Aviso de Pago realizado</div>
        </header>
        <div id="content">
            <p id="fecha">
                Buenos Aires, <?php echo date('d-m-Y', time()); ?>
            </p>
            <p>                
                Estimado/a <?php echo $cliente->nombre; ?> :<br> 
            </p>

            <p>
                <br>
                Le informamos que en el día de la fecha hemos registrado el pago Nro. <?php echo $pago->id; ?>,
                realizado <?php echo str_replace('Pago ','',$pago->title); ?> <b>por el valor de $<?php echo str_replace('-','',strval($pago->valor)); ?></b>.
            </p>
            <p>
                Cualquier consulta comuniquese al 4373-0739 o por email a <a href="mailto:themisgestiones@gmail.com?Subject=Re:Aviso de trámite finalizado" target="_top">themisgestiones@gmail.com</a> de lunes a viernes de 9 a 16 hs.


            </p>
            <p id="pie-pagina">
                Este email ha sido enviado de manera automática. <b>Por favor NO responder.</b><br> 
            </p>
        </div>
        <footer>
            Talcahuano 452 9º 36, Ciudad Autónoma de Buenos Aires. Tel: 4373 0739. Email: <a href="mailto:themisgestiones@gmail.com?Subject=Re:Aviso de trámite finalizado" target="_top">themisgestiones@gmail.com</a>
        </footer>
    </body>
</html>