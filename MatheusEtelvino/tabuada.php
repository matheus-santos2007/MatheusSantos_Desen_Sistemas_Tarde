<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabuda</title>
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
           border-style:solid;
           width:50px;
        }
    </style>
</head>
<body>
    <h1 align="center">Matheus Santos</h1>
<table>
    <?php
    
        for ($l=1; $l<=10; $l++)
        {
            echo "<tr>";
            for ($c=1; $c<=10; $c++)
            {
             echo "<td>" . $c . "x". $l . "=" . ($c * $l) . "</td>";

            }
            echo "</tr>";
        }


    ?>
    </table
    
</body>
</html>