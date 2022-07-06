var ast = $(".container-items");

$('#save-answer-select-type-one').click(function (e) {
    e.preventDefault();
    var valid = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#dynamic-form');
    var countInputAnswer = ast.find('input[type="text"]').length;

    var countCheckAnswer = ast.find('select option:selected[value="1"]').length;
    if (countInputAnswer < 2) {
        error.text('Заполните миниум 2 варианта ответа ');
        valid = valid && false;
    }

    if (countInputAnswer > 1 && countCheckAnswer !== 1) {
        error.text('Должен быть один правильный ответ');
        valid = valid && false;
    }

    var vals = new Array();
    ast.find('input[type="text"]').each(function() {
        if($.inArray($(this).val(), vals) == -1) { //Not found
            vals.push($(this).val());
        } else {
            alert("Одинаковые ответы: " + $(this).val());
            valid = valid && false;
        }
    });

    if (valid) {
        form.submit();
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
