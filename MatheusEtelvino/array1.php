<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php  
        $estados = array("PR","SC","RS","SP","RJ","MG","BA","ES","DF");
        echo "ORIGINAL";
        print_r($estados);
        
        echo "<hr/>STRTOLOWER: Converter uma string para minusculo<br/>";
        for ($i = 0; $i < count($estados); $i++) {
            $estados[$i] = strtolower($estados[$i]);
        }
        echo "STRTOLOWER: "; print_r($estados);
        echo "<hr/>SHIFT: Retira o primeiro elemento do array<br/>";
        $rotaciona = array_shift($estados);
        echo "SHIFT: "; print_r($estados);
        echo "<hr/>POP: Extrai um elemento do final do array<br/>";
        array_pop($estados);
        echo "POP: "; print_r($estados);
        echo "<hr/>PUSH: Adiciona um ou mais elemento no final de um array<br/>";
        array_push($estados, "PR"); 
        echo "PUSH: "; print_r($estados);
        echo "<hr/>REVERSE: Retorna um array com os elementos na ordem inversa<br/>";
        $inverso = array_reverse($estados);
        echo "REVERSE: "; print_r($inverso);
        echo "<hr/>SORT: Ordena os elementos de um array<br/>";
        sort($estados);
        echo "SORT: "; print_r($estados);
        echo "<hr/>SORT: Ordena os elementos de um array<br/>";
        sort($estados);
        echo "SORT: "; print_r($estados);
        echo "<hr/>SLICE:Extrai ums parcela de um array<br/>";
        $dividir = array_slice($estados, 1, 2);
        echo "SLICE: "; print_r($dividir); echo "<br/>";
    ?>
</body>
</html>