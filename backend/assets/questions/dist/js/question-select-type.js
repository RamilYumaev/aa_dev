var ast = $(".container-items");

$('#save-answer-select-type').click(function (e) {
    e.preventDefault();
    var valid = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#dynamic-form');
    var countInputAnswer = ast.find('input[type="text"]').length;
    var countCheckAnswer = ast.find('input:checked').length;
    if (countInputAnswer < 3) {
        error.text('Заполните миниум 3 варианта ответа ');
        valid = valid && false;
    }
    if (countInputAnswer > 2 && countCheckAnswer < 2) {
        error.text('Правильных ответов должно быть не меньше 2-х.');
        valid = valid && false;
    }
    if (valid) {
        form.submit();
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