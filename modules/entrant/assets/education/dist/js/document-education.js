var noFioProfile = $("#no-fio-profile");
var checked = $('#documenteducationform-fio');
checked.on("change init", function() {
    if (this.checked) {
        noFioProfile.hide()
    } else {
        noFioProfile.show();
    }
});
checked.trigger("init");

