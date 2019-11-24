var ast = $("#answer-cloze-list");
var divAst = ("div#answer-cloze-type");

var divAstLast = ast.find(divAst).last();
$('#add-answer-cloze-type').click(function () {
    var countast = ast.find(divAst).length;
    var next = countast+1;
    if (countast < 7) {
        $(divAstLast).clone().attr('data-answer-index', next)
            .appendTo(ast);
    }
});

$('#save-cloze').click(function (e) {
    e.preventDefault();
    var valid  = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#form-question-cloze');

    var countAnswerIsNull =  ast.find('textarea').length;
    for (var i = 0; i < countAnswerIsNull; i++) {
        textarea = ast.find('textarea')[i];
        value = $.trim(textarea.value);
        if(!value) {
            textarea.value = "";
            textarea.style = "border: 1px solid red";
            valid = valid && false;
        } else {
            textarea.style = "border: 1px solid green";
        }
    }

    if (valid) {
        form.submit();
    } else {
        error.text(' Необходимо заполнить поля!');
    }
});
