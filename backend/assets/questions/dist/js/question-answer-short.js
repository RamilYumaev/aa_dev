var ast = $("#answer-short-list");
var divAst = ("div#answer-short");

var divAstLast = ast.find(divAst).last();
$('#add-answer-short').click(function () {
    var countast = ast.find(divAst).length;
    var next = countast+1;
    if (countast < 7) {
        $(divAstLast).clone().attr('data-answer-index', next)
            .find('label:first')
            .text('Вариант ответа ' + next)
            .end()
            .find('input[type=text]')
            .val('')
            .end()
            .appendTo(ast);
    }
});

$('#save-answer-short').click(function (e) {
    e.preventDefault();
    var valid  = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#form-question-answer-short');

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

    if (valid) {
        form.submit();
    } else {
        error.text(' Необходимо заполнить  варианты ответов!');
    }
});
