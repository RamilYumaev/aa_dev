var code = $("div.form-group.field-passportdataform-division_code");
var selectType = $('#passportdataform-type');

const passportRussia = 1;
selectType.on("change init", function() {
    if (this.value == passportRussia) {
        code.show();
    } else {
        code.hide();
    }
});
selectType.trigger("init");
