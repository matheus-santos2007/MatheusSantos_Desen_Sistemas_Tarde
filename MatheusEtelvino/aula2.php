<html>
    <body>

    
        <?php
        
        echo "<h1 align='center'>Matheus Santos</h1>";
        //Função usada para definir fuso horário pedrão
        date_default_timezone_set('America/Los_Angeles');
        //Manipulando HTML e  PHP
        $data_hoje = date ('d/m/Y', time());

        ?>
        <p align="center">Hoje é dia <?php echo $data_hoje; ?>
        </p>

        <?php
          echo "texto  <br>";
          echo "Olá Mundo <br>";
          echo "Isso abrange várias linhas.As novas linhas serão 
          saída também <br>";
          echo "Isso abrange\nmultiplas linhas. A nova linha será \na saída também <br>";
          echo "Caracteres Escaping são feitos \"Como esse\". <br><br>";
        ?>

        <?php  
          $comida_favorita = 'Italiana';
          print $comida_favorita[2];
          $comida_favorita = "Cozinha ".$comida_favorita;
          echo "<br>";
          print $comida_favorita;
        ?>
    <body>
<html>