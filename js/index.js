$(window).ready(function(){
    if(login == true){
        $(".modal.peca .campo input[name=cep]").prop("disabled", true)
    }
    else{
        $(".modal.peca .campo input[name=cep]").prop("disabled", false)
    }
})

// LOCALIZAÇÃO
function geoSucesso(position) {
    // coordenadas
    let lat = position.coords.latitude
    let lon = position.coords.longitude

    // inserindo valores
    $(".modal.peca .campo input[name=latitude").val(lat)
    $(".modal.peca .campo input[name=longitude").val(lon)

    // btn-local ativo ou não
    let checked = $(".btn-local input[type=checkbox]").prop("checked")

    // btn-local desativado
    if (checked == false) {
        // ativa o btn-local
        $(".btn-local input[type=checkbox]").prop("checked", true)
            // adiciona icone done
        $(".btn-local i").removeClass("local-ativado")
        $(".btn-local i:nth-child(3)").addClass("local-ativado")
            // desabilita e zera campo cep
        $(".modal.peca .campo input[name=cep]").prop("disabled", true)
        $(".modal.peca .campo input[name=cep]").val("")
    }
    // btn-local ativado
    else {
        // desativa o btn-local
        $(".btn-local input[type=checkbox]").prop("checked", false)
            // adiciona o icone my_location
        $(".btn-local i").removeClass("local-ativado")
        $(".btn-local i:nth-child(2)").addClass("local-ativado")
            // habilita o campo cep
        $(".modal.peca .campo input[name=cep]").prop("disabled", false)
            // zera campo latitude e longitude
        $(".modal.peca .campo input[name=latitude").val("")
        $(".modal.peca .campo input[name=longitude").val("")
    }

}
// Erro ao pegar coordenadas
function geoErro() {
    // desabilita btn-local
    $(".btn-local input[type=checkbox]").prop("checked", false)
        // Esclarece o btn-local
    $(".btn-local").css({ "pointer-events": "none", "opacity": ".8" })
        // adiciona o icone close
    $(".btn-local i").removeClass("local-ativado")
    $(".btn-local i:nth-child(4)").addClass("local-ativado")
        // habilita campo cep
    $(".modal.peca .info .campo input[name=cep]").prop("disabled", false)
}

$(".btn-local").click(function() {
    navigator.geolocation.getCurrentPosition(geoSucesso, geoErro)
})

// BTN-USUARIO
$(".usuario h3, .usuario img").click(function() {
    $(".usuario i").toggleClass("user-active");
})
$(document).click(function(e) {
    let usuario = $(".usuario")
    if (!usuario.is(e.target) && usuario.has(e.target).length === 0) {
        $(".usuario i").removeClass("user-active")
    }
})

// BTN-CONTA
$(".btn-conta").click(function() {
    // btn-conta ativo ou não
    let checked = $(".btn-conta input[type=checkbox]").prop("checked")

    // btn-conta desativado
    if (checked == false) {
        // ativa o btn-conta
        $(".btn-conta input[type=checkbox]").prop("checked", true)
        // desabilita e zera campo cep
        $(".modal.peca .campo input[name=cep]").prop("disabled", true)
        $(".modal.peca .campo input[name=cep]").val("")
        // adiciona latitude e longitude
        $(".modal.peca .campo input[name=latitude").val(lat_usu)
        $(".modal.peca .campo input[name=longitude").val(lon_usu)
        // icones
        $(".container-modal .btn-conta i").toggleClass("local-ativado")
    }
    // btn-local ativado
    else {
        // desativa o btn-local
        $(".btn-conta input[type=checkbox]").prop("checked", false)
        // habilita o campo cep
        $(".modal.peca .campo input[name=cep]").prop("disabled", false)
        // zera campo latitude e longitude
        $(".modal.peca .campo input[name=latitude").val("")
        $(".modal.peca .campo input[name=longitude").val("")
        // icones
        $(".container-modal .btn-conta i").toggleClass("local-ativado")
    }
})

// MODAL
$(".container-modal").click(function(e) {
    let modal = $(".modal")
    if (!modal.is(e.target) && modal.has(e.target).length === 0) {
        if(login != true){
            // desabilita btn-local
            $(".btn-local input[type=checkbox]").prop("checked", false)
            // adiciona icone my_location
            $(".btn-local i").removeClass("local-ativado")
            $(".btn-local i:nth-child(2)").addClass("local-ativado")
            // habilita campo cep
            $(".modal.peca .info .campo input[name=cep]").prop("disabled", false)
            // zera campo latitude e longitude
            $(".modal.peca .campo input[name=latitude").val("")
            $(".modal.peca .campo input[name=longitude").val("")
            // zera status dos campos
            $(".modal.peca .status i").addClass("desativado")
            // zera option dos selects
            $(".modal.peca .modelo .option").html("")
        }else{
            // ativa o btn-conta
            $(".btn-conta input[type=checkbox]").prop("checked", true)
            // desabilita e zera campo cep
            $(".modal.peca .campo input[name=cep]").prop("disabled", true)
            $(".modal.peca .campo input[name=cep]").val("")
            // adiciona latitude e longitude
            $(".modal.peca .campo input[name=latitude").val(lat_usu)
            $(".modal.peca .campo input[name=longitude").val(lon_usu)
            // icones
            $(".container-modal .btn-conta i").removeClass("local-ativado")
            $(".container-modal .btn-conta i:nth-child(3)").addClass("local-ativado")
        }
    }
})
    // VALIDAÇÃO CEP
$(".modal.peca .campo input[name=cep]").keyup(function() {
    let tamanho = $(this).val().length
        // adiciona animacao de busca
    $(".modal.peca .status i").addClass("desativado")
    $(".modal.peca .status .busca").removeClass("desativado")

    // retira animcacao de busca
    if (tamanho == 0) {
        $(".modal.peca .status i").addClass("desativado")
        $(".modal.peca .desativado input").val("")
    }
    // Força um focusout
    else if (tamanho == 8) {
        $(this).blur()
    }
})

$(".modal.peca .campo input[name=cep]").focusout(function() {
    let cep = $(this).val()

    $.get("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
        // sucesso
        if (dados.erro != true) {
            // animacao
            $(".modal.peca .status i").addClass("desativado")
            $(".modal.peca .status .sucesso").removeClass("desativado")
        }
        // erro
        else {
            // animacao
            $(".modal.peca .status i").addClass("desativado")
            $(".modal.peca .status .erro").removeClass("desativado")
        }
        let local = dados.logradouro
        $endereco = local.replace(/ /g, "+")

        $.get("https://maps.google.com/maps/api/geocode/json?address=" + $endereco + "&key=AIzaSyC-5rJINp8dnT7bpltaO2b0jKE_Y1Nci9g", function(coor) {
            lat = coor.results[0].geometry.location.lat
            lon = coor.results[0].geometry.location.lng;

            // inserindo valores
            $(".modal.peca .campo input[name=latitude").val(lat)
            $(".modal.peca .campo input[name=longitude").val(lon)
        })
    }, "jsonp")
})

// BUSCAR MODELOS
$(".modal.peca .marca .option p").click(function() {
    let marca = $(this).prop("id")
    $(".modal.peca .marca .status i").removeClass("desativado")

    $(".modal.peca .modelo .select input").val("")
    $(".modal.peca .modelo .option").html("")

    $.get("php/buscar_modelo.php", { marca: marca }, function(data) {
        array = JSON.parse(data)

        array.forEach(element => {
            id = element["id_mod"]
            modelo = element["nome_mod"]

            $(".modal.peca .modelo .option").append("<p id='" + id + "'>" + modelo + "</p>")
        })

        $(".modal.peca .modelo .select input").val(array[0]["nome_mod"])
    }).done(function(){
        $(".modal.peca .marca .status i").addClass("desativado")
    })
})

// PECA - MODAL
$(".btn-peca").click(function(){
    $(".container-modal .modal").hide()
    $(".container-modal .peca").show()
    $(".container-modal").fadeIn(200)
})

// PITCH - MODAL
$(".btn-pitch").click(function(){
    $(".container-modal .modal").hide()
    $(".container-modal .modal-pitch").show()
    $(".container-modal").fadeIn(200)
})