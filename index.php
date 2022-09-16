<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Uti - Maice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style8.css" rel="stylesheet">

    <style>

        body{

            height:85vh;
            background-image: linear-gradient( to bottom, #f2f2f2, #f2f2f2, rgb(142,227,199), rgb(142,227,199));
            background-repeat:no-repeat;
        }


    </style>    

    <script>
        
        function abreForm1(){
            
            let status = document.getElementById("menuFuncoes").style.display
            
            if (status == "none"){    
                document.getElementById("menuFuncoes").style.display = "block";
            } else{
                document.getElementById("menuFuncoes").style.display = "none";
            }
        }
        
        
    </script>

</head>
<body>

<!--
<a onclick="abreForm1()">Teste</a>

<div id="menuFuncoes">
    <button>Opção 1</button>
    <button>Opção 2</button>
    <button>Opção 3</button>

</div>
-->

  <div id="div1">

        <img id="imgLogotipoLogin" src="imagens/logo maice.png">

        <br><br>

        <form action="valida_login.php" method="post">

            <div class="mb-3">
                <input type="text" name="usuario" class="form-control"  placeholder="Usuário" required>
            </div>        

            <div class="mb-3">
                <input type="password" name="senha" class="form-control" placeholder="Senha" required>
            </div>  

            <button type="submit" class="btn btn-success">Entrar</button>

            <!-- Mensagem de erro ao logar -->
            <?php if(isset($_GET['login']) and $_GET['login'] == 'erro'){?>
                <p id="falhaAutenticar">Acesso negado, tente novamente ou contate o administrador!</p>
            <?php } ?>
        
            <?php if(isset($_GET['login']) and $_GET['login'] == 'erro2'){?>
                <p id="falhaAutenticar">Página restrita, faça seu login antes de acessa-la!</p>
            <?php } ?>

        </form>    

       <br>
       
       <!-- <a href="ressetar_senha.php" class="link-primary">Esqueci minha senha</a> -->



</div>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>