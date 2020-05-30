    var faculty = $("div.field-jobentrantform-faculty_id");
    var category_id = $("#jobentrantform-category_id");

    const fok = 3;

    if(category_id.val()== fok) {
        faculty.show();
    }else {
        faculty.hide();
    }

    category_id.on("change", function() {
        if (this.value == "") {
            faculty.hide()
        } else if (this.value == fok) {
            faculty.show();
        }
        else {
            faculty.hide();
            }
    });