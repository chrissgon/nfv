$(document).ready(function(){
    $(".comprador input").prop("disabled", true)
    $(".campo input").val("")
})

// CONTA
$(".conta .opcao").click(function(){
    // remove
    $("input[type=checkbox]").prop("checked", false)
    $(".opcao label").removeClass("label-active")
    // add
    $("input[type=checkbox]", this).prop("checked", true)
    $("label", this).addClass("label-active")

    // info
    let info = $("input[type=checkbox]", this).prop("name")
    $(".info").hide()
    $(".info input").prop("disabled", true)
    $(".info input").val("")
    $("."+info+"").show();
    $("."+info+" input").prop("disabled", false)
    $(".status i").addClass("desativado")
})

// INPUT DESATIVADO
$(".info .desativado input").focus(function(){
    $(this).blur()
})

// VALIDAÇÃO CNPJ
$(".fornecedor .campo input[name=cnpj]").keyup(function(){
    let tamanho = $(this).val().length

    $(".fornecedor .status i").addClass("desativado")
    $(".fornecedor .status .busca").removeClass("desativado")

    if(tamanho == 0){
        $(".fornecedor .status i").addClass("desativado")
        $(".fornecedor .desativado input").val("")
    }
    else if(tamanho == 14){
        $(this).blur()
        $(".fornecedor .desativado input").val("")
    }
})

$(".fornecedor .campo input[name=cnpj]").focusout(function(){
    let cnpj = $(this).val()

    $.get("https://www.receitaws.com.br/v1/cnpj/"+cnpj,  function(dados){
        // sucesso
        if(dados.status == "OK"){
            // animacao
            $(".fornecedor .status i").addClass("desativado")
            $(".fornecedor .status .sucesso").removeClass("desativado")

            // nome
            $(".fornecedor .campo input[name=rs]").val(dados.nome.toLowerCase().replace(/(?:^|\s)\S/g, function(a) {return a.toUpperCase()}))
            // cep
            let cep = dados.cep.replace(/[^0-9]/g,'')
            $(".fornecedor .campo input[name=cep]").val(cep)
            // endereco
            $(".fornecedor .campo input[name=endereco]").val(dados.logradouro.toLowerCase().replace(/(?:^|\s)\S/g, function(a) {return a.toUpperCase()})+", "+dados.numero)
            // email
            $(".fornecedor .campo input[name=email]").val(dados.email)
        }
        // erro
        else{
            // animacao
            $(".fornecedor .status i").addClass("desativado")
            $(".fornecedor .status .erro").removeClass("desativado")
        }

    }, "jsonp")
})

// VALIDAÇÃO CEP
$(".comprador .campo input[name=cep]").keyup(function(){
    let tamanho = $(this).val().length

    $(".comprador .status i").addClass("desativado")
    $(".comprador .status .busca").removeClass("desativado")

    if(tamanho == 0){
        $(".comprador .status i").addClass("desativado")
        $(".comprador .desativado input").val("")
    }
    else if(tamanho == 8){
        $(this).blur()
        $(".comprador .desativado input").val("")
    }
})

$(".comprador .campo input[name=cep]").focusout(function(){
    let cep = $(this).val()

    $.get("https://viacep.com.br/ws/"+cep+"/json/?callback=?", function(dados){
        // sucesso
        if(dados.erro != true){
            // animacao
            $(".comprador .status i").addClass("desativado")
            $(".comprador .status .sucesso").removeClass("desativado")
            $(".comprador .campo input[name=endereco]").val(dados.logradouro)
        }
        // erro
        else{
            // animacao
            $(".comprador .status i").addClass("desativado")
            $(".comprador .status .erro").removeClass("desativado")
        }
    }, "jsonp")
})