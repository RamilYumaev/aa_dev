var faculty = $("div.field-dodcreateform-faculty_id");

$("#dodcreateform-type").on("change", function() {
    if(this.checked){
        faculty.hide()
    } else {
        faculty.show()
    }
});

