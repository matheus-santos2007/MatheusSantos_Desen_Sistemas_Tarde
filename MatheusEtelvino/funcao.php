<html>
    
    <body>

        
        <h1 align='center'>Matheus Santos</h1>

        <?php  
            echo $name = "Matheus Santos <br>";
            echo $legth = strlen($name);
            echo $cmp = strcmp($name, "Matheus Santos <br>");
            echo $index = strpos($name, "e");
            echo $first = substr($name, 9, 5);
            echo $name = strtoupper($name);
        ?>

        <?php 
            $cidade = "Joinville";
            $estado = "PR";
            $idade = 325;
            $frase_capital = "A cidade de $cidade é a maior cidade em população de $estado";
            $frase_idade = "A cidade de $cidade tem  mais de $idade anos";
            echo "<h3> $frase_capital </h3>";
            echo "<h4> $frase_idade </h4>";
        ?>

    </body>
</html>