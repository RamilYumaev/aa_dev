var otherDocFull = $("#other-document-full");
var otherAmount = $("div.field-otherdocumentform-amount");
var selectType = $('#otherdocumentform-type');

const typePhoto = 45;
selectType.on("change init", function() {
    if (this.value == typePhoto) {
        otherDocFull.hide();
        otherAmount.show();
    } else {
        otherDocFull.show();
        otherAmount.hide();
    }
});
selectType.trigger("init");

