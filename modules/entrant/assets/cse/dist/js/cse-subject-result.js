
$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    $(".dynamicform_wrapper .panel-title-address").each(function(index) {
        $(this).html("Предмет ЕГЭ: " + (index + 1))
    });
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    $(".dynamicform_wrapper .panel-title-address").each(function(index) {
        $(this).html("Предмет ЕГЭ: " + (index + 1))
    });
});
