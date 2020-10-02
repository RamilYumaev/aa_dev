var ast = $(".container-items");


$('#save-answer-short').click(function (e) {
    e.preventDefault();
    var valid  = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#dynamic-form');

    var countAnswerIsNull =  ast.find('input[type=text]').length;
    for (var i = 0; i < countAnswerIsNull; i++) {
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

    var vals = new Array();
    ast.find('input[type="text"]').each(function() {
        if($.inArray($(this).val(), vals) == -1) { //Not found
            vals.push($(this).val());
        } else {
            alert("Одинаковые ответы: " + $(this).val()  );
            valid = valid && false;
        }
    });

    if (valid) {
        form.submit();
    } else {
        error.text(' Необходимо заполнить  варианты ответов!');
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
