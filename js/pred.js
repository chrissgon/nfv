// MODAL
$(".btn-modal").click(function(){
    $("body").css("overflow", "hidden");
    $(".container-modal").fadeIn(100);
})
$(".container-modal").click(function(e){
    let modal = $(".modal")
    if(!modal.is(e.target) && modal.has(e.target).length === 0){
        $("body").css("overflow", "auto");
        $(".container-modal").fadeOut(100);
        $(".modal .campo input").val("")
    }
})
$(".btn-modal-close").click(function(){
    $("body").css("overflow", "auto");
    $(".container-modal").fadeOut(100);
})

// NAV
$(".btn-menu").click(function(){
    $(".menu").toggleClass("menuIn")
})
$(document).click(function(e){
    let menu = $(".menu");
    let btn = $(".btn-menu");
    if(!menu.is(e.target) && menu.has(e.target).length === 0 && !btn.is(e.target) && btn.has(e.target).length === 0){
        $(".menu").removeClass("menuIn")
    }
})
$(".menu .header i, .menu .aba").click(function(){
    let aba = $(this).prop("class").split(" ")[1]
    $(".menu .header i, .menu .aba").removeClass("aba-ativa")
    $(".menu .header i."+aba+", .menu .aba."+aba+"").addClass("aba-ativa")
    $(".container").hide()
    $(".container."+aba+"").show()
    $(".menu").removeClass("menuIn")
})

// FORMULARIO
$(".campo .select").click(function(){
    let This = $(this).closest(".campo")
    $(".select input", This).focus()
    $("i", this).toggleClass("arrow-rotate")
    $(".option", This).toggleClass("view-option")
})
$(".select input").focusout(function(){
    let This = $(this).closest(".campo")
    setTimeout(function(){
        $("i", This).removeClass("arrow-rotate")
        $(".option", This).removeClass("view-option")
    }, 100)
})
$(document).on("click", ".option p", function(){
    let This = $(this).closest(".campo")
    let valor = $(this).text()
    $(".select input", This).val(valor)
    $(".option", This).removeClass("view-option")
})