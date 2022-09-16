<?php

        session_start();

        require_once '../../app-evolucao-clinica/conexao.php';
        require_once '../../app-evolucao-clinica/variaveis_e_ips.php';
    
        try{
            
            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'SELECT * FROM datomc22_evolucao_clinica.tb_usuarios';
            
            $stmt = $conexao->prepare($query);
            
            //$stmt->bindValue(':dt_inicio', $_GET['dt_inicio']);
            //$stmt->bindValue(':dt_fim', $_GET['dt_fim']);
            
            //$stmt->bindValue($query);
            
            $stmt->execute();
            
            $usuarios = $stmt->fetchAll();
            
            //return $usuarios;
            //echo print_r($usuarios);

            
        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexexao com o banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();
            
        }
    

        $autentica = false;

        $email = $_POST['usuario'];
        $senha = $_POST['senha'];
        
        
        foreach($usuarios as $user){
            
            if($user['usuario'] == $email and $user['senha'] == $senha and 
            (strpos($ipsAutorizados, $_SERVER['REMOTE_ADDR']) !== false or 
            strpos($ipsAutorizados, $_SERVER['HTTP_CF_CONNECTING_IP']) !== false)){
                
                //echo '<h1>Usuario autenticado!</h1>';
                header('Location: home.php');
                $autentica = true;
                $_SESSION['idUsuario'] = $user['id_usuario'];
                $_SESSION['nomeHospital'] = $user['hospital'];
                $_SESSION['perfilUsuario'] = $user['perfil'];
                $_SESSION['loginUsuario'] = $user['usuario'];
                $_SESSION['senhaUsuario'] = $user['senha'];
            }
                
        }
        
        
         if($email == $loginMaster and $senha == $senhaMaster){
                
                //echo '<h1>Usuario autenticado!</h1>';
                header('Location: home.php');
                $autentica = true;
                $_SESSION['idUsuario'] = 0;
                $_SESSION['nomeHospital'] = $nomeHospital;
                $_SESSION['perfilUsuario'] = 'adm';
                $_SESSION['loginUsuario'] = $loginMaster;
                $_SESSION['senhaUsuario'] = $senhaMaster;
         }
        
        
        if($autentica == false){
                
                //echo '<h1>Acesso negado!</h1>';   
                $_SESSION['userAtenticado'] = 'NAO';
                header('Location: index.php?login=erro');
                exit;
        }else{
            $_SESSION['userAtenticado'] = 'SIM';
        }
        
        
        echo $_SESSION['userAtenticado'];


?>