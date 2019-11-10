var faculty = $("div.field-dodeditform-faculty_id");
var typeCh = $("#dodeditform-type");

typeCh.on("change init", function() {
    if(this.checked){
        faculty.hide()
    } else {
        faculty.show()
    }
}).trigger("init");