<html>
    <head>
        <title>Aviso de Trámite enviado</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
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
                background-image: url("http://advncedcdn.vo.llnwd.net/vtt_storage/watchfolder/vtt_admin/logo-email.jpg");
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

            #tramites-table{
                width: 100%;
                border: 1px solid #ccc;
            }

            tr.detalle-header th{
                border-bottom: 1px solid #ccc;
            }

            tr.tramite-row td{
                border-bottom: 1px solid #ccc;
            }

            td.border-right, th.border-right{
                border-right: 1px solid #ccc;  
            }

            tr.tramite-row:last-of-type td{
                border-bottom: none;
            }
        </style>

    </head>
    <body>
        <header>
            <div id="logo"></div>
            <div id="title">Trámites enviados</div>
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
                Le informamos que los siguientes trámites han sido enviados:
            </p>
            <table id="tramites-table">
                <tr class="detalle-header">
                    <th class="border-right">Trámite Nro.</th>
                    <th class="border-right">Carátula</th>
                    <th class="border-right">Fecha Envio</th>
                    <th class="border-right">Observaciones</th>
                    <th>Valor</th>
                </tr>
                <?php
                for ($i = 0; $i < sizeof($tramites); $i++) {
                    if ($tramites[$i]->fecha_envio) {
                        $fecha_aviso = date('d-m-Y', strtotime($tramites[$i]->fecha_envio));
                    } else {
                        $fecha_aviso = date('d-m-Y', time());
                    }
                    ?>

                    <tr class="tramite-row">
                        <td class="border-right"><?php echo $tramites[$i]->id; ?></td>
                        <td class="border-right"><?php echo $tramites[$i]->caratula; ?></td>
                        <td class="border-right"><?php echo $fecha_aviso; ?></td>
                        <td class="border-right"><?php echo $tramites[$i]->observaciones_cliente ?></td>
                        <td><?php echo "$" . (floatval($tramites[$i]->honorarios) + floatval($tramites[$i]->sellado) + floatval($tramites[$i]->honorario_corresponsal)); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
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