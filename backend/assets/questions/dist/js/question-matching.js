var ast = $(".container-items");

$('#save-matching').click(function (e) {
    e.preventDefault();
    var valid  = true;
    var error = $("#error-message");
    error.text("");
    var form = $('#dynamic-form');
    var countQuest =  ast.find('input[name$="name]"]').length;
    console.log(countQuest);
    if (valid) {
        form.submit();
    } else {
        error.text(' Необходимо заполнить  все поля!');
    }
});
