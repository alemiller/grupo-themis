<html>

    <head>
        <title>GRUPO THEMIS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <style>

            @page { size: auto;  margin: 0mm; }

            body {
                height: 842px;
                width: 695px;
                /* to centre page on screen*/
                margin-left: auto;
                margin-right: auto;
                color: #000;
                font-family: 'Roboto', sans-serif;
            }

            p{
                margin: 0px;
                font-weight: bold;
            }

            #constancia{
                width: 100%;
                border: 1px solid #ccc;
                padding: 0px;
                margin-top: 50px;

            }

            .colum-izq{
                width: 50%;
                border-right: 1px solid #ccc;
                text-align: center
            }

            .colum-der{
                width: 50%;
                text-align: center;
                font-family: 'Roboto', sans-serif;
            }

            h1{
                font-size: 18px;
            }

            tr.top-row td{
                border-bottom: 1px solid #ccc; 
            }

            #logo{
                width: 230px;
                height: 100px;
                margin-top: 10px;
            }

            .down_logo{
                width: 90%;
                padding: 5px 0px 20px 10px;
                font-family: 'Roboto', sans-serif;
                font-size: 9px;
                text-align: center;
            }

            #title{
                width: 215px;
                height: 20px;
                margin: 78px 0px 0px 50px;
                font-size: 20px;
                float: left;
                font-family: 'Roboto', sans-serif;
            }

            #encabezado{
                margin: 5px 0px 10px 5px;
                padding: 10px 0px 0px 6px;
                font-family: 'Roboto', sans-serif;
                font-size: 12px;
                float: left;
                color: #000;
                line-height: 28px;
            }

            #detalle{
                width: 95%;
                margin: 5px 0px 20px;
                padding: 0px 10px;
                font-family: 'Roboto', sans-serif;
                font-size: 12px;
                float: left;
                color: #000;
                line-height: 28px;
            }

            td.cliente-detalle{
                border-bottom: 1px solid #ccc;  
            }

            td.detalle-cell{
                border-bottom: 1px solid #ccc;  
            }

            tr.detalle-header th{
                border-bottom: 1px solid #ccc;
            }

            td.border-right, th.border-right{
                border-right: 1px solid #ccc;  
            }

            #firma-content{
                width: 100%;
                margin: 5px 0px 10px;
                padding: 0px 10px;
                font-family: 'Roboto', sans-serif;
                font-size: 12px;
                float: left;
                color: #000;
                line-height: 28px;
            }

            #detalle p{
                margin: 0px;
            }

            #detalle table{
                font-size: 12px;
            }

            #tramites-table{
                width: 100%;
                border: 1px solid #ccc;
            }

            #fecha{
                width: 100%;
                text-align: right;
                padding-right: 40px;
            }

            #firma{
                width: 95%;
                height: 35px;
                border-bottom: 1px solid #ccc;
            }

            #pie{
                margin-top: 20px;
                width: 95%;
                text-align: center;
                font-size: 10px;
                font-weight: initial;

            }


        </style>

    </head>
    <body>
        <table id="constancia">
            <tr class="top-row">
                <td class="colum-izq">
                    <img id="logo" src="http://advncedcdn.vo.llnwd.net/vtt_storage/watchfolder/vtt_admin/logo-email.jpg">
                    <div class="down_logo">
                        Talcahuano 452 9º 36, Ciudad Autónoma de Buenos Aires. Tel: 4373 0739. <br>
                        www.grupo-themis.com.ar - themisgestiones@gmail.com
                    </div>
                </td>
                <td class="colum-der">
                    <h1>CONSTANCIA DE RETIRO</h1>
                    <p>Fecha: <?php echo date('d-m-Y', time()); ?></p>
                </td>
            </tr>
            <tr >
                <td colspan="2" class="cliente-detalle">
                    <div id="encabezado">
                        <p>DETALLE CLIENTE:</p>
                        <table>
                            <tr>
                                <td>
                                    <b>Nro. de cliente:</b> <?php echo $cliente->id; ?>
                                </td>
                                <td style="padding-left:10px;">

                                    <b>Email:</b> <?php echo $cliente->email; ?> 
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Nombre:</b> <?php echo $cliente->nombre; ?>
                                </td>
                                <td style="padding-left:10px;">
                                    <b>Saldo al día de la fecha:</b> $<?php echo $saldo; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr class="detalle-row">
                <td class="detalle-cell" colspan="2">
                    <div id="detalle">
                        <p>DETALLE DE LOS TRAMITES RETIRADOS:</p>
                        <table id="tramites-table">
                            <tr class="detalle-header">
                                <th class="border-right">Trámite Nro.</th>
                                <th class="border-right">Carátula</th>
                                <th class="border-right">Fecha de retiro</th>
                                <th>Valor</th>
                            </tr>
                            <?php
                            for ($i = 0; $i < sizeof($tramites); $i++) {
                                if ($tramites[$i]->fecha_retiro) {
                                    $fecha_retiro = date('d-m-Y', strtotime($tramites[$i]->fecha_retiro));
                                } else {
                                    $fecha_retiro = date('d-m-Y', time());
                                }
                                ?>

                                <tr>
                                    <td class="border-right"><?php echo $tramites[$i]->id; ?></td>
                                    <td class="border-right"><?php echo $tramites[$i]->caratula; ?></td>
                                    <td class="border-right"><?php echo $fecha_retiro; ?></td>
                                    <td><?php echo "$" . (floatval($tramites[$i]->honorarios) + floatval($tramites[$i]->sellado) + floatval($tramites[$i]->honorario_corresponsal)); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="firma-content">
                        <p>FIRMA Y ACLARACION</p>
                        <div id="firma"></div>
                        <p id="pie">Se ha enviado copia de esta constancia al email: <?php echo $cliente->email ?></p>
                    </div>
                </td>
            </tr>
        </table>

    </body>
</html>

