<?php

    date_default_timezone_set('America/Sao_Paulo');
    error_reporting(0);

    // -------------------------- FUNCOES ------------------------------ //

    function consulta_leitos(){

        require_once '../../app-evolucao-clinica/conexao.php';

        try{
            
            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'SELECT * FROM tb_leitos';
            
            $stmt = $conexao->prepare($query);
            
            $stmt->execute();
            
            $leitos = $stmt->fetchAll();
            
            return $leitos;

            
        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexexao com o banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();
            
        }

    }


    function verifica_ocupacao_leito(){
        
        require_once '../../app-evolucao-clinica/conexao.php';

        try{
            
            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'SELECT
                    a.id_internacao as id_internacao, 
                    a.nome_paciente as nome_paciente,
                    a.sexo as sexo,
                    a.dt_nascimento as dt_nascimento,
                    a.convenio as convenio,
                    a.dt_internacao as dt_internacao,
                    a.peso as peso,
                    a.saps3 as saps3,
                    b.id_internacao as id_lista_problemas,
                    b.texto as texto_listaProblemas,
                    c.id_internacao as id_infusoes,
                    c.texto as texto_infusoes,
                    d.id_internacao as id_sinaisVitais,
                    d.texto as texto_sinaisVitais,  
                    e.id_internacao as id_balancoHidrico,
                    e.texto as texto_balancoHidrico, 
                    f.id_internacao as id_nutricional,
                    f.texto as texto_nutricional,  
                    g.id_internacao as id_ventilacao,
                    g.texto as texto_ventilacao,  
                    h.id_internacao as id_gasometria,
                    h.texto as texto_gasometria,  
                    i.id_internacao as id_culturas,
                    i.texto as texto_culturas,  
                    j.id_internacao as id_examesRelevantes,
                    j.texto as texto_examesRelevantes,  
                    k.id_internacao as id_evolucaoClinicaDiaria,
                    k.texto as texto_evolucaoClinicaDiaria,  
                    l.id_internacao as id_conduta,
                    l.texto as texto_conduta,
                    m.id_internacao as id_laboratorial,
                    m.texto as texto_laboratorial
                     
                    FROM tb_internacao_paciente a
                    
                    left join tb_lista_problemas b on a.id_internacao = b.id_internacao
                    left join tb_infusoes c on a.id_internacao = c.id_internacao
                    left join tb_sinais_vitais d on a.id_internacao = d.id_internacao
                    left join tb_balanco_hidrico e on a.id_internacao = e.id_internacao
                    left join tb_nutricional f on a.id_internacao = f.id_internacao
                    left join tb_ventilacao g on a.id_internacao = g.id_internacao
                    left join tb_gasometria h on a.id_internacao = h.id_internacao
                    left join tb_culturas i on a.id_internacao = i.id_internacao
                    left join tb_exames_relevantes j on a.id_internacao = j.id_internacao
                    left join tb_evolucao_clinica_diaria k on a.id_internacao = k.id_internacao
                    left join tb_conduta l on a.id_internacao = l.id_internacao
                    left join tb_laboratorial m on a.id_internacao = m.id_internacao
                     
                    WHERE a.leito = ' . '"' . $_GET["NomeLeito"] . '"' . ' AND a.status_paciente = "internado"';
            
            $stmt = $conexao->prepare($query);
            
            $stmt->execute();
            
            $leitosOcupados = $stmt->fetchAll();
            
            $campos = array('id_internacao', 'nome_paciente', 'sexo','dt_nascimento','convenio','dt_internacao', 'peso', 
                            'saps3','id_lista_problemas','id_infusoes','id_sinaisVitais',
                            'id_balancoHidrico','id_nutricional','id_ventilacao','id_gasometria',
                            'id_culturas','id_examesRelevantes','id_evolucaoClinicaDiaria','id_conduta','id_laboratorial',
                            'texto_listaProblemas','texto_infusoes','texto_sinaisVitais','texto_balancoHidrico',
                            'texto_nutricional','texto_ventilacao','texto_gasometria','texto_culturas',
                            'texto_examesRelevantes','texto_evolucaoClinicaDiaria','texto_conduta','texto_laboratorial');

            for($i = 0; $i <= count($campos) + 1; $i++){
                
                if($leitosOcupados[0][$campos[$i]] != '0000-00-00' and
                  $leitosOcupados[0][$campos[$i]] != '' and
                  //$leitosOcupados[0][$campos[$i]] != 0 and <---- NAO FUNCIONA NO SERVIDOR
                  $leitosOcupados[0][$campos[$i]] != '0' and
                  $leitosOcupados[0][$campos[$i]] != null and
                  $campos[$i] != 'dt_nascimento' and
                  $campos[$i] != 'dt_internacao'){

                    $resultCampos = $resultCampos . ' <' . $campos[$i] . '>' . $leitosOcupados[0][$campos[$i]] . '</' . $campos[$i] . '>';
                    
                }elseif($leitosOcupados[0][$campos[$i]] != '0000-00-00' and
                        $leitosOcupados[0][$campos[$i]] != '' and
                        //$leitosOcupados[0][$campos[$i]] != 0 and <---- NAO FUNCIONA NO SERVIDOR
                        $leitosOcupados[0][$campos[$i]] != '0' and
                        $leitosOcupados[0][$campos[$i]] != null and
                        ($campos[$i] == 'dt_nascimento' or 
                        $campos[$i] == 'dt_internacao')){

                    //$resultCampos = $resultCampos . ' <' . $campos[$i] . '>' . date("d/m/Y",strtotime($leitosOcupados[0][$campos[$i]])) . '</' . $campos[$i] . '>';
                    $resultCampos = $resultCampos . ' <' . $campos[$i] . '>' . $leitosOcupados[0][$campos[$i]] . '</' . $campos[$i] . '>';
                    
                }

            }
                //Dias de UTI
                if($leitosOcupados[0]['dt_internacao'] != '0000-00-00'){
                    $diferencaDiasUti = strtotime(date("Y-m-d")) - strtotime($leitosOcupados[0]['dt_internacao']);
                    $diasUti = floor($diferencaDiasUti / (60 * 60 * 24));
                    $resultCampos = $resultCampos . '<diasUti>' . $diasUti . '</diasUti>';
                }

                //Idade
                if($leitosOcupados[0]['dt_nascimento'] != '0000-00-00'){
                    $dataNascimento = $leitosOcupados[0]['dt_nascimento'];
                    $data = new DateTime($dataNascimento );
                    $idade = $data->diff( new DateTime( date('Y-m-d') ) );
                    $resultCampos = $resultCampos . '<idade>' . $idade->format( '%Y anos' ) . '</idade>';
                }

            
            
            
            
            echo $resultCampos;

            
        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexexao ao tentar verificar ocupação dos leitos no banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();
            
        }      
    }


    function trocarLeitos_update(){

        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'UPDATE tb_internacao_paciente SET
                     leito = :leito
                     WHERE id_internacao = :id_internacao';
                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_internacao', $_GET['id_internacao']);
            $stmt->bindValue(':leito', $_GET['leito']);
            
            $stmt->execute();
            
            echo 'Sucesso ao atualizar!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar atualizar a Troca de Leitos no banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }
    }


    function darAltaObito_update(){
        
        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'UPDATE tb_internacao_paciente SET
                     status_paciente = :status_paciente
                     WHERE id_internacao = :id_internacao';
                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_internacao', $_GET['id_internacao']);
            $stmt->bindValue(':status_paciente', $_GET['status_paciente']);
            
            $stmt->execute();
            
            echo 'Sucesso ao atualizar!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar atualizar a Alta/Obito no banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }
    }


    function consulta_invasoes(){
        
        require_once '../../app-evolucao-clinica/conexao.php';

        try{
            
            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'SELECT

                    a.id_invasao,
                    a.id_internacao,
                    a.invasao,
                    a.dt_inicio,
                    a.dt_termino,
                    a.observacoes,
                    b.leito

                    FROM tb_invasoes a

                    LEFT JOIN tb_internacao_paciente b on a.id_internacao = b.id_internacao
                     
                    WHERE a.id_internacao = ' . '"' . $_GET["id_internacao"] . '"' .
                    
                    'ORDER BY a.dt_termino ASC, a.dt_inicio DESC';
            
            $stmt = $conexao->prepare($query);
            
            $stmt->execute();
            
            $arrInvasoes = $stmt->fetchAll();
            
            //$campos = array('id_invasao', 'id_internacao', 'invasao','dt_inicio','dt_termino', 'observacoes');

            //for($i = 0; $i <= count($campos) + 1; $i++){
            foreach($arrInvasoes as $arrVal){
                $id = $arrVal['id_invasao'];
                $invasao =  $arrVal['invasao'];
                $dtIni = $arrVal['dt_inicio'];
                $dtFim = $arrVal['dt_termino'];
                $obs = $arrVal['observacoes'];
                $leito = $arrVal['leito'];
                $e = "'" . 'externo' . "'";

                if($dtIni <> '0000-00-00' and $dtFim <> '0000-00-00'){

                    $diferenca = strtotime($dtFim) - strtotime($dtIni);
                    $tempoDeDroga = floor($diferenca / (60 * 60 * 24));

                    $texto =
                    $invasao . '(DI: ' . date("d/m", strtotime($dtIni)) . 
                    ', DT: ' . date("d/m", strtotime($dtFim)) . ', ' . $tempoDeDroga .
                    'd)  ' . $obs;
                }elseif($dtIni <> '0000-00-00' and $dtFim = '0000-00-00'){
                    
                    $diferenca = strtotime(date('Y-m-d')) - strtotime($dtIni);
                    $tempoDeDroga = floor($diferenca / (60 * 60 * 24));

                    $texto = '<b>' .
                    $invasao . ' D' . $tempoDeDroga . '(DI: ' . date("d/m", strtotime($dtIni)) . 
                    ')  ' . $obs . '</b>';
                    
                }elseif($dtIni = '0000-00-00' and $dtFim <> '0000-00-00'){
                    
                    $texto =
                    $invasao . ' (DT: ' . date("d/m", strtotime($dtFim)) . 
                    ')  ' . $obs;

                }elseif($dtIni = '0000-00-00' and $dtFim = '0000-00-00'){
                    
                    $texto = '<b>' .
                    $invasao . ' ' . $obs . '</b>';
                
                }else{
                    $texto = 
                    $invasao . '(DI: ' . date("d/m", strtotime($dtIni)) . 
                    ', DT: ' . date("d/m", strtotime($dtFim)) . 
                    ')  ' . $obs;
                }

                $resultCampos = $resultCampos . 
                '-<a class="divInvasao" onclick="abreModalInvasao(' . 
                 $id . ',' .
                "'" . $invasao .  "'" .  ',' .
                "'" . $dtIni .  "'" .  ',' . 
                "'" . $dtFim .  "'" .  ',' .
                "'" . $obs .  "'" .  ',' . 
                "'" . $leito .  "'" .  ',' . 
                 $e . ')">' . $texto . '</a></br>';
            }

            $diferenca = strtotime($arrInvasoes[0]['dt_termino']) - strtotime($arrInvasoes[0]['dt_inicio']);
            $dias = floor($diferenca / (60 * 60 * 24)); 

            //$resultCampos = $resultCampos . '<diasUti>' . $dias . '</diasUti>';
            echo $resultCampos;

            
        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexexao ao tentar verificar ocupação dos leitos no banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();
            
        }      
    }


    function invasoes_delete(){
        require_once '../../app-evolucao-clinica/conexao.php';

        try{
            
            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'DELETE FROM tb_invasoes WHERE id_invasao = ' . $_GET["id_invasao"];
            
            $stmt = $conexao->prepare($query);
            
            $stmt->execute();
            

            
        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexexao ao tentar DELETAR AS INVASOES NO BANCO DE DADOS! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();
            
        }
    }

    function invasoes_insert(){

        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);

            $query = 'INSERT INTO tb_invasoes
            (id_invasao,id_internacao,invasao,dt_inicio,dt_termino,observacoes,status,id_usuario_editor,dt_hr_inicio_edicao)
            values 
            (:id_invasao,:id_internacao,:invasao,:dt_inicio,:dt_termino,:observacoes,:status,:id_usuario_editor,:dt_hr_inicio_edicao)';

                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_invasao', $_GET['id_invasao']);
            $stmt->bindValue(':id_internacao', $_GET['id_internacao']);
            $stmt->bindValue(':invasao', $_GET['invasao']);
            $stmt->bindValue(':dt_inicio', $_GET['dt_inicio']);
            $stmt->bindValue(':dt_termino', $_GET['dt_termino']);
            $stmt->bindValue(':observacoes', $_GET['observacoes']);
            $stmt->bindValue(':status', 'livre');
            $stmt->bindValue(':id_usuario_editor', '');
            $stmt->bindValue(':dt_hr_inicio_edicao', '');
            
            $stmt->execute();
            
            echo 'Sucesso ao atualizar!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar atualizar no banco de dados(Infusões)! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }
    }

    function invasoes_update(){

        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'UPDATE tb_invasoes SET
                    id_invasao = :id_invasao,
                    id_internacao = :id_internacao,
                    invasao = :invasao,
                    dt_inicio = :dt_inicio,
                    dt_termino = :dt_termino,
                    observacoes = :observacoes,
                    status = :status,
                    id_usuario_editor = :id_usuario_editor,
                    dt_hr_inicio_edicao = :dt_hr_inicio_edicao
                    WHERE id_invasao = :id_invasao';
                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_invasao', $_GET['id_invasao']);
            $stmt->bindValue(':id_internacao', $_GET['id_internacao']);
            $stmt->bindValue(':invasao', $_GET['invasao']);
            $stmt->bindValue(':dt_inicio', $_GET['dt_inicio']);
            $stmt->bindValue(':dt_termino', $_GET['dt_termino']);
            $stmt->bindValue(':observacoes', $_GET['observacoes']);
            $stmt->bindValue(':status', 'livre');
            $stmt->bindValue(':id_usuario_editor', '');
            $stmt->bindValue(':dt_hr_inicio_edicao', '');
            
            $stmt->execute();
            
            echo 'Sucesso ao atualizar!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar atualizar no banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }
    }


    function consulta_antibioticos(){
        
        require_once '../../app-evolucao-clinica/conexao.php';

        try{
            
            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'SELECT

                    a.id_antibiotico,
                    a.id_internacao,
                    a.antibiotico,
                    a.dt_inicio,
                    a.dt_termino,
                    a.observacoes,
                    b.leito

                    FROM tb_antibioticos_tratamentos a

                    LEFT JOIN tb_internacao_paciente b on a.id_internacao = b.id_internacao
                     
                    WHERE a.id_internacao = ' . '"' . $_GET["id_internacao"] . '"' .
                    
                    'ORDER BY a.dt_termino ASC, a.dt_inicio DESC';
            
            $stmt = $conexao->prepare($query);
            
            $stmt->execute();
            
            $arrAntibioticos = $stmt->fetchAll();
            
            //$campos = array('id_invasao', 'id_internacao', 'invasao','dt_inicio','dt_termino', 'observacoes');

            //for($i = 0; $i <= count($campos) + 1; $i++){
            foreach($arrAntibioticos as $arrVal){
                $id = $arrVal['id_antibiotico'];
                $antibiotico =  $arrVal['antibiotico'];
                $dtIni = $arrVal['dt_inicio'];
                $dtFim = $arrVal['dt_termino'];
                $obs = $arrVal['observacoes'];
                $leito = $arrVal['leito'];
                $e = "'" . 'externo' . "'";


                if($dtIni <> '0000-00-00' and $dtFim <> '0000-00-00'){

                    $diferenca = strtotime($dtFim) - strtotime($dtIni);
                    $tempoDeDroga = floor($diferenca / (60 * 60 * 24));

                    $texto =
                    $antibiotico . '(DI: ' . date("d/m", strtotime($dtIni)) . 
                    ', DT: ' . date("d/m", strtotime($dtFim)) . ', ' . $tempoDeDroga .
                    'd)  ' . $obs;
                }elseif($dtIni <> '0000-00-00' and $dtFim = '0000-00-00'){
                    
                    $diferenca = strtotime(date('Y-m-d')) - strtotime($dtIni);
                    $tempoDeDroga = floor($diferenca / (60 * 60 * 24));

                    $texto = '<b>' .
                    $antibiotico . ' D' . $tempoDeDroga . '(DI: ' . date("d/m", strtotime($dtIni)) . 
                    ')  ' . $obs . '</b>';
                    
                }elseif($dtIni = '0000-00-00' and $dtFim <> '0000-00-00'){
                    
                    $texto =
                    $antibiotico . ' (DT: ' . date("d/m", strtotime($dtFim)) . 
                    ')  ' . $obs;

                }elseif($dtIni = '0000-00-00' and $dtFim = '0000-00-00'){
                    
                    $texto = '<b>' .
                    $antibiotico . ' ' . $obs . '</b>';
                    
                }else{
                    $texto = 
                    $antibiotico . '(DI: ' . date("d/m", strtotime($dtIni)) . 
                    ', DT: ' . date("d/m", strtotime($dtFim)) . 
                    ')  ' . $obs;
                }

                $resultCampos = $resultCampos . 
                '-<a class="divAntibiotico" onclick="abreModalAntibiotico(' . 
                 $id . ',' .
                "'" . $antibiotico .  "'" .  ',' .
                "'" . $dtIni .  "'" .  ',' . 
                "'" . $dtFim .  "'" .  ',' .
                "'" . $obs .  "'" .  ',' . 
                "'" . $leito .  "'" .  ',' . 
                 $e . ')">' . $texto . '</a></br>';
            }

            $diferenca = strtotime($arrInvasoes[0]['dt_termino']) - strtotime($arrInvasoes[0]['dt_inicio']);
            $dias = floor($diferenca / (60 * 60 * 24)); 

            //$resultCampos = $resultCampos . '<diasUti>' . $dias . '</diasUti>';
            echo $resultCampos;

            
        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexexao ao tentar verificar ocupação dos leitos no banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();
            
        }      
    }

    function antibioticos_delete(){
        require_once '../../app-evolucao-clinica/conexao.php';

        try{
            
            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'DELETE FROM tb_antibioticos_tratamentos WHERE id_antibiotico = ' . $_GET["id_antibiotico"];
            
            $stmt = $conexao->prepare($query);
            
            $stmt->execute();
            

            
        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexexao ao tentar DELETAR os antibioticos no BANCO DE DADOS! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();
            
        }
    }

    function antibioticos_insert(){

        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);

            $query = 'INSERT INTO tb_antibioticos_tratamentos
            (id_antibiotico,id_internacao,antibiotico,dt_inicio,dt_termino,observacoes,status,id_usuario_editor,dt_hr_inicio_edicao)
            values 
            (:id_antibiotico,:id_internacao,:antibiotico,:dt_inicio,:dt_termino,:observacoes,:status,:id_usuario_editor,:dt_hr_inicio_edicao)';

                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_antibiotico', $_GET['id_antibiotico']);
            $stmt->bindValue(':id_internacao', $_GET['id_internacao']);
            $stmt->bindValue(':antibiotico', $_GET['antibiotico']);
            $stmt->bindValue(':dt_inicio', $_GET['dt_inicio']);
            $stmt->bindValue(':dt_termino', $_GET['dt_termino']);
            $stmt->bindValue(':observacoes', $_GET['observacoes']);
            $stmt->bindValue(':status', 'livre');
            $stmt->bindValue(':id_usuario_editor', '');
            $stmt->bindValue(':dt_hr_inicio_edicao', '');
            
            $stmt->execute();
            
            echo 'Sucesso ao atualizar!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar atualizar no banco de dados(Antibioticos)! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }
    }

    function antibioticos_update(){

        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'UPDATE tb_antibioticos_tratamentos SET
                    id_antibiotico = :id_antibiotico,
                    id_internacao = :id_internacao,
                    antibiotico = :antibiotico,
                    dt_inicio = :dt_inicio,
                    dt_termino = :dt_termino,
                    observacoes = :observacoes,
                    status = :status,
                    id_usuario_editor = :id_usuario_editor,
                    dt_hr_inicio_edicao = :dt_hr_inicio_edicao
                    WHERE id_antibiotico = :id_antibiotico';
                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_antibiotico', $_GET['id_antibiotico']);
            $stmt->bindValue(':id_internacao', $_GET['id_internacao']);
            $stmt->bindValue(':antibiotico', $_GET['antibiotico']);
            $stmt->bindValue(':dt_inicio', $_GET['dt_inicio']);
            $stmt->bindValue(':dt_termino', $_GET['dt_termino']);
            $stmt->bindValue(':observacoes', $_GET['observacoes']);
            $stmt->bindValue(':status', 'livre');
            $stmt->bindValue(':id_usuario_editor', '');
            $stmt->bindValue(':dt_hr_inicio_edicao', '');
            
            $stmt->execute();
            
            echo 'Sucesso ao atualizar!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar atualizar no banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }
    }




    function btnConfirmCadastro_insert(){
        
        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'INSERT INTO tb_internacao_paciente 
                    (id_internacao,nome_paciente,sexo,dt_nascimento,convenio,peso,saps3,leito,dt_admissao,dt_internacao,
                    status_paciente,dt_alta_obito,status,id_usuario_editor,dt_hr_inicio_edicao) 
                     values 
                     (:id_internacao,:nome_paciente,:sexo,:dt_nascimento,:convenio,:peso,:saps3,:leito,:dt_admissao,:dt_internacao,
                    :status_paciente,:dt_alta_obito,:status,:id_usuario_editor,:dt_hr_inicio_edicao)';
                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_internacao', '');
            $stmt->bindValue(':nome_paciente', $_GET['nome']);
            $stmt->bindValue(':sexo', $_GET['sexo']);
            $stmt->bindValue(':dt_nascimento', $_GET['dt_nascimento']);
            $stmt->bindValue(':convenio', $_GET['convenio']);
            $stmt->bindValue(':peso', $_GET['peso']);
            $stmt->bindValue(':saps3', $_GET['saps3']);
            $stmt->bindValue(':leito', $_GET['NomeLeito']);
            $stmt->bindValue(':dt_admissao', $_GET['dt_internacao']); //Verificar
            $stmt->bindValue(':dt_internacao', $_GET['dt_internacao']);
            $stmt->bindValue(':status_paciente', 'internado');
            $stmt->bindValue(':dt_alta_obito', '');
            $stmt->bindValue(':status', 'livre');
            $stmt->bindValue(':id_usuario_editor', '');
            $stmt->bindValue(':dt_hr_inicio_edicao', '');
            
            $stmt->execute();
            
            echo 'Sucesso ao inserir!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar inserir no banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }

    }



    function btnConfirmCadastro_update(){
        
        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'UPDATE tb_internacao_paciente SET
                     nome_paciente = :nome_paciente,
                     sexo = :sexo,
                     dt_nascimento = :dt_nascimento,
                     convenio = :convenio,
                     peso = :peso,
                     saps3 = :saps3,
                     leito = :leito,
                     dt_admissao = :dt_admissao,
                     dt_internacao = :dt_internacao,
                     status_paciente = :status_paciente,
                     dt_alta_obito = :dt_alta_obito,
                     status = :status,
                     id_usuario_editor = :id_usuario_editor,
                     dt_hr_inicio_edicao = :dt_hr_inicio_edicao
                     WHERE id_internacao = :id_internacao';
                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_internacao', $_GET['id_internacao']);
            $stmt->bindValue(':nome_paciente', $_GET['nome']);
            $stmt->bindValue(':sexo', $_GET['sexo']);
            $stmt->bindValue(':dt_nascimento', $_GET['dt_nascimento']);
            $stmt->bindValue(':convenio', $_GET['convenio']);
            $stmt->bindValue(':peso', $_GET['peso']);
            $stmt->bindValue(':saps3', $_GET['saps3']);
            $stmt->bindValue(':leito', $_GET['NomeLeito']);
            $stmt->bindValue(':dt_admissao', $_GET['dt_internacao']); //Verificar
            $stmt->bindValue(':dt_internacao', $_GET['dt_internacao']);
            $stmt->bindValue(':status_paciente', 'internado');
            $stmt->bindValue(':dt_alta_obito', '');
            $stmt->bindValue(':status', 'livre');
            $stmt->bindValue(':id_usuario_editor', '');
            $stmt->bindValue(':dt_hr_inicio_edicao', '');
            
            $stmt->execute();
            
            echo 'Sucesso ao atualizar!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar atualizar no banco de dados! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }

    }



    function camposLivres_insert($tabela){
        
        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);

            $query = 'INSERT INTO ' . $tabela .
            ' (id_internacao,texto,status,id_usuario_editor,dt_hr_inicio_edicao) 
            values 
            (:id_internacao,:texto,:status,:id_usuario_editor,:dt_hr_inicio_edicao)';

                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_internacao', $_GET['id_internacao']);
            $stmt->bindValue(':texto', $_GET['texto']);
            $stmt->bindValue(':status', 'livre');
            $stmt->bindValue(':id_usuario_editor', '');
            $stmt->bindValue(':dt_hr_inicio_edicao', '');
            
            $stmt->execute();
            
            echo 'Sucesso ao atualizar!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar atualizar no banco de dados(Campos de texto)! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $tabela . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }

    }


    function camposLivres_update($tabela){
        
        require_once '../../app-evolucao-clinica/conexao.php';

        try{

            $conexao = new PDO($dsn,$usuario,$senha);
            
            $query = 'UPDATE ' . $tabela . ' SET
                     id_internacao = :id_internacao,
                     texto = :texto,
                     status = :status,
                     id_usuario_editor = :id_usuario_editor,
                     dt_hr_inicio_edicao = :dt_hr_inicio_edicao
                     WHERE id_internacao = :id_internacao';
                
            $stmt = $conexao->prepare($query);
            
            $stmt->bindValue(':id_internacao', $_GET['id_internacao']);
            $stmt->bindValue(':texto', nl2br($_GET['texto']));
            $stmt->bindValue(':status', 'livre');
            $stmt->bindValue(':id_usuario_editor', '');
            $stmt->bindValue(':dt_hr_inicio_edicao', '');
            
            $stmt->execute();
            
            echo 'Sucesso ao atualizar!!';

        } catch(PDOException $e){
            
            //Mostra erro caso falhe a conexao
            echo 'Falha na conexao ao tentar atualizar no banco de dados(Campos de texto)! Tente novamente mais tarde.' . '</br>';
            echo 'Erro: ' . $tabela . $e->getCode() . '</br>Mensagem: ' . $e->getMessage();

        }

    }




    // -------------------== CONDICOES PARA EXECUTAR AS FUNCOES ----------------------------

    //Cadastro - Editar e Atualizar
    if($_GET['btnConfirmCad'] == 'update'){

        btnConfirmCadastro_update();
        
    }elseif($_GET['btnConfirmCad'] == 'insert'){

        btnConfirmCadastro_insert();

    }

    //Cadastro - Botao Novo
    if($_GET['btnNovoCad'] == 'select'){

        verifica_ocupacao_leito();


    }

    //Campos de Texto Livre    
    if($_GET['txt_listaProblemas'] == 'insert'){ //Lista de Problemas
        //txtListaProblemas_insert();
        camposLivres_insert('tb_lista_problemas');
    }elseif($_GET['txt_listaProblemas'] == 'update'){
        //txtListaProblemas_update();
        camposLivres_update('tb_lista_problemas');
    
    }elseif($_GET['txt_infusoes'] == 'insert'){ //Infusoes
        //txtInfusoes_insert();
        camposLivres_insert('tb_infusoes');
    }elseif($_GET['txt_infusoes'] == 'update'){
        //txtInfusoes_update();
        camposLivres_update('tb_infusoes');
    
    }elseif($_GET['txt_sinaisVitais'] == 'insert'){ //Sinais Vitais
        camposLivres_insert('tb_sinais_vitais');
    }elseif($_GET['txt_sinaisVitais'] == 'update'){
        camposLivres_update('tb_sinais_vitais');
    
    }elseif($_GET['txt_balancoHidrico'] == 'insert'){ //Balanco Hidrico
        camposLivres_insert('tb_balanco_hidrico');
    }elseif($_GET['txt_balancoHidrico'] == 'update'){
        camposLivres_update('tb_balanco_hidrico');
    
    }elseif($_GET['txt_nutricional'] == 'insert'){ //Nutricional
        camposLivres_insert('tb_nutricional');
    }elseif($_GET['txt_nutricional'] == 'update'){
        camposLivres_update('tb_nutricional');
    
    }elseif($_GET['txt_ventilacao'] == 'insert'){ //Ventilacao
        camposLivres_insert('tb_ventilacao');
    }elseif($_GET['txt_ventilacao'] == 'update'){
        camposLivres_update('tb_ventilacao');
    
    }elseif($_GET['txt_gasometria'] == 'insert'){ //Gasometria
        camposLivres_insert('tb_gasometria');
    }elseif($_GET['txt_gasometria'] == 'update'){
        camposLivres_update('tb_gasometria');
    
    }elseif($_GET['txt_culturas'] == 'insert'){ //Culturas
        camposLivres_insert('tb_culturas');
    }elseif($_GET['txt_culturas'] == 'update'){
        camposLivres_update('tb_culturas');
    
    }elseif($_GET['txt_examesRelevantes'] == 'insert'){ //Exames Relevantes
        camposLivres_insert('tb_exames_relevantes');
    }elseif($_GET['txt_examesRelevantes'] == 'update'){
        camposLivres_update('tb_exames_relevantes');
    
    }elseif($_GET['txt_evolucaoClinicaDiaria'] == 'insert'){ //Evolucao CLinica Diaria
        camposLivres_insert('tb_evolucao_clinica_diaria');
    }elseif($_GET['txt_evolucaoClinicaDiaria'] == 'update'){
        camposLivres_update('tb_evolucao_clinica_diaria');
    
    }elseif($_GET['txt_conduta'] == 'insert'){ //Conduta
        camposLivres_insert('tb_conduta');
    }elseif($_GET['txt_conduta'] == 'update'){
        camposLivres_update('tb_conduta');
    
    }elseif($_GET['txt_laboratorial'] == 'insert'){ //Laboratorial
        camposLivres_insert('tb_laboratorial');
    }elseif($_GET['txt_laboratorial'] == 'update'){
        camposLivres_update('tb_laboratorial');
    }



    //INVASOES e ANTIBIOTICOS
    if($_GET['txt_invasao'] == 'insert'){
        invasoes_insert();
    }elseif($_GET['txt_invasao'] == 'update'){
        invasoes_update();
    }elseif($_GET['txt_invasao'] == 'delete'){
        invasoes_delete();
    }elseif($_GET['txt_antibiotico'] == 'insert'){
        antibioticos_insert();
    }elseif($_GET['txt_antibiotico'] == 'update'){
        antibioticos_update();
    }elseif($_GET['txt_antibiotico'] == 'delete'){
        antibioticos_delete();
    }

    //TROCA DE LEITO
    if($_GET['txt_trocarLeitos'] == 'update'){
        trocarLeitos_update();
    }


    //DAR ALTA OU OBITO
    if($_GET['darAltaObito'] == 'update'){
        darAltaObito_update();
    }


    //SELECTS
    if($_GET['CampoTexto'] == 'select'){

        verifica_ocupacao_leito();
    
    }

    if($_GET['CampoInvasoes'] == 'select'){

        consulta_invasoes();
    
    }

    if($_GET['CampoAntibioticos'] == 'select'){

        consulta_antibioticos();
    
    }


?>