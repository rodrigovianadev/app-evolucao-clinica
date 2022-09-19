function display_image(src, width, height, alt,setDiv) {
    var a = document.createElement("img");
    a.src = src;
    a.width = width;
    a.height = height;
    a.alt = alt;
    setDiv.appendChild(a);
}

async function execTodosSelects(origem){
    let contador = 1;
    for(let i = 1; i <= 10; i++){
        await abreModalCad(contador,'externo')
        selectCamposTexto(contador)
        selectInvasoes(contador)
        selectAntibioticos(contador,origem)
        contador++;
    }
}

//* ----------------------- CAMPOS DE TEXTO ----------------------- *// 

// ---------------------- Eventos -----------------------------//

for(let i = 1; i <= 10;i++){
    
    //let listaCampos = ['listaProblemas', 'infusoes','sinaisVitais','balancoHidrico','nutricional',
    //'ventilacao','gasometria','culturas','examesRelevantes','evolucaoClinicaDiaria','conduta','laboratorial']

    let listaCampos = ['listaProblemas','hipotesesDiagnosticas','culturas','examesRelevantes','evolucaoClinicaDiaria','conduta','laboratorial']

    for(let cont = 0; cont <= listaCampos.length -1;cont++){
        
        let textoCampo = listaCampos[cont]

        document.getElementById("bold").addEventListener("click", function(){selecionaCheckEdicao(i,textoCampo,'formatou')})
        document.getElementById("italic").addEventListener("click", function(){selecionaCheckEdicao(i,textoCampo,'formatou')})
        document.getElementById("underline").addEventListener("click", function(){selecionaCheckEdicao(i,textoCampo,'formatou')})
        document.getElementById("foreColor").addEventListener("click", function(){selecionaCheckEdicao(i,textoCampo,'formatou')})

        document.getElementById("txt_" + textoCampo + "_Leito " + i).addEventListener("blur", function(){insertCamposTexto(i,textoCampo,document.getElementById("txt_global2").innerHTML)})
        document.getElementById("txt_" + textoCampo  + "_Leito " + i).addEventListener("keyup", function(){escreveCheckEdicao(i,textoCampo)})
        document.getElementById("txt_" + textoCampo  + "_Leito " + i).addEventListener("focus", function(){selecionaCheckEdicao(i,textoCampo)})


    }
        //document.getElementById("txt_listaProblemas_Leito " + i).addEventListener("blur", function(){insertCamposTexto(i,'listaProblemas')})
    //document.getElementById("txt_listaProblemas_Leito " + i).addEventListener("keyup", function(){escreveCheckEdicao(i,'listaProblemas')})
    
    //document.getElementById("txt_infusoes_Leito " + i).addEventListener("blur", function(){insertCamposTexto(i,'infusoes')})
    //document.getElementById("txt_infusoes_Leito " + i).addEventListener("keyup", function(){escreveCheckEdicao(i,'infusoes')})

}

// ---------------------- Funcoes -----------------------------//

function escreveCheckEdicao(i,campo){

    let teclasNulas = 
    [9, 37, 38, 39, 40, 17, 18, 16, 20, 113, 115, 119, 120, 122, 27, 123,45, 36, 33, 34, 35, 91]

    if(teclasNulas.indexOf(event.keyCode) == '-1' ){

        clearInterval(x)

        let check_edicao = document.getElementById("txt_checkedicao_" + campo + "_Leito " + i)

        check_edicao.value = 'editou'

        document.getElementById("txt_global").innerHTML =
        document.getElementById("txt_" + campo + "_Leito " + i).innerHTML

    
    }
}

function selecionaCheckEdicao(i,campo,acao){

        clearInterval(x)

        let check_edicao = document.getElementById("txt_checkedicao_" + campo + "_Leito " + i)


        if(document.getElementById("txt_global").innerText != document.getElementById("txt_" + campo + "_Leito " + i).innerText
        && document.getElementById("txt_global").innerHTML != 'formatou'){      
            document.getElementById("txt_global").innerHTML =
            document.getElementById("txt_" + campo + "_Leito " + i).innerHTML

            document.getElementById("txt_global2").innerHTML =
            document.getElementById("txt_" + campo + "_Leito " + i).innerHTML

        }else if(acao == 'formatou'){

            check_edicao.value = 'editou'

            document.getElementById("txt_global").innerHTML = 'formatou'

        }
}


function insertCamposTexto(i,campo,valorAntigo){

    

    let check_edicao = document.getElementById("txt_checkedicao_" + campo + "_Leito " + i)
    let valorNovo = document.getElementById("txt_" + campo + "_Leito " + i).innerHTML

    //alert(valorAntigo + ' | ' + valorNovo)

    if(check_edicao.value == 'editou' && 
    (valorAntigo != valorNovo) || 
    (document.getElementById("txt_global").innerHTML != valorNovo) ||
    (document.getElementById("txt_global").innerHTML != valorAntigo)){

        clearInterval(x)

        let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
        let id_internacao_campo = document.getElementById("txt_id_" + campo + "_Leito " + i)
        let texto = document.getElementById("txt_" + campo + "_Leito " + i)
        let statusRequisicao = document.getElementById("statusRequisicao_" + campo +  "_Leito " + i)
        let htmlLoading = '<img src="imagens/loadingAzul.gif" style="width:37px;height:22px;float:right">'
        let htmlMsgSucesso = '<span style="float:right;font-size:10px;color:blue">Atualizado!</span>'
        let htmlMsgErro = '<span style="float:right;font-size:10px;color:red">Erro, repita!</span>'

        if(id_internacao.value != ''){

            let ajax = new XMLHttpRequest();

            if(id_internacao_campo.value == ''){

                ajax.abort()
                texto.setAttribute('disabled', true);
                statusRequisicao.innerHTML = htmlLoading

                ajax.open('GET', 
                'querys_home.php?txt_' + campo + '=insert' +
                '&id_internacao=' + encodeURIComponent(id_internacao.value) +
                '&texto=' + encodeURIComponent(texto.innerHTML.replaceAll("\n", "<br>","g")))

            }else{

                ajax.abort()
                texto.setAttribute('disabled', true);
                statusRequisicao.innerHTML = htmlLoading

                ajax.open('GET',
                'querys_home.php?txt_' + encodeURIComponent(campo) + '=update&NomeLeito=Leito ' + i +
                '&id_internacao=' + encodeURIComponent(id_internacao.value) +
                '&texto=' + encodeURIComponent(texto.innerHTML.replaceAll("\n", "<br>","g")))
            }

            console.log(ajax)

            ajax.send()

            ajax.onreadystatechange = () =>{
                if (ajax.readyState == 4 && ajax.status == 200 && id_internacao_campo.value == '') {
                    id_internacao_campo.value = 'sucesso ao inserir'
                    //alert('Gravado com sucesso!')
                    //window.location.reload()
                    statusRequisicao.innerHTML = htmlMsgSucesso
                    texto.removeAttribute('disabled');

                    selectCamposTexto(i)

                    x = setInterval(function(){
                        execTodosSelects('timer')
                    },5000)

                }else if (ajax.readyState == 4 && ajax.status == 404){

                    statusRequisicao.innerHTML = htmlMsgErro
                    texto.removeAttribute('disabled');
                
                }else if (ajax.readyState == 4 && ajax.status == 200){
                    //alert('Gravado com sucesso!')
                    //window.location.reload()
                    statusRequisicao.innerHTML = htmlMsgSucesso
                    texto.removeAttribute('disabled');

                    selectCamposTexto(i)

                    x = setInterval(function(){
                        execTodosSelects('timer')
                    },5000)
                }
            }

            timerEdicao = setInterval(function(){
                check_edicao.value = ''
                clearInterval(timerEdicao)
            },5000)
        
        }else{
            
            alert('Erro ao salvar! Informe ao menos o nome do paciente!!!')

            x = setInterval(function(){
                execTodosSelects('timer')
            },5000)

        }

        document.getElementById("txt_global").innerText = ''
        document.getElementById("txt_global2").innerText = ''
        valorAntigo = ''
        check_edicao.value = ''

    }else if(check_edicao.value != 'editou' && valorAntigo == valorNovo){

        check_edicao.value = ''

        x = setInterval(function(){
            execTodosSelects('timer')
        },5000)

    }


}


function selectCamposTexto(i){
    
    let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
    let txt_lista_problemas = document.getElementById("txt_listaProblemas_Leito " + i)
    let txt_hipoteses_diagnosticas = document.getElementById("txt_hipotesesDiagnosticas_Leito " + i)
    //let txt_infusoes = document.getElementById("txt_infusoes_Leito " + i)
    //let txt_sinaisVitais = document.getElementById("txt_sinaisVitais_Leito " + i)
    //let txt_balancoHidrico = document.getElementById("txt_balancoHidrico_Leito " + i)
    //let txt_nutricional = document.getElementById("txt_nutricional_Leito " + i)
    //let txt_ventilacao = document.getElementById("txt_ventilacao_Leito " + i)
    //let txt_gasometria = document.getElementById("txt_gasometria_Leito " + i)
    let txt_culturas = document.getElementById("txt_culturas_Leito " + i)
    let txt_examesRelevantes = document.getElementById("txt_examesRelevantes_Leito " + i)
    let txt_evolucaoClinicaDiaria = document.getElementById("txt_evolucaoClinicaDiaria_Leito " + i)
    let txt_conduta = document.getElementById("txt_conduta_Leito " + i)
    let txt_laboratorial = document.getElementById("txt_laboratorial_Leito " + i)

    let ajax = new XMLHttpRequest();

    ajax.open('GET', 'querys_home.php?CampoTexto=select&NomeLeito=Leito ' + i +
        '&id_internacao=' + encodeURIComponent(id_internacao.value))
    
    console.log(ajax)

    ajax.onreadystatechange = () =>{

        //let listaCampos = ['listaProblemas', 'infusoes','sinaisVitais','balancoHidrico','nutricional',
        //'ventilacao','gasometria','culturas','examesRelevantes','evolucaoClinicaDiaria','conduta','laboratorial']

        let listaCampos = ['listaProblemas','hipotesesDiagnosticas','culturas','examesRelevantes','evolucaoClinicaDiaria','conduta','laboratorial']

        //let campos = ['texto_listaProblemas', 'texto_infusoes','texto_sinaisVitais','texto_balancoHidrico',
        //'texto_nutricional','texto_ventilacao','texto_gasometria','texto_culturas','texto_examesRelevantes',
        //'texto_evolucaoClinicaDiaria','texto_conduta','texto_laboratorial']

        let campos = ['texto_listaProblemas','texto_hipotesesDiagnosticas','texto_culturas','texto_examesRelevantes',
        'texto_evolucaoClinicaDiaria','texto_conduta','texto_laboratorial']

        if (ajax.readyState == 4 && ajax.status == 200) {

            for(let e = 0; e <= campos.length + 1; e++){
                
                let resultAjax = ajax.responseText

                let PosIni = resultAjax.indexOf('<' + campos[e] + '>')
                let PosFim = resultAjax.indexOf('</' + campos[e] + '>')
                let check_edicao = document.getElementById("txt_checkedicao_" + listaCampos[e] + "_Leito " + i)

                if(campos[e] == 'texto_listaProblemas' && check_edicao.value != 'editou'){
                    txt_lista_problemas.innerHTML = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','')

                }else if(campos[e] == 'texto_hipotesesDiagnosticas' && check_edicao.value != 'editou'){
                    txt_hipoteses_diagnosticas.innerHTML = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','')    
                /*}else if(campos[e] == 'texto_infusoes' && check_edicao.value != 'editou'){
                    txt_infusoes.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','').replaceAll("<br>","\n")
                }else if(campos[e] == 'texto_sinaisVitais' && check_edicao.value != 'editou'){
                    txt_sinaisVitais.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','').replaceAll("<br>","\n")
                }else if(campos[e] == 'texto_balancoHidrico' && check_edicao.value != 'editou'){
                    txt_balancoHidrico.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','').replaceAll("<br>","\n")
                }else if(campos[e] == 'texto_nutricional' && check_edicao.value != 'editou'){
                    txt_nutricional.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','').replaceAll("<br>","\n")
                }else if(campos[e] == 'texto_ventilacao' && check_edicao.value != 'editou'){
                    txt_ventilacao.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','').replaceAll("<br>","\n")
                }else if(campos[e] == 'texto_gasometria' && check_edicao.value != 'editou'){
                    txt_gasometria.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','').replaceAll("<br>","\n")
                */
                }else if(campos[e] == 'texto_culturas' && check_edicao.value != 'editou'){
                    txt_culturas.innerHTML = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','')
                }else if(campos[e] == 'texto_examesRelevantes' && check_edicao.value != 'editou'){
                    txt_examesRelevantes.innerHTML = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','')
                }else if(campos[e] == 'texto_evolucaoClinicaDiaria' && check_edicao.value != 'editou'){
                    txt_evolucaoClinicaDiaria.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','')
                }else if(campos[e] == 'texto_conduta' && check_edicao.value != 'editou'){
                    txt_conduta.innerHTML = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','')
                }else if(campos[e] == 'texto_laboratorial' && check_edicao.value != 'editou'){
                    txt_laboratorial.innerHTML = resultAjax.substring(PosIni,PosFim).replace('<' + campos[e] + '>','')
                }

           }

           

        }
    }


    ajax.send()
}




//* ----------------------- INVASOES E ANTIBIOTICOS ----------------------- *// 

// ---------------------- Eventos -----------------------------//
for(let a = 1; a <= 10;a++){
    
    let listaCampos = ['Invasoes','Antibioticos']

    for(let cont = 0; cont <= listaCampos.length -1;cont++){
        
        let textoCampo = listaCampos[cont]

        if(textoCampo == 'Invasoes'){
            
            document.getElementById("btnSalvar" + textoCampo + "_Leito " + a).addEventListener("click", function(){invasoes_insert(a,'salvar')})
            document.getElementById("btnExcluir" + textoCampo + "_Leito " + a).addEventListener("click", function(){invasoes_insert(a,'excluir')})
        
        }else if(textoCampo == 'Antibioticos'){

            document.getElementById("btnSalvar" + textoCampo + "_Leito " + a).addEventListener("click", function(){antibioticos_insert(a,'salvar')})
            document.getElementById("btnExcluir" + textoCampo + "_Leito " + a).addEventListener("click", function(){antibioticos_insert(a,'excluir')})
        }
    }

}



// ---------------------- Funcoes -----------------------------//
function selectInvasoes(i){
    
    let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
    let div_invasoes = document.getElementById("div_invasoes_Leito " + i)

    let ajax = new XMLHttpRequest();

    ajax.open('GET', 'querys_home.php?CampoInvasoes=select&NomeLeito=Leito ' + i +
        '&id_internacao=' + encodeURIComponent(id_internacao.value))
    
    console.log(ajax)

    ajax.onreadystatechange = () =>{

        if (ajax.readyState == 4 && ajax.status == 200) {
            
            let resultAjax = ajax.responseText

            div_invasoes.innerHTML = resultAjax

        }
    }


    ajax.send()
}

function selectAntibioticos(i,origem){
    
    let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
    let div_antibioticos = document.getElementById("div_antibioticos_Leito " + i)

    let ajax = new XMLHttpRequest();

    ajax.open('GET', 'querys_home.php?CampoAntibioticos=select&NomeLeito=Leito ' + i +
        '&id_internacao=' + encodeURIComponent(id_internacao.value))
    
    console.log(ajax)

    ajax.onreadystatechange = () =>{

        if (ajax.readyState == 4 && ajax.status == 200) {
            
            let resultAjax = ajax.responseText

            div_antibioticos.innerHTML = resultAjax


            if(resultAjax != '' || (i == 10 && origem == 'timer')){
                document.getElementById("loadingMenu").style.display = "none"
            }
           

        }
    }


    ajax.send()
}

function invasoes_insert(i,acao){

    let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
    let txt_idInvasao = document.getElementById("txt_idInvasoes_Leito " + i)
    let txt_invasoes = document.getElementById("txt_invasoes_Leito " + i)
    let txt_dtIni = document.getElementById("txt_dtInicioInvasoes_Leito " + i)
    let txt_dtFim = document.getElementById("txt_dtFimInvasoes_Leito " + i)
    let txt_obs = document.getElementById("txt_obsInvasoes_Leito " + i)

    let ajax = new XMLHttpRequest();

    if(txt_idInvasao.value == '' && acao == 'salvar'){
        ajax.open('GET', 'querys_home.php?txt_invasao=insert&NomeLeito=Leito ' + i +
            '&id_invasao=' + encodeURIComponent(txt_idInvasao.value) +
            '&id_internacao=' + encodeURIComponent(id_internacao.value) +
            '&invasao=' + encodeURIComponent(txt_invasoes.value) +
            '&dt_inicio=' + encodeURIComponent(txt_dtIni.value) +
            '&dt_termino=' + encodeURIComponent(txt_dtFim.value) +
            '&observacoes=' + encodeURIComponent(txt_obs.value)
            )
    }else if(txt_idInvasao.value != '' && acao == 'excluir'){
        ajax.open('GET', 'querys_home.php?txt_invasao=delete&NomeLeito=Leito ' + i +
            '&id_invasao=' + encodeURIComponent(txt_idInvasao.value)
          
            )
    }else{
        ajax.open('GET', 'querys_home.php?txt_invasao=update&NomeLeito=Leito ' + i +
            '&id_invasao=' + encodeURIComponent(txt_idInvasao.value) +
            '&id_internacao=' + encodeURIComponent(id_internacao.value) +
            '&invasao=' + encodeURIComponent(txt_invasoes.value) +
            '&dt_inicio=' + encodeURIComponent(txt_dtIni.value) +
            '&dt_termino=' + encodeURIComponent(txt_dtFim.value) +
            '&observacoes=' + encodeURIComponent(txt_obs.value)
            )
    }

        console.log(ajax)

        ajax.onreadystatechange = () =>{

            if (ajax.readyState == 4 && ajax.status == 200) {
                
                //let resultAjax = ajax.responseText

                //txt_invasoes.innerHTML = resultAjax

                selectInvasoes(i)
                fechaModalInvasao('Leito ' + i);

            }
        }

        ajax.send()
}

function antibioticos_insert(i,acao){

    let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
    let txt_idAntibiotico = document.getElementById("txt_idAntibioticos_Leito " + i)
    let txt_antibioticos = document.getElementById("txt_antibioticos_Leito " + i)
    let txt_dtIni = document.getElementById("txt_dtInicioAntibioticos_Leito " + i)
    let txt_dtFim = document.getElementById("txt_dtFimAntibioticos_Leito " + i)
    let txt_obs = document.getElementById("txt_obsAntibioticos_Leito " + i)

    let ajax = new XMLHttpRequest();

    if(txt_idAntibiotico.value == '' && acao == 'salvar'){
        ajax.open('GET', 'querys_home.php?txt_antibiotico=insert&NomeLeito=Leito ' + i +
            '&id_antibiotico=' + encodeURIComponent(txt_idAntibiotico.value) +
            '&id_internacao=' + encodeURIComponent(id_internacao.value) +
            '&antibiotico=' + encodeURIComponent(txt_antibioticos.value) +
            '&dt_inicio=' + encodeURIComponent(txt_dtIni.value) +
            '&dt_termino=' + encodeURIComponent(txt_dtFim.value) +
            '&observacoes=' + encodeURIComponent(txt_obs.value)
            )
    }else if(txt_idAntibiotico.value != '' && acao == 'excluir'){
        ajax.open('GET', 'querys_home.php?txt_antibiotico=delete&NomeLeito=Leito ' + i +
            '&id_antibiotico=' + encodeURIComponent(txt_idAntibiotico.value)
          
            )
    }else{
        ajax.open('GET', 'querys_home.php?txt_antibiotico=update&NomeLeito=Leito ' + i +
            '&id_antibiotico=' + encodeURIComponent(txt_idAntibiotico.value) +
            '&id_internacao=' + encodeURIComponent(id_internacao.value) +
            '&antibiotico=' + encodeURIComponent(txt_antibioticos.value) +
            '&dt_inicio=' + encodeURIComponent(txt_dtIni.value) +
            '&dt_termino=' + encodeURIComponent(txt_dtFim.value) +
            '&observacoes=' + encodeURIComponent(txt_obs.value)
            )
    }

        console.log(ajax)

        ajax.onreadystatechange = () =>{

            if (ajax.readyState == 4 && ajax.status == 200) {
                
                //let resultAjax = ajax.responseText

                //txt_invasoes.innerHTML = resultAjax

                selectAntibioticos(i)
                fechaModalAntibiotico('Leito ' + i);

            }
        }

        ajax.send()
}



//* ----------------------- MODAL CADASTRO ----------------------- *// 

// ---------------------- Eventos -----------------------------//
var statusModalCad = 'fechado'

for(let i = 1; i <= 10;i++){
    document.getElementById("btnNovoCad_Leito " + i).addEventListener("click", function(){abreModalCad(i,'interno')})
    document.getElementById("btnConfirmCad_Leito " + i).addEventListener("click", function(){btnConfirmCad(i)})
    document.getElementById("btnCancelCad_Leito " + i).addEventListener("click", function(){abreModalCad(i,'interno')})
}


// ---------------------- Funcoes -----------------------------//
function abreModalCad(i,e){

    let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
    let leito = document.getElementById("txt_Leito " + i)
    let nome = document.getElementById("txt_nome_Leito " + i)
    let sexo = document.getElementById("txt_sexo_Leito " + i)
    let dt_nascimento = document.getElementById("txt_dt_nascimento_Leito " + i)
    let convenio = document.getElementById("txt_convenio_Leito " + i)
    let dt_internacao = document.getElementById("txt_dt_internacao_Leito " + i)
    let peso = document.getElementById("txt_peso_Leito " + i)
    let saps3 = document.getElementById("txt_saps3_Leito " + i)
    let id_listaProblemas = document.getElementById("txt_id_listaProblemas_Leito " + i)
    let id_hipotesesDiagnosticas = document.getElementById("txt_id_hipotesesDiagnosticas_Leito " + i)
    //let id_infusoes = document.getElementById("txt_id_infusoes_Leito " + i)
    //let id_sinaisVitais = document.getElementById("txt_id_sinaisVitais_Leito " + i)
    //let id_balancoHidrico = document.getElementById("txt_id_balancoHidrico_Leito " + i)
    //let id_nutricional = document.getElementById("txt_id_nutricional_Leito " + i)
    //let id_ventilacao = document.getElementById("txt_id_ventilacao_Leito " + i)
    //let id_gasometria = document.getElementById("txt_id_gasometria_Leito " + i)
    let id_culturas = document.getElementById("txt_id_culturas_Leito " + i)
    let id_examesRelevantes = document.getElementById("txt_id_examesRelevantes_Leito " + i)
    let id_evolucaoClinicaDiaria = document.getElementById("txt_id_evolucaoClinicaDiaria_Leito " + i)
    let id_conduta = document.getElementById("txt_id_conduta_Leito " + i)
    let id_laboratorial = document.getElementById("txt_id_laboratorial_Leito " + i)

    let lbl_nome = document.getElementById("lbl_nome_Leito " + i)
    let lbl_sexo = document.getElementById("lbl_sexo_Leito " + i)
    let lbl_dt_nascimento = document.getElementById("lbl_dtNascimento_Leito " + i)
    let lbl_idade = document.getElementById("lbl_idade_Leito " + i)
    let lbl_convenio = document.getElementById("lbl_convenio_Leito " + i)
    let lbl_dt_internacao = document.getElementById("lbl_dtInternacao_Leito " + i)
    let lbl_peso = document.getElementById("lbl_peso_Leito " + i)
    let lbl_saps3 = document.getElementById("lbl_saps3_Leito " + i)
    let lbl_dias_uti = document.getElementById("lbl_diasUTI_Leito " + i)


    if(statusModalCad == 'fechado'){
        
        id_internacao.style.display = 'none'
        leito.style.display = 'none'

        let ajax = new XMLHttpRequest();
    
        ajax.open('GET','querys_home.php?btnNovoCad=select&NomeLeito=Leito ' + i)
        
        console.log(ajax)

        ajax.onreadystatechange = () =>{
            
            if (ajax.readyState == 4 && ajax.status == 200) {
            

                let campos = ['id_internacao', 'nome_paciente', 'sexo','dt_nascimento','convenio','dt_internacao', 
                'peso', 'saps3','diasUti','id_lista_problemas','id_hipotesesDiagnosticas', 'id_infusoes','id_sinaisVitais',
                'id_balancoHidrico','id_nutricional','id_ventilacao','id_gasometria',
                'id_culturas','id_examesRelevantes','id_evolucaoClinicaDiaria','id_conduta','id_laboratorial','idade']

                for(let i = 0; i <= campos.length + 1; i++){
                    
                    let resultAjax = ajax.responseText

                    let PosIni = resultAjax.indexOf('<' + campos[i] + '>')
                    let PosFim = resultAjax.indexOf('</' + campos[i] + '>')

                    let valorCampo = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')


                    //console.log(resultAjax)
                    
                    if(campos[i] == 'id_internacao'){
                        id_internacao.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'nome_paciente'){
                        nome.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                        lbl_nome.innerText = 'Nome: ' + resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'sexo'){
                        sexo.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                        lbl_sexo.innerText = 'Sexo: ' + resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'dt_nascimento'){
                        dt_nascimento.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                        lbl_dt_nascimento.innerText = 'Dt Nascimento: ' + resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'idade'){
                        lbl_idade.innerText = 'Idade: ' + resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'convenio'){
                        convenio.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                        lbl_convenio.innerText = 'Convenio: ' + resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')    
                    }else if(campos[i] == 'dt_internacao'){
                        dt_internacao.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                        lbl_dt_internacao.innerText = 'Dt Internação: ' + resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'peso'){
                        peso.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                        lbl_peso.innerText = 'Peso: ' + resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'saps3'){
                        saps3.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                        lbl_saps3.innerText = 'Saps3: ' + resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                        if(valorCampo == ''){
                            lbl_saps3.innerText = lbl_saps3.innerText.replaceAll('Saps3:','')
                        }
                    }else if(campos[i] == 'diasUti'){
                        lbl_dias_uti.innerText = 'Dias Uti: ' + resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_lista_problemas'){
                        id_listaProblemas.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_hipotesesDiagnosticas'){
                        id_hipotesesDiagnosticas.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }
                    /*
                    else if(campos[i] == 'id_infusoes'){
                        id_infusoes.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_sinaisVitais'){
                        id_sinaisVitais.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_balancoHidrico'){
                        id_balancoHidrico.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_nutricional'){
                        id_nutricional.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_ventilacao'){
                        id_ventilacao.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_gasometria'){
                        id_gasometria.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }
                    */
                    else if(campos[i] == 'id_culturas'){
                        id_culturas.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_examesRelevantes'){
                        id_examesRelevantes.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_evolucaoClinicaDiaria'){
                        id_evolucaoClinicaDiaria.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_conduta'){
                        id_conduta.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }else if(campos[i] == 'id_laboratorial'){
                        id_laboratorial.value = resultAjax.substring(PosIni,PosFim).replace('<' + campos[i] + '>','')
                    }

                }
                
            }
        
        }

        ajax.send()

        if(e != 'externo'){
            document.getElementById("modalCad_Leito " + i).style.display = 'block'
            statusModalCad = 'aberto'
            clearInterval(x)
        }


    }else{
        document.getElementById("modalCad_Leito " + i).style.display = 'none'
        statusModalCad = 'fechado'

        x = setInterval(function(){
            execTodosSelects('timer')
        },5000)
    }
}

function btnConfirmCad(i){


    let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
    let nome = document.getElementById("txt_nome_Leito " + i)
    let sexo = document.getElementById("txt_sexo_Leito " + i)
    let dt_nascimento = document.getElementById("txt_dt_nascimento_Leito " + i)
    let convenio = document.getElementById("txt_convenio_Leito " + i)
    let dt_internacao = document.getElementById("txt_dt_internacao_Leito " + i)
    let peso = document.getElementById("txt_peso_Leito " + i)
    let saps3 = document.getElementById("txt_saps3_Leito " + i)

    let ajax = new XMLHttpRequest();

    if(id_internacao.value == ''){
        ajax.open('GET', 
        'querys_home.php?btnConfirmCad=insert&NomeLeito=Leito ' + i +
        '&id_internacao=' + encodeURIComponent(id_internacao.value) +
        '&nome=' + encodeURIComponent(nome.value) +
        '&sexo=' + encodeURIComponent(sexo.value) +
        '&dt_nascimento=' + encodeURIComponent(dt_nascimento.value) +
        '&convenio=' + encodeURIComponent(convenio.value) +
        '&dt_internacao=' + encodeURIComponent(dt_internacao.value) +
        '&peso=' + encodeURIComponent(peso.value) +
        '&saps3=' + encodeURIComponent(saps3.value))
    }else{
        ajax.open('GET',
        'querys_home.php?btnConfirmCad=update&NomeLeito=Leito ' + i +
        '&id_internacao=' + encodeURIComponent(id_internacao.value) +
        '&nome=' + encodeURIComponent(nome.value) +
        '&sexo=' + encodeURIComponent(sexo.value) +
        '&dt_nascimento=' + encodeURIComponent(dt_nascimento.value) +
        '&convenio=' + encodeURIComponent(convenio.value) +
        '&dt_internacao=' + encodeURIComponent(dt_internacao.value) +
        '&peso=' + encodeURIComponent(peso.value) +
        '&saps3=' + encodeURIComponent(saps3.value))
    }

    console.log(ajax)


    ajax.send()

    
    document.getElementById("modalCad_Leito " + i).style.display = 'none'
    statusModalCad = 'fechado'

    ajax.onreadystatechange = () =>{
        if (ajax.readyState == 4 && ajax.status == 200) {
            abreModalCad(i,'externo')
        }
    }




}




//* ----------------------- MODAL INVASOES ----------------------- *// 

// ---------------------- Eventos -----------------------------//
var statusModal = 'fechado'

for(let i = 1; i <= 10;i++){
    document.getElementById("btnNovoInvasao_Leito " + i).addEventListener("click", function(){abreModalInvasao('','','','','','Leito ' + i,'interno')})
    document.getElementById("btnCancelarInvasoes_Leito " + i).addEventListener("click", function(){fechaModalInvasao('Leito ' + i)})
}


// ---------------------- Funcoes -----------------------------//
function abreModalInvasao(id,invasao,dtIni,dtFim,obs,leito,e){

    let txt_idInvasao = document.getElementById("txt_idInvasoes_" + leito)
    let txt_Invasao = document.getElementById("txt_invasoes_" + leito)
    let txt_dtIni = document.getElementById("txt_dtInicioInvasoes_" + leito)
    let txt_dtFim = document.getElementById("txt_dtFimInvasoes_" + leito)
    let txt_obs = document.getElementById("txt_obsInvasoes_" + leito)
    let btnExcluir = document.getElementById("btnExcluirInvasoes_" + leito)

    if(statusModal == 'fechado'){
        
        document.getElementById("modalInvasao_" + leito).style.display = 'block'
        statusModal = 'aberto'

        if(e == 'externo'){
            txt_idInvasao.value = id
            txt_Invasao.value = invasao
            txt_dtIni.value = dtIni
            txt_dtFim.value = dtFim
            txt_obs.value = obs

            btnExcluir.style.display = 'inline-block'
        }else{
            txt_idInvasao.value = ''
            txt_Invasao.value = ''
            txt_dtIni.value = ''
            txt_dtFim.value = ''
            txt_obs.value = ''

            btnExcluir.style.display = 'none'  
        }

    }else{
        document.getElementById("modalInvasao_" + leito).style.display = 'none'
        statusModal = 'fechado'
    }
}

function fechaModalInvasao(leito){
    document.getElementById("modalInvasao_" + leito).style.display = 'none'
    statusModal = 'fechado'
}



//* ----------------------- MODAL ANTIBIOTICOS/TRATAMENTOS ----------------------- *// 

// ---------------------- Eventos -----------------------------//
//var statusModal = 'fechado'

for(let i = 1; i <= 10;i++){
    document.getElementById("btnNovoAntibioticos_Leito " + i).addEventListener("click", function(){abreModalAntibiotico('','','','','','Leito ' + i,'interno')})
    document.getElementById("btnCancelarAntibioticos_Leito " + i).addEventListener("click", function(){fechaModalAntibiotico('Leito ' + i)})
}


// ---------------------- Funcoes -----------------------------//
function abreModalAntibiotico(id,antibiotico,dtIni,dtFim,obs,leito,e){

    let txt_idAntibiotico = document.getElementById("txt_idAntibioticos_" + leito)
    let txt_Antibiotico = document.getElementById("txt_antibioticos_" + leito)
    let txt_dtIni = document.getElementById("txt_dtInicioAntibioticos_" + leito)
    let txt_dtFim = document.getElementById("txt_dtFimAntibioticos_" + leito)
    let txt_obs = document.getElementById("txt_obsAntibioticos_" + leito)
    let btnExcluir = document.getElementById("btnExcluirAntibioticos_" + leito)

    if(statusModal == 'fechado'){
        
        document.getElementById("modalAntibiotico_" + leito).style.display = 'block'
        statusModal = 'aberto'

        if(e == 'externo'){
            txt_idAntibiotico.value = id
            txt_Antibiotico.value = antibiotico
            txt_dtIni.value = dtIni
            txt_dtFim.value = dtFim
            txt_obs.value = obs

            btnExcluir.style.display = 'inline-block'
        }else{
            txt_idAntibiotico.value = ''
            txt_Antibiotico.value = ''
            txt_dtIni.value = ''
            txt_dtFim.value = ''
            txt_obs.value = ''

            btnExcluir.style.display = 'none'  
        }

    }else{
        document.getElementById("modalAntibiotico_" + leito).style.display = 'none'
        statusModal = 'fechado'
    }
}

function fechaModalAntibiotico(leito){
    document.getElementById("modalAntibiotico_" + leito).style.display = 'none'
    statusModal = 'fechado'
}




//* ----------------------- MODAL TROCA DE LEITOS ----------------------- *// 

// ---------------------- Eventos -----------------------------//
for(let i = 1; i <= 10;i++){
    document.getElementById("btnTrocarLeitos_Leito " + i).addEventListener("click", function(){abre_modalTrocarLeitos()})
    
}

document.getElementById("btnSalvarTrocaLeitos").addEventListener("click", function(){btnSalvar_TrocarLeitos()})
document.getElementById("btnCancelarTrocaLeitos").addEventListener("click", function(){btnCancelar_TrocarLeitos()})

// ---------------------- Funcoes -----------------------------//
function abre_modalTrocarLeitos(){

    let modal_trocarLeitos = document.getElementById("modalTrocarLeitos")

    for(let i = 1; i <= 10;i++){

        let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
        let nome = document.getElementById("txt_nome_Leito " + i)
        let txt_nomeTrocarLeitos = document.getElementById("txt_nomeTrocarLeitos_" + i)
        let txt_idTrocarLeitos = document.getElementById("txt_idTrocarLeitos_" + i)

        txt_nomeTrocarLeitos.innerText = nome.value
        txt_idTrocarLeitos.value = id_internacao.value

    }

    modal_trocarLeitos.style.display = 'block'

}

function btnCancelar_TrocarLeitos(){

    let modal_trocarLeitos = document.getElementById("modalTrocarLeitos")

    modal_trocarLeitos.style.display = 'none'
}


function btnSalvar_TrocarLeitos(){

    let modal_trocarLeitos = document.getElementById("modalTrocarLeitos")
    let loadingTrocaLeitos = document.getElementById("loadingTrocaLeitos")
    let passou = true
    let LeitosCheck = ''

    for(let i = 1; i <= 10;i++){

        let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
        let nome = document.getElementById("txt_nome_Leito " + i)
        let txt_leitos = document.getElementById("txt_trocarLeitos_" +i)
        let txt_nomeTrocarLeitos = document.getElementById("txt_nomeTrocarLeitos_" + i)
        let txt_idTrocarLeitos = document.getElementById("txt_idTrocarLeitos_" + i)



        if(LeitosCheck.indexOf(txt_leitos.value + ',') != '-1'){
            alert('Um ou mais leitos duplicado(s), verificar: ' + txt_leitos.value)
            for(let e = 1; e <= 10;e++){

                let txt_leitos_check = document.getElementById("txt_trocarLeitos_" + e)

                if(txt_leitos_check.value == txt_leitos.value){
                    txt_leitos_check.style.color = 'red'
                }
            }
            break
        }else if(i == 10 && LeitosCheck.indexOf(txt_leitos.value + ',') == '-1'){
            for(let e = 1; e <= i;e++){

                id_internacao = document.getElementById("txt_idInternacao_Leito " + e)
                nome = document.getElementById("txt_nome_Leito " + e)
                txt_leitos = document.getElementById("txt_trocarLeitos_" + e)
                txt_nomeTrocarLeitos = document.getElementById("txt_nomeTrocarLeitos_" + e)
                txt_idTrocarLeitos = document.getElementById("txt_idTrocarLeitos_" + e)
                
                txt_leitos.style.color = 'black'

                if(id_internacao.value != ''){

                        var ajax = new XMLHttpRequest();
            
                        ajax.open('GET', 
                        'querys_home.php?txt_trocarLeitos=update' +
                        '&id_internacao=' + encodeURIComponent(txt_idTrocarLeitos.value) +
                        '&leito=' + encodeURIComponent(txt_leitos.value))
 
                        console.log(ajax)

                        if(passou == true){
                            display_image('imagens/loading.gif',30, 30,'Loading',loadingTrocaLeitos);
                            passou = false
                        }

                        ajax.send()

                        
                }
            }
            ajax.onreadystatechange = () =>{
                if (ajax.readyState == 4 && ajax.status == 200){
                        alert('Gravado com sucesso!')
                        window.location.reload()
                    }
            }
            break
        }

        LeitosCheck = LeitosCheck + txt_leitos.value + ','

        txt_nomeTrocarLeitos.innerText = nome.value
        txt_idTrocarLeitos.value = id_internacao.value


    

    }
    
    

}




//*----------------------- DAR ALTA OU OBITO ---------------------*//

// ---------------------- Eventos -----------------------------//
for(let i = 1; i <= 10;i++){
    document.getElementById("btn_darAlta_Leito " + i).addEventListener("click", function(){abreModalAlta(i)})
    document.getElementById("btn_darObito_Leito " + i).addEventListener("click", function(){abreModalObito(i)})
    
    document.getElementById("btn_altaSim_Leito " + i).addEventListener("click", function(){darAlta(i,'sim')})
    document.getElementById("btn_altaNao_Leito " + i).addEventListener("click", function(){darAlta(i,'nao')})
    
    document.getElementById("btn_obitoSim_Leito " + i).addEventListener("click", function(){darObito(i,'sim')})
    document.getElementById("btn_obitoNao_Leito " + i).addEventListener("click", function(){darObito(i,'nao')})
}



// ---------------------- Funcoes -----------------------------//
function abreModalAlta(i){
    let modalAlta = document.getElementById("modalAlta_Leito " + i)

    modalAlta.style.display = 'block'
}

function abreModalObito(i){
    let modalObito = document.getElementById("modalObito_Leito " + i)

    modalObito.style.display = 'block'
}

function darAlta(i,confirm){
    
    let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
    let modalAlta = document.getElementById("modalAlta_Leito " + i)
    let loadingAlta = document.getElementById("loadingAlta")
    let passou = true

    if(confirm == 'sim'){
        var ajax = new XMLHttpRequest();
                
        ajax.open('GET', 
        'querys_home.php?darAltaObito=update' +
        '&id_internacao=' + encodeURIComponent(id_internacao.value) +
        '&status_paciente=' + 'alta')

        console.log(ajax)

        display_image('imagens/loading.gif',30, 30,'Loading',loadingAlta);

        ajax.send()


        ajax.onreadystatechange = () =>{
            if (ajax.readyState == 4 && ajax.status == 200){
                //window.location.reload()
                alert('Alta realizada!')
                modalAlta.style.display = 'none'
            }
        }
    }else if(confirm == 'nao'){
        modalAlta.style.display = 'none'
    }

}

function darObito(i,confirm){
    
    let id_internacao = document.getElementById("txt_idInternacao_Leito " + i)
    let modalObito = document.getElementById("modalObito_Leito " + i)
    let loadingObito = document.getElementById("loadingObito")
    let passou = true

    if(confirm == 'sim'){
        var ajax = new XMLHttpRequest();
                
        ajax.open('GET', 
        'querys_home.php?darAltaObito=update' +
        '&id_internacao=' + encodeURIComponent(id_internacao.value) +
        '&status_paciente=' + 'obito')

        console.log(ajax)

        display_image('imagens/loading.gif',30, 30,'Loading',loadingObito);


        ajax.send()

        ajax.onreadystatechange = () =>{
            if (ajax.readyState == 4 && ajax.status == 200){
                //window.location.reload()
                alert('Obito realizado!')
                modalObito.style.display = 'none'
            }
        }
    }else if(confirm == 'nao'){
        modalObito.style.display = 'none'
    }
}




//*----------------------- LABORATORIAL e CLEARENCE CALCULADORA-------------------------*//

// ---------------------- Eventos -----------------------------//

for(let i = 1; i <= 10;i++){
    document.getElementById("btnNovoLaboratorialClearenceCalc_Leito " + i).addEventListener("click", function(){abreCalculadoraClearence(i)})
    document.getElementById("txt_creatininaClearenceCalc_Leito " + i).addEventListener("keyup", function(){calculaClearence(i)})
}

// ---------------------- Funcoes -----------------------------//

function abreCalculadoraClearence(i){

    let modalClearence = document.getElementById("modalClearenceCalc_Leito " + i)

    let txt_creatinina = document.getElementById("txt_creatininaClearenceCalc_Leito " + i)
    let peso = document.getElementById("txt_peso_Leito " + i)
    let idade = document.getElementById("lbl_idade_Leito " + i).innerText.replaceAll(" anos","").replaceAll("Idade: ","")
    let sexo = document.getElementById("txt_sexo_Leito " + i)
    let txtClearence = document.getElementById("txt_resultadoClearenceCalc_Leito " + i)

    document.getElementById("txt_pesoClearenceCalc_Leito " + i).value = peso.value
    document.getElementById("txt_idadeClearenceCalc_Leito " + i).value = idade
    document.getElementById("txt_sexoClearenceCalc_Leito " + i).value = sexo.value

    modalClearence.style.display = 'block'

    txt_creatinina.value = ''
    txtClearence.innerText = 'Clearence: '

    txtClearence.style.background = 'green'
    txtClearence.style.color = '#fff'
    txtClearence.style.textAlign = 'center'
    txtClearence.style.fontSize = '18px'

}


function calculaClearence(i){

    let txt_creatinina = document.getElementById("txt_creatininaClearenceCalc_Leito " + i)
    let peso = document.getElementById("txt_peso_Leito " + i)
    let idade = document.getElementById("lbl_idade_Leito " + i).innerText.replaceAll(" anos","").replaceAll("Idade: ","")
    let sexo = document.getElementById("txt_sexo_Leito " + i)
    let resultado = 0
    let txtClearence = document.getElementById("txt_resultadoClearenceCalc_Leito " + i)


    if(sexo.value == 'Feminino' && txt_creatinina.value > 0){
        resultado = (140 - parseInt(idade)) * peso.value/(txt_creatinina.value * 72)* 0.85
    }else if(sexo.value == 'Masculino' && txt_creatinina.value > 0){
        resultado =  (140 - idade) * peso.value/(txt_creatinina.value * 72)* 1
    }

    txtClearence.style.background = 'green'
    txtClearence.style.color = '#fff'
    txtClearence.style.textAlign = 'center'
    txtClearence.style.fontSize = '18px'
    txtClearence.innerText = 'Clearence: ' + resultado.toFixed(2) + ' ml/min'


}





//* ----------------------- COPIAR TEXTOS ----------------------- *// 

// ---------------------- Eventos -----------------------------//
for(let i = 1; i <= 10;i++){
    document.getElementById("btnCopy_Leito " + i).addEventListener("click", function(){btnCopy(i)})
}

// ---------------------- Funcoes -----------------------------//
function btnCopy(i){

    let modal = document.getElementById('modalTextoCopiado_Leito ' + i)
    let textArea = document.getElementById('txt_textoCopiado_Leito ' + i)
    let txt_lista_problemas = document.getElementById("txt_listaProblemas_Leito " + i)
    let txt_hipoteses_diagnosticas = document.getElementById("txt_hipotesesDiagnosticas_Leito " + i)
    //let txt_infusoes = document.getElementById("txt_infusoes_Leito " + i)
    //let txt_sinaisVitais = document.getElementById("txt_sinaisVitais_Leito " + i)
    //let txt_balancoHidrico = document.getElementById("txt_balancoHidrico_Leito " + i)
    //let txt_nutricional = document.getElementById("txt_nutricional_Leito " + i)
    //let txt_ventilacao = document.getElementById("txt_ventilacao_Leito " + i)
    //let txt_gasometria = document.getElementById("txt_gasometria_Leito " + i)
    let txt_culturas = document.getElementById("txt_culturas_Leito " + i)
    let txt_examesRelevantes = document.getElementById("txt_examesRelevantes_Leito " + i)
    let txt_evolucaoClinicaDiaria = document.getElementById("txt_evolucaoClinicaDiaria_Leito " + i)
    let txt_conduta = document.getElementById("txt_conduta_Leito " + i)
    let txt_laboratorial = document.getElementById("txt_laboratorial_Leito " + i)
    let div_invasoes = document.getElementById("div_invasoes_Leito " + i)
    let div_antibioticos = document.getElementById("div_antibioticos_Leito " + i)

    let lbl_nome = document.getElementById("lbl_nome_Leito " + i)
    let lbl_sexo = document.getElementById("lbl_sexo_Leito " + i)
    let lbl_dt_nascimento = document.getElementById("lbl_dtNascimento_Leito " + i)
    let lbl_idade = document.getElementById("lbl_idade_Leito " + i)
    let lbl_convenio = document.getElementById("lbl_convenio_Leito " + i)
    let lbl_dt_internacao = document.getElementById("lbl_dtInternacao_Leito " + i)
    let lbl_peso = document.getElementById("lbl_peso_Leito " + i)
    let lbl_saps3 = document.getElementById("lbl_saps3_Leito " + i)
    let lbl_dias_uti = document.getElementById("lbl_diasUTI_Leito " + i)
    

    modal.style.display = 'block'

    textArea.innerHTML  = ''

    if(lbl_nome.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + lbl_nome.innerText.replaceAll("Nome: ","").toUpperCase() + '</br>'
    }
    if(lbl_sexo.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + lbl_sexo.innerText.replaceAll("\n","</br>")
    }
    if(lbl_dt_nascimento.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + ' | ' + lbl_dt_nascimento.innerText + lbl_idade.innerText.replaceAll("Idade: ","(") + ')'
    }
    if(lbl_convenio.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + ' | ' + lbl_convenio.innerText.replaceAll("\n","</br>")
    }
    if(lbl_dt_internacao.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + ' | ' + lbl_dt_internacao.innerText.replaceAll("\n","</br>")
    }
    if(lbl_peso.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + ' | ' + lbl_peso.innerText.replaceAll("\n","</br>") + 'kg'
    }
    if(lbl_saps3.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + ' | ' + lbl_saps3.innerText.replaceAll("\n","</br>")
    }
    if(lbl_dias_uti.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + ' | ' + lbl_dias_uti.innerText.replaceAll("\n","</br>")
    }



    if(txt_lista_problemas.innerText != ''){
        textArea.innerHTML  = textArea.innerHTML + '</br></br>' +'#LISTA DE PROBLEMAS'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_lista_problemas.innerText.replaceAll("\n","</br>")
    }

    if(txt_hipoteses_diagnosticas.innerText != ''){
        textArea.innerHTML  = textArea.innerHTML + '</br></br>' +'#HIPÓTESES DIAGNÓSTICAS'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_hipoteses_diagnosticas.innerText.replaceAll("\n","</br>")
    }

    if(txt_examesRelevantes.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#EXAMES RELEVANTES'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_examesRelevantes.innerText.replaceAll("\n","</br>")
    }

    if(txt_laboratorial.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#LABORATORIAL'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_laboratorial.innerText.replaceAll("\n","</br>")
    }
    
    /*
    if(txt_infusoes.value != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#INFUSÕES'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_infusoes.value.replaceAll("\n","</br>")
    }

    if(txt_sinaisVitais.value != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#SINAIS VITAIS'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_sinaisVitais.value.replaceAll("\n","</br>")
    }

    if(txt_balancoHidrico.value != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#BANLANÇO HIDRICO'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_balancoHidrico.value.replaceAll("\n","</br>")
    }

    if(txt_nutricional.value != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#NUTRICIONAL'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_nutricional.value.replaceAll("\n","</br>")
    }

    if(txt_ventilacao.value != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#VENTILAÇÃO'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_ventilacao.value.replaceAll("\n","</br>")
    }

    if(txt_gasometria.value != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#GASOMETRIA'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_gasometria.value.replaceAll("\n","</br>")
    }

    */

    if(div_invasoes.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#INVASÕES'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + div_invasoes.innerText.replaceAll("\n","</br>")
    }


    if(txt_culturas.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#CULTURAS'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_culturas.innerText.replaceAll("\n","</br>")
    }

    if(div_antibioticos.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#ANTIBIÓTICOS/TRATAMENTOS'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + div_antibioticos.innerText.replaceAll("\n","</br>")
    }


    if(txt_evolucaoClinicaDiaria.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#EVOLUÇÃO CLINICA DIÁRIA'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_evolucaoClinicaDiaria.innerText.replaceAll("\n","</br>")
    }

    if(txt_conduta.innerText != ''){
        textArea.innerHTML  =  textArea.innerHTML + '</br></br>' +'#CONDUTA'
        textArea.innerHTML  =  textArea.innerHTML + '</br>' + txt_conduta.innerText.replaceAll("\n","</br>")
    }



    //Copia texto para area de transferencia
    let content = textArea.innerText.replaceAll("<br>","\n")

    navigator.clipboard.writeText(content).then(afterSuccess, afterFailure)
    /*    .then(() => {
        console.log("Text copied to clipboard...")
    })
        .catch(err => {
        console.log('Something went wrong', err);
    })

    */
    

}


function afterSuccess() {
    console.log('Copiado com sucesso!')
}

function afterFailure(error) {
    console.error('A Cópia falhou!', error)
}
