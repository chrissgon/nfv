// VALIDAÇÃO CEP
$(".campo input[name=cep]").keyup(function(){
    let tamanho = $(this).val().length

    // animacao
    $(".progresso .indicador:nth-child(2) i").addClass("desativado")
    $(".progresso .indicador:nth-child(2) i:nth-child(2)").removeClass("desativado")

    if(tamanho == 0){
        $(".progresso .indicador:nth-child(2) i").addClass("desativado")
        $(".progresso .indicador:nth-child(2) i:nth-child(3)").removeClass("desativado")
    }
    else if(tamanho == 8){
        $(this).blur()
        $(".desativado input").val("")
    }
})

$(".campo input[name=cep]").focusout(function(){
    let cep = $(this).val()

    $.get("https://viacep.com.br/ws/"+cep+"/json/?callback=?", function(dados){
        // sucesso
        if(dados.erro != true){
            // animacao
            $(".progresso .indicador:nth-child(2) i").addClass("desativado")
            $(".progresso .indicador:nth-child(2) i:nth-child(1)").removeClass("desativado")
            $(".campo input[name=endereco]").val(dados.logradouro)
        }
        // erro
        else{
            // animacao
            $(".progresso .indicador:nth-child(2) i").addClass("desativado")
            $(".progresso .indicador:nth-child(2) i:nth-child(3)").removeClass("desativado")
        }
    }, "jsonp")
})

// ENDERECO
$(".campo input[name=endereco]").focus(function(){
    $(this).blur();
})