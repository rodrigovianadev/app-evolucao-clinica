<?php

session_start();

if(!isset($_SESSION['userAtenticado']) or $_SESSION['userAtenticado'] <> 'SIM'){
    header('Location: index.php?login=erro2');
    exit;
}

require_once 'querys_home.php';
require_once '../../app-evolucao-clinica/variaveis_e_ips.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Uti - Maice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style9.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- FontAwesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />
    <!-- Stylesheet -->
    <link rel="stylesheet" href="style_rich_text.css" />
    

    <style>

        body{

            background-color:#f2f2f2;
        }



    </style>   
    
 

</head>
<body>



    <!--------- MENU ------------>
        


        <div class="opcoes-menu">


        <!--<nav class="navbar navbar-expand-lg navbar-dark bg-success">  -->
        <nav class="navbar navbar-dark fixed-top">

            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img id="imgLogotipoHome" src="imagens/logoMaice2.png"> 
                    <span id="tituloMenu">
                        &nbsp; UTI: <?php echo $nomeHospital; ?>
                    </span>    
                </a>            

                <span class="container_rich_text">
                    <!-- Text Format -->
                    <button id="bold" class="option-button format">
                    <i class="fa-solid fa-bold"></i>
                    </button>
                    <button id="italic" class="option-button format">
                    <i class="fa-solid fa-italic"></i>
                    </button>
                    <button id="underline" class="option-button format">
                    <i class="fa-solid fa-underline"></i>
                    </button>
                    <!--
                    <button id="text_format" class="option-button format">
                    <i class="fa-solid fa-font"></i>
                    </button>
                    -->


                    <!-- Color -->
                    <div class="input-wrapper">
                    <label for="foreColor">Cor:</label>
                    <input type="color" id="foreColor" class="adv-option-button" />
                    </div>
                    <!--
                    <div class="input-wrapper">
                    <input type="color" id="backColor" class="adv-option-button" />
                    <label for="backColor">Realce</label>
                    </div>
                    -->
            </span>

                <span id="loadingMenu" style="font-size:13px;color:#ddd">Atualizando...<img src="imagens/loading.gif" style="width:27px;height:27px"></span>

                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                      
            </div>

                

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <!--
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                -->

                
                <div class="offcanvas-body bg-secondary">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 1"><img src="imagens/chevrons-right.svg"> Leito 1</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 2"><img src="imagens/chevrons-right.svg"> Leito 2</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 3"><img src="imagens/chevrons-right.svg"> Leito 3</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 4"><img src="imagens/chevrons-right.svg"> Leito 4</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 5"><img src="imagens/chevrons-right.svg"> Leito 5</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 6"><img src="imagens/chevrons-right.svg"> Leito 6</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 7"><img src="imagens/chevrons-right.svg"> Leito 7</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 8"><img src="imagens/chevrons-right.svg"> Leito 8</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 9"><img src="imagens/chevrons-right.svg"> Leito 9</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" aria-current="page" href="#Leito 10"><img src="imagens/chevrons-right.svg"> Leito 10</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" href="perfil_usuario.php"><img src="imagens/user-plus.svg">  Criar Usu??rio</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" href="perfil_usuario.php"><img src="imagens/key.svg">  Alterar senha</a>
                        </li>
                        <li class="nav-item" data-bs-dismiss="offcanvas" aria-label="Close">
                            <a class="nav-link active" href="logoff.php"><img src="imagens/iconLogout2.svg"> Sair</a>
                        </li>
               
                    </ul>

                </div>
                </div>
            </div>

    </nav>    

    </div>


    
    <br><br>

    <!---- Modal Troca Leitos ----->
    <div class="w3-modal" id="modalTrocarLeitos">
            <form class = "w3-modal-content">
            <span onclick="document.getElementById('modalTrocarLeitos').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="form-modais-trocarLeito">
                    <h2>Troca de Leitos</h2>
                    
                    <button id="btnSalvarTrocaLeitos" class="btn-primary">Salvar</button>
                    <button id="btnCancelarTrocaLeitos" class="btn-secondary">Cancelar</button>
                    <span id="loadingTrocaLeitos"></span>

                    <br>

                    <!-- Tabela -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Leito</th>
                            <th scope="col">Paciente</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php for($a = 1;$a <= 10;$a++){ ?>
                            <tr>
                                <td>
                                    <select class="label-modais" id="<?php echo 'txt_trocarLeitos_' . $a?>" default="<?php echo 'Leito ' . $a; ?>" >
                                        <?php for($e = 1;$e <= 10;$e++){ 
                                            if($e <> $a){ ?>    
                                                <option><?php echo 'Leito ' . $e; ?></option>
                                        <?php }else{ ?>
                                                <option selected="selected"><?php echo 'Leito ' . $e; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </td>
                                
                                <td id="<?php echo 'txt_nomeTrocarLeitos_' . $a ?>"></td>
                                <input type="hidden" id="<?php echo 'txt_idTrocarLeitos_' . $a ?>">
                            </tr>
                        <?php } ?>
                        
                        </tbody>

                    </table>


                </div>

            </form>
        </div>


    
    <?php $contador = 1; ?>
    <?php foreach(consulta_leitos() as $i){?>

        <!--- MODAIS --->

        <!---- Modal Cadastro ----->
        <div class="w3-modal" id="<?php echo 'modalCad_' . $i['leito']?>">
        <form class = "w3-modal-content">
            <div class="form-modais">
                <input type="text" id="<?php echo 'txt_idInternacao_' . $i['leito'] ?>">
                <input type="text" value="<?php echo $i['leito'] ?>" id="<?php echo 'txt_' . $i['leito'] ?>">
                Nome: <input type="text" class="label-modais" id="<?php echo 'txt_nome_' . $i['leito'] ?>"><br>
                Sexo:
                <select class="label-modais" id="<?php echo 'txt_sexo_' . $i['leito'] ?>">
                    <option>Masculino</option>
                    <option>Feminino</option>
                </select>
                <br>
                Dt Nascimento: <input type="date" class="label-modais" id="<?php echo 'txt_dt_nascimento_' . $i['leito'] ?>"><br>
                Convenio: <input type="text" class="label-modais" id="<?php echo 'txt_convenio_' . $i['leito'] ?>"><br>
                Dt Interna????o: <input type="date" class="label-modais" id="<?php echo 'txt_dt_internacao_' . $i['leito'] ?>"><br>
                Peso: <input type="number" class="label-modais" id="<?php echo 'txt_peso_' . $i['leito'] ?>"><br>
                Saps3: <input type="text" class="label-modais" id="<?php echo 'txt_saps3_' . $i['leito'] ?>"><br>
                
                <a class="confirmCancelCad link" id="<?php echo 'btnConfirmCad_' . $i['leito']?>">Confirmar</a>
                <a class="confirmCancelCad link" id="<?php echo 'btnCancelCad_' . $i['leito']?>">Cancelar</a>
            </div>
        </form>
        </div>


        <!---- Modal Invasoes ----->
        <div class="w3-modal" id="<?php echo 'modalInvasao_' . $i['leito']?>">
            <form class = "w3-modal-content">
                <div class="form-modais">
                    <input type="hidden" id="<?php echo 'txt_idInvasoes_' . $i['leito'] ?>">
                    Invas??o: <input type="text" class="label-modais" id="<?php echo 'txt_invasoes_' . $i['leito'] ?>"><br>
                    Dt Inicio: <input type="date" class="label-modais" id="<?php echo 'txt_dtInicioInvasoes_' . $i['leito'] ?>"><br>
                    Dt Fim: <input type="date" class="label-modais" id="<?php echo 'txt_dtFimInvasoes_' . $i['leito'] ?>"><br>
                    Observa????o: <input type="text" class="label-modais" id="<?php echo 'txt_obsInvasoes_' . $i['leito'] ?>"><br><br>

                    <a id="<?php echo 'btnSalvarInvasoes_' . $i['leito']?>" class="link">Salvar</a>
                    <a id="<?php echo 'btnExcluirInvasoes_' . $i['leito']?>" class="link">Excluir</a>
                    <a id="<?php echo 'btnCancelarInvasoes_' . $i['leito']?>" class="link">Cancelar</a>
                </div>

            </form>
        </div>


        <!---- Modal Calculadora Clearence----->
        <div class="w3-modal" id="<?php echo 'modalClearenceCalc_' . $i['leito']?>">
            <form class = "w3-modal-content">
            <span onclick="document.getElementById('<?php echo 'modalClearenceCalc_' . $i['leito']?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <div class="form-modais">
                    <input type="hidden" id="<?php echo 'txt_idClearenceCalc_' . $i['leito'] ?>">
                    Creatinina: <input type="number" class="label-modais" id="<?php echo 'txt_creatininaClearenceCalc_' . $i['leito'] ?>"><br>
                    Idade: <input type="text" class="label-modais" id="<?php echo 'txt_idadeClearenceCalc_' . $i['leito'] ?>" disabled><br>
                    Peso: <input type="text" class="label-modais" id="<?php echo 'txt_pesoClearenceCalc_' . $i['leito'] ?>" disabled><br>
                    Sexo: <input type="text" class="label-modais" id="<?php echo 'txt_sexoClearenceCalc_' . $i['leito'] ?>" disabled><br><br>

                    <div id="<?php echo 'txt_resultadoClearenceCalc_' . $i['leito'] ?>"></div>

                </div>

            </form>
        </div>


        <!---- Modal Antibioticos/Tratamentos ----->
        <div class="w3-modal" id="<?php echo 'modalAntibiotico_' . $i['leito']?>">
            <form class = "w3-modal-content">
                <div class="form-modais">
                    <input type="hidden" id="<?php echo 'txt_idAntibioticos_' . $i['leito'] ?>">
                    Antibiotico: <input type="text" class="label-modais" id="<?php echo 'txt_antibioticos_' . $i['leito'] ?>"><br>
                    Dt Inicio: <input type="date" class="label-modais" id="<?php echo 'txt_dtInicioAntibioticos_' . $i['leito'] ?>"><br>
                    Dt Fim: <input type="date" class="label-modais" id="<?php echo 'txt_dtFimAntibioticos_' . $i['leito'] ?>"><br>
                    Observa????o: <input type="text" class="label-modais" id="<?php echo 'txt_obsAntibioticos_' . $i['leito'] ?>"><br><br>

                    <a id="<?php echo 'btnSalvarAntibioticos_' . $i['leito']?>" class="link">Salvar</a>
                    <a id="<?php echo 'btnExcluirAntibioticos_' . $i['leito']?>" class="link">Excluir</a>
                    <a id="<?php echo 'btnCancelarAntibioticos_' . $i['leito']?>" class="link">Cancelar</a>
                </div>

            </form>
        </div>

        <!---- Modal Texto Copiado ----->
        <div class="w3-modal" id="<?php echo 'modalTextoCopiado_' . $i['leito']?>">
            <form class = "w3-modal-content">
            <span onclick="document.getElementById('<?php echo 'modalTextoCopiado_' . $i['leito']?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    
                <h3>Texto abaixo copiado com sucesso!</h3>

                <div class="txt_textoCopiado form-modais-copy" id="<?php echo 'txt_textoCopiado_' . $i['leito']?>"></div>

            </form>
        </div>

        <!---- Modal ALTA ----->
        <div class="w3-modal" id="<?php echo 'modalAlta_' . $i['leito']?>">
            <form class = "w3-modal-content" style="text-align:center;padding:10px 40px 40px 40px">
            <span onclick="document.getElementById('<?php echo 'modalAlta_' . $i['leito']?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    
                <h3 id="tituloModalAlta">
                    Deseja realmente confirmar a ALTA deste paciente?
                </h3>

                <button id="btn_altaSim_<?php echo $i['leito']; ?>" class="btn btn-primary">SIM</button>
                <button id="btn_altaNao_<?php echo $i['leito']; ?>" class="btn btn-secondary">N??O</button>
                <div id="loadingAlta"></div>

            </form>
        </div>


        <!---- Modal OBITO ----->
        <div class="w3-modal" id="<?php echo 'modalObito_' . $i['leito']?>">
            <form class = "w3-modal-content" style="text-align:center;padding:10px 40px 40px 40px">
            <span onclick="document.getElementById('<?php echo 'modalObito_' . $i['leito']?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    
                <h2 id="tituloModalObito">
                    Deseja realmente confirmar o OBITO deste paciente?
                </h2>
                
                <button id="btn_obitoSim_<?php echo $i['leito']; ?>" class="btn btn-primary">SIM</button><br>
                <button id="btn_obitoNao_<?php echo $i['leito']; ?>" class="btn btn-secondary">N??O</button>
                <div id="loadingObito"></div>

            </form>
        </div>
        


        <!--  CONSTROI INFO LEITOS -->
        <div id="containerHome">
            <div class="colHome">
                <div class="tituloTbLeitos" id="<?php echo $i['leito'] ?>">
                    #<?php echo $i['leito'] ?>
                    <img src="imagens/btnNovo.png" class="btnNovoHome" id="btnNovoCad_<?php echo $i['leito']; ?>">
                    <img src="imagens/repeat.svg" class="btnTrocarLeito" id="btnTrocarLeitos_<?php echo $i['leito']; ?>">
                    <img src="imagens/copy.svg" class="btnCopy" id="btnCopy_<?php echo $i['leito']; ?>">
                </div>
                <div class="divCadastro">
                    <div id="lbl_nome_<?php echo $i['leito']; ?>">Nome: </div>
                    <div id="lbl_sexo_<?php echo $i['leito']; ?>">Sexo:</div>
                    <div id="lbl_dtNascimento_<?php echo $i['leito']; ?>">Dt Nascimento: </div>
                    <div id="lbl_idade_<?php echo $i['leito']; ?>">Idade: </div>
                    <div id="lbl_convenio_<?php echo $i['leito']; ?>">Convenio: </div>
                    <div id="lbl_dtInternacao_<?php echo $i['leito']; ?>">Dt Interna????o: </div>
                    <div id="lbl_peso_<?php echo $i['leito']; ?>">Peso:</div>
                    <div id="lbl_saps3_<?php echo $i['leito']; ?>">Saps3:</div>
                    <div id="linkAltaObito">
                        <span class="diasUTI" id="lbl_diasUTI_<?php echo $i['leito']; ?>"> Dias UTI:</span>
                        <a class="link-primary" id="btn_darAlta_<?php echo $i['leito']; ?>">Dar Alta</a>&nbsp;&nbsp;
                        <a class="link-danger" id="btn_darObito_<?php echo $i['leito']; ?>">Obito</a>
                    </div>
                </div>

                    <div class="subtituloTbLeitos">#LISTA DE PROBLEMAS<span id="statusRequisicao_listaProblemas_<?php echo $i['leito']; ?>"></span></div>
                    <input type="hidden" id="txt_id_listaProblemas_<?php echo $i['leito']; ?>">
                    <input type="hidden" id="txt_checkedicao_listaProblemas_<?php echo $i['leito']; ?>">
                    <div contenteditable="true" id="txt_listaProblemas_<?php echo $i['leito']; ?>" class="tamanhoTextAreas txt_listaProblemas"></div>

                    <div class="subtituloTbLeitos">#HIP??TESES DIAGN??STICAS<span id="statusRequisicao_hipotesesDiagnosticas_<?php echo $i['leito']; ?>"></span></div>
                    <input type="hidden" id="txt_id_hipotesesDiagnosticas_<?php echo $i['leito']; ?>">
                    <input type="hidden" id="txt_checkedicao_hipotesesDiagnosticas_<?php echo $i['leito']; ?>">
                    <div contenteditable="true" id="txt_hipotesesDiagnosticas_<?php echo $i['leito']; ?>" class="tamanhoTextAreas txt_hipotesesDiagnosticas"></div>

            </div>

            <div class="colHome">

                <div class="subtituloTbLeitos">#EXAMES RELEVANTES<span id="statusRequisicao_examesRelevantes_<?php echo $i['leito']; ?>"></span></div>
                <!--<div contenteditable="true" onkeyup="autoResize()" id="txtTextArea2" class="tamanhoTextAreas"></div>-->
                <input type="hidden" id="txt_id_examesRelevantes_<?php echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_examesRelevantes_<?php echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_examesRelevantes_<?php echo $i['leito']; ?>" class="tamanhoTextAreas txt_examesRelevantes"></div>

                <div class="subtituloTbLeitos">#CULTURAS<span id="statusRequisicao_culturas_<?php echo $i['leito']; ?>"></span></div>
                <!--<div contenteditable="true" onkeyup="autoResize()" id="txt_listaProblemas0" class="tamanhoTextAreas"></div>-->
                <input type="hidden" id="txt_id_culturas_<?php echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_culturas_<?php echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_culturas_<?php echo $i['leito']; ?>" class="tamanhoTextAreas txt_culturas"></div>


                <div class="subtituloTbLeitos">#INVAS??ES <img src="imagens/btnNovo.png" class="btnNovoHome" id="btnNovoInvasao_<?php echo $i['leito']; ?>"></div>
                <div class="tamanhoTextAreas txt_invasoes" id="div_invasoes_<?php echo $i['leito']; ?>">
                </div>
                
                
                <div class="subtituloTbLeitos">#ANTIBI??TICOS/TRATAMENTOS <img src="imagens/btnNovo.png" class="btnNovoHome" id="btnNovoAntibioticos_<?php echo $i['leito']; ?>"></div>
                <div class="tamanhoTextAreas txt_antibioticos" id="div_antibioticos_<?php echo $i['leito']; ?>">
                </div>


            </div>            
            
            <!--
            <div class="colHome">
                <div class="subtituloTbLeitos">#INFUS??ES<span id="statusRequisicao_infusoes_<?php //echo $i['leito']; ?>"></span></div>
                <input type="hidden" id="txt_id_infusoes_<?php //echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_infusoes_<?php //echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_infusoes_<?php //echo $i['leito']; ?>" class="tamanhoTextAreas"></div>
                
                <div class="subtituloTbLeitos">#SINAIS VITAIS<span id="statusRequisicao_sinaisVitais_<?php //echo $i['leito']; ?>"></span></div>
                <input type="hidden" id="txt_id_sinaisVitais_<?php //echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_sinaisVitais_<?php //echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_sinaisVitais_<?php //echo $i['leito']; ?>" class="tamanhoTextAreas"></div>

                <div class="subtituloTbLeitos">#BALAN??O H??DRICO<span id="statusRequisicao_balancoHidrico_<?php //echo $i['leito']; ?>"></span></div>
                <input type="hidden" id="txt_id_balancoHidrico_<?php //echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_balancoHidrico_<?php //echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_balancoHidrico_<?php //echo $i['leito']; ?>" class="tamanhoTextAreas"></div>

                
                <div class="subtituloTbLeitos">#NUTRICIONAL<span id="statusRequisicao_nutricional_<?php //echo $i['leito']; ?>"></span></div>
                <input type="hidden" id="txt_id_nutricional_<?php //echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_nutricional_<?php //echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_nutricional_<?php //echo $i['leito']; ?>" class="tamanhoTextAreas"></div>
                
                
                <div class="subtituloTbLeitos">#VENTILA????O<span id="statusRequisicao_ventilacao_<?php //echo $i['leito']; ?>"></span></div>
                <input type="hidden" id="txt_id_ventilacao_<?php //echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_ventilacao_<?php //echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_ventilacao_<?php //echo $i['leito']; ?>" class="tamanhoTextAreas"></div>
                
                
                <div class="subtituloTbLeitos">#GASOMETRIA<span id="statusRequisicao_gasometria_<?php //echo $i['leito']; ?>"></span></div>
                <input type="hidden" id="txt_id_gasometria_<?php //echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_gasometria_<?php //echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_gasometria_<?php //echo $i['leito']; ?>" class="tamanhoTextAreas"></div>
                

            </div>
            -->

            <div class="colHome-dupla">

                <div class="subtituloTbLeitos">#LABORATORIAL <img src="imagens/btnNovo.png" class="btnNovoHome" id="btnNovoLaboratorialClearenceCalc_<?php echo $i['leito']; ?>"><span id="statusRequisicao_laboratorial_<?php echo $i['leito']; ?>"></span></div>
                <input type="hidden" id="txt_id_laboratorial_<?php echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_laboratorial_<?php echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_laboratorial_<?php echo $i['leito']; ?>" class="tamanhoTextAreas txt_laboratorial"></div>

                <div class="subtituloTbLeitos">#EVOLU????O CLINICA DI??RIA<span id="statusRequisicao_evolucaoClinicaDiaria_<?php echo $i['leito']; ?>"></span></div>
                <!--<div contenteditable="true" onkeyup="autoResize()" id="txt_listaProblemas3" class="tamanhoTextAreas"></div>-->
                <input type="hidden" id="txt_id_evolucaoClinicaDiaria_<?php echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_evolucaoClinicaDiaria_<?php echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_evolucaoClinicaDiaria_<?php echo $i['leito']; ?>" class="tamanhoTextAreas txt_evolucaoClinicaDiaria"></div>
            
                <div class="subtituloTbLeitos">#CONDUTA<span id="statusRequisicao_conduta_<?php echo $i['leito']; ?>"></span></div>
                <!--<div contenteditable="true" onkeyup="autoResize()" id="txt_listaProblemas4" class="tamanhoTextAreas"></div>-->
                <input type="hidden" id="txt_id_conduta_<?php echo $i['leito']; ?>">
                <input type="hidden" id="txt_checkedicao_conduta_<?php echo $i['leito']; ?>">
                <div contenteditable="true" id="txt_conduta_<?php echo $i['leito']; ?>" class="tamanhoTextAreas txt_conduta"></div>

            </div>


        </div>


    <?php } ?>

    <div contenteditable="true" id="txt_global" class="tamanhoTextAreas txt_conduta" style="display:none;"></div>
    <div contenteditable="true" id="txt_global2" class="tamanhoTextAreas txt_conduta" style="display:none;"></div>


    <script src="script_home15.js"></script>
    
    <script>
        
        //Executa ao carregar a p??gina
        execTodosSelects('pagina')

        
        //Depois fica executando de 5 em 5 segundos
        x = setInterval(function(){

            execTodosSelects('timer')
        
        },5000)

    </script>

    <!--Script-->
    <script src="script_rich_text.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>