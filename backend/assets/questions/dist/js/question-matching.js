var ast = $(".container-items");

$('#save-matching').click(function (e) {
    e.preventDefault();
    var valid  = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#dynamic-form');
    var countQuest =  ast.find('input[name$="name]"]').length;
    var vals = new Array();
    ast.find('input[name$="answer_match]').each(function() {
        if($.inArray($(this).val(), vals) == -1) { //Not found
            vals.push($(this).val());
        } else {
            alert("Одинаковые сопоставления: " + $(this).val()  );
            valid = valid && false;
        }
    });

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
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    $(".dynamicform_wrapper .panel-title-address").each(function(index) {
        $(this).html("Вариант ответа: " + (index + 1))
    });
});