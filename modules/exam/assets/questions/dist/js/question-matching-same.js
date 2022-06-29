var ast = $(".container-items");

$('#save-matching').click(function (e) {
    e.preventDefault();
    var valid  = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#dynamic-form');
    var countQuest = ast.find('input[type=text]').length;
    for (var i = 0; i < countQuest; i++) {
        input = ast.find('input[type=text]')[i];
        value = $.trim(input.value);
        if(!value) {
            input.value = "";
            input.style = "border: 1px solid red";
            valid = valid && false;
        } else {
            input.style = "border: 1px solid green";
        }
    }

    if (valid) {
        form.submit();
    } else {
        error.text(' Необходимо заполнить  все поля!');
    }

});


$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    $(".dynamicform_wrapper .panel-title-address").each(function(index) {
        $(this).html("Вариант ответа: " + (index + 1))
    });

    $(".dynamicform_wrapper .panel-body:last").find("input").each(function() {
        $(this).val("");
    });
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    $(".dynamicform_wrapper .panel-title-address").each(function(index) {
        $(this).html("Вариант ответа: " + (index + 1))
    });
});