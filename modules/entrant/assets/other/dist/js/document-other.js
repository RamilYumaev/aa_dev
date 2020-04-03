var otherDocFull = $("#other-document-full");
var selectType = $('#otherdocumentform-type');

const typePhoto = 45;
selectType.on("change init", function() {
    if (this.value == typePhoto) {
        otherDocFull.hide();
    } else {
        otherDocFull.show();
    }
});
selectType.trigger("init");

