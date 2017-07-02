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

        </style>

        <script>
            function allowDrop(ev) {
                ev.preventDefault();
            }

            function drag(ev) {
                ev.dataTransfer.setData("text", ev.target.id);
            }

            function drop(ev) {
                ev.preventDefault();
                var data = ev.dataTransfer.getData("text");
                ev.target.appendChild(document.getElementById(data));
            }
        </script>

    </head>
    <body>
        <?php
        for ($i = 0; $i < sizeof($tramites); $i++) {
            ?>
            <div id="div<?php echo $i; ?>" class="codebar-content" ondrop="drop(event)" ondragover="allowDrop(event)">
            <?php 
            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($tramites[$i]->id, $generator::TYPE_CODE_128)) . '">';
            ?>
            </div>
            <?php
        }
        ?>

    </body>
</html>

