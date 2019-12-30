// MODAL
$(".peca .item .opcoes .sobre").click(function(){
    id = $(this).closest(".item").prop("id")
    $.post("php/buscar_fornecedor.php", {id:id}, function(data){
        array_for_lista = JSON.parse(data)
        // MAPA

        lat_for = array_for_lista.lat_for
        lon_for = array_for_lista.lon_for
        end_for = array_for_lista.end_for

        $(".fornecedores .info .sobre a, .fornecedores .info .mapaFornecedor a").prop("href", "https://www.google.com/maps/dir/?api=1&origin="+lat+","+lon+"&destination="+end_for+"")
        // localizacao fornecedor
        let latlng = new google.maps.LatLng(lat_for, lon_for);
        // predefinicoes
        let options = {
            zoom: 15,
            center: latlng,
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'style'],
            disableDefaultUI: true
        }
        // carregando o mapa
        let map = new google.maps.Map(document.getElementById("mapaFornecedor"), options);

        // Marcador usuario
        let marcadorFornecedor = new google.maps.Marker({
            position: latlng,
            map: map,
            title: array_for_lista.rs_for,
        })

        // Estilo do mapa
        let style = [
            {
            "featureType": "administrative.land_parcel",
            "elementType": "labels",
            "stylers": [
                {
                "visibility": "off"
                }
            ]
            },
            {
            "featureType": "poi",
            "elementType": "labels.text",
            "stylers": [
                {
                "visibility": "off"
                }
            ]
            },
            {
            "featureType": "poi.business",
            "stylers": [
                {
                "visibility": "off"
                }
            ]
            },
            {
            "featureType": "poi.park",
            "elementType": "labels.text",
            "stylers": [
                {
                "visibility": "off"
                }
            ]
            },
            {
            "featureType": "road.arterial",
            "elementType": "labels",
            "stylers": [
                {
                "visibility": "off"
                }
            ]
            },
            {
            "featureType": "road.highway",
            "elementType": "labels",
            "stylers": [
                {
                "visibility": "off"
                }
            ]
            },
            {
            "featureType": "road.local",
            "stylers": [
                {
                "visibility": "off"
                }
            ]
            },
            {
            "featureType": "road.local",
            "elementType": "labels",
            "stylers": [
                {
                "visibility": "off"
                }
            ]
            }
        ]

        var styledMap = new google.maps.StyledMapType(style,{
            name: 'style'
        })

        // Aplicando as configurações do mapa
        map.mapTypes.set('style', styledMap)
        map.setMapTypeId('style')

        // SOBRE
        $(".fornecedores .info .sobre .rs").html(array_for_lista.rs_for)
        $(".fornecedores .info .sobre .descricao").html(array_for_lista.des_for)
    }).done(function(){
        $(".container-modal .modal").hide()
        $(".container-modal .fornecedores").show()
        $(".container-modal").fadeIn(200)
    })
})

// CHAT
$(".item .opcoes .chat").click(function(){
  // pegando id
  id_for = $(this).closest(".item").prop("id")
  id_pec = $(this).closest(".opcoes").prop("id")

  // resetando valores
  $(".modal.chat textarea[name=mensagem").val("")

  // realizando veirificacoes
  if(id_com == false){
    // mensagem de erro
    $(".mensagem").show()
    setTimeout(() => {
      $(".mensagem").hide()
    }, 5000);
  }else{
    // abrindo modal
    $(".container-modal .modal").hide()
    $(".container-modal .chat").show()
    $(".container-modal").fadeIn(200)
    // adicionando valores
    $(".container-modal .chat input[name=fornecedor]").val(id_for)
    $(".container-modal .chat input[name=peca]").val(id_pec)
  }
})

$(".submitChat").click(function(){
    // pegando valores
    fornecedor = $(".container-modal .chat input[name=fornecedor]").val()
    peca = $(".container-modal .chat input[name=peca]").val()
    mensagem = $(".modal.chat textarea[name=mensagem").val()

    // verificacoes de mensagem vazia
    if(mensagem == ""){
      // mensagem de erro
      $(".mensagem p").html("Escreva uma mensagem ao fornecedor")
      $(".mensagem").show()
    }
    else{
      // tela de loading
      $(".load").fadeIn(200)
      // funcao ajax
      $.post("php/chat.php", {fornecedor:fornecedor, peca:peca, mensagem:mensagem}, function(data){
        // mostrando mensagem retornada
        $(".mensagem p").html(data)
        $(".mensagem").show()
        setTimeout(() => {
            $(".mensagem").hide()
        }, 5000);
      }).done(function(){
        // fechando modal
        $(".load").fadeOut(200);
        $(".container-modal").fadeOut(200)
        $(".container-modal .modal").hide()
      })
    }
})

// FAVORITOS
$(".item .opcoes .favoritos").click(function(){
    checked = $(".status_fav", this).prop("checked")
    id_pec = $(this).closest(".opcoes").prop("id")

    // verifica se o usuario está logado
    if(id_com == false){
      $(".mensagem").show()
      setTimeout(() => {
        $(".mensagem").hide()
      }, 5000);
    }
    else{
      // favoritar ou desfavoritar
      if(checked == false){
        // habilitar input
        $(".status_fav", this).prop("checked", true)
        // animação favoritar
        $("i", this).addClass("favoritado")

        $.post("php/favoritos_status.php", {status:checked, peca:id_pec, comprador:id_com})
      }else{
        // habilitar input
        $(".status_fav", this).prop("checked", false)
        // animação favoritar
        $("i", this).removeClass("favoritado")

        $.post("php/favoritos_status.php", {status:checked, peca:id_pec, comprador:id_com})
      }
    }
})

// BUSCAR MODELO
$(".marca .option p").click(function(){
    let marca = $(this).prop("id")

    $(".modelo .option").html("")

    $.get("php/buscar_modelo.php", {marca:marca}, function(data){
        array = JSON.parse(data)

        array.forEach(element => {
            id = element["id_mod"]
            modelo = element["nome_mod"]

            $(".modelo .option").append("<p id="+id+">"+modelo+"</p>")
        })

        $(".modelo .select input").val(array[0]["nome_mod"])
    })
})

// VISUALIZAR PREÇO - FILTRO
$(".range input[type=range]").on("input", function(){
    This = $(this).closest(".range")
    rangeMin = $("input.min", This)
    rangeMax = $("input.max", This)
    valMin = parseInt($("input.min", This).val())
    valMax = parseInt($("input.max", This).val())

    if(valMin > valMax){
        rangeMax.val(valMin)
    }
    if(valMax < valMin){
        rangeMin.val(valMax)
    }

    $("p.min", This).html(valMin)
    $("p.max", This).html(valMax)

})

// FILTRO - FORNECEDORES
$("p.fornecedor").click(function(){
  $(".fornecedor i:nth-child(1)").removeClass("check")
  $(".fornecedor i:nth-child(2)").addClass("check")

  $("i:nth-child(2)", this).removeClass("check")
  $("i:nth-child(1)", this).addClass("check")

  $("input[type=radio]", this).prop("checked", true)
})

// RESULTADOS - VISUALIZACAO
$(".resultados .visualizacao i").click(function(){
    $(".resultados .visualizacao i").addClass("visualizacao-ativa")
    $(this).removeClass("visualizacao-ativa")
    container = $(this).prop("id")
    $(".resultados .container").hide()
    $(".resultados .container."+container+"").show()
    $(".resultados .organizador .pesquisa, .resultados .organizador .pesquisa i").toggleClass("pesquisa-ativa")
    initialize()
})

// FILTRO - NOME
$(".pesquisa input[name=pesquisa]").keyup(function(){
    var texto = $(this).val();

    $(".lista .item").show();
    $(".lista .item").each(function(){
        if($(".nome" ,this).text().toUpperCase().indexOf(texto.toUpperCase()) < 0)
           $(this).hide();
    });
});

// MAPA GOOGLE API
// funcao de inicializacao do mapa
function initialize(){
    // zoom automatico
    bounds  = new google.maps.LatLngBounds();

    // localizacao usuario
    let latlng = new google.maps.LatLng(lat, lon);

    // predefinicoes
    let options = {
        zoom: 13,
        center: latlng,
        mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'style'],
        disableDefaultUI: true
    }

    // carregando o mapa
    let map = new google.maps.Map(document.getElementById("mapaContainer"), options);

    // Marcador usuario
    let marcadorUsuario = new google.maps.Marker({
        position: latlng,
        map: map,
        icon: 'img/icone-usuario.png',
        title: 'Sua localização',
        animation: google.maps.Animation.BOUNCE,
    })

    bounds.extend(latlng)

    let infowindow = new google.maps.InfoWindow({
        content: "<header class='header-mapa'><h3>Sua localização</h3></header>",
        maxWidth: 700
    })
    google.maps.event.addListener(marcadorUsuario, 'click', function() {
        infowindow.open(map,marcadorUsuario);
    })

    // Marcador fornecedores
    function addMarker(location, icon, name, info){
        let marker = new google.maps.Marker({
            position: location,
            map: map,
            icon: icon,
            title: name
        })

        // Janela de informacao
        let infowindow = new google.maps.InfoWindow({
            content: info,
            maxWidth: 700
        })
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        })
    }
    array_for.forEach(dados => {
        // declarando localizacao
        let loc = new google.maps.LatLng(dados.lat_for, dados.lon_for)
        let end = dados.end_for.replace(/ /g, "+").replace(",", "")
        let rs = dados.rs_for.replace(/ /g, "+")


        // criando mensagem
        let info = "<header class='header-mapa'><h3>"+dados.rs_for+"</h3><p>"+dados.end_for+"</p><a href='https://www.google.com/maps/dir/?api=1&origin="+lat+","+lon+"&destination="+end+"' target='_blank' id='"+dados.id_for+"'><i class='material-icons'>near_me</i>Rotas</a></header>"

        // criando marcador
        addMarker(loc, 'img/icone-fornecedor.png', dados.rs_for, info)
        bounds.extend(loc)

        map.fitBounds(bounds);
        map.panToBounds(bounds);

    })

    // Estilo do mapa
    let style = [
        {
          "featureType": "administrative.land_parcel",
          "elementType": "labels",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "poi",
          "elementType": "labels.text",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "poi.business",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "poi.park",
          "elementType": "labels.text",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "road.arterial",
          "elementType": "labels",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "road.highway",
          "elementType": "labels",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "road.local",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        },
        {
          "featureType": "road.local",
          "elementType": "labels",
          "stylers": [
            {
              "visibility": "off"
            }
          ]
        }
      ]

    var styledMap = new google.maps.StyledMapType(style,{
        name: 'style'
    })

    // Aplicando as configurações do mapa
    map.mapTypes.set('style', styledMap);
    map.setMapTypeId('style');
}

// carregar maps de forma assincrona
function loadScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyC-5rJINp8dnT7bpltaO2b0jKE_Y1Nci9g&callback=initialize";

    document.body.appendChild(script);
}
window.onload = loadScript;