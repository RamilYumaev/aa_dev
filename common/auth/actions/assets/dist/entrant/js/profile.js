    var faculty = $("div.field-jobentrantform-faculty_id");
    var examiner = $("div.field-jobentrantform-examiner_id");
    var category_id = $("#jobentrantform-category_id");

    const fok = 3;
    const exam = 9;

    if(category_id.val() == fok) {
        examiner.hide();
        faculty.show();
    }else {
        faculty.hide();
    }

    if(category_id.val() == exam) {
        examiner.show();
        faculty.hide();
    }else {
        examiner.hide();
    }

    category_id.on("change", function() {
        if (this.value == "") {
            faculty.hide()
            examiner.hide()
        } else if (this.value == fok) {
            examiner.hide();
            faculty.show();
        }
        else if (this.value == exam) {
            examiner.show();
            faculty.hide();
        }
        else {
            faculty.hide();
            examiner.hide();
            }
    });