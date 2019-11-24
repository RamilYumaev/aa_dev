var ast = $("#answer-matching-list");
var divAst = ("div#answer-matching");

var divAstLast = ast.find(divAst).last();
$('#add-answer-matching').click(function () {
    var countast = ast.find(divAst).length;
    var next = countast+1;
    if (countast < 7) {
        $(divAstLast).clone().attr('data-answer-index', next)
            .find('label:first')
            .text('Вопрос ' + next)
            .end()
            .find('input[type=text]')
            .val('')
            .end()
            .find('label:last')
            .text('Ответ ' + next)
            .end()
            .appendTo(ast);
    }
});

$('#save-matching').click(function (e) {
    e.preventDefault();
    var valid  = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#form-question-matching');

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
        error.text(' Необходимо заполнить  все поля!');
    }
});
