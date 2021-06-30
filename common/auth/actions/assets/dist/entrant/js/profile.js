    var faculty = $("div.field-jobentrantform-faculty_id");
    var post = $("div.field-jobentrantform-post");
    var examiner = $("div.field-jobentrantform-examiner_id");
    var category_id = $("#jobentrantform-category_id");

    const fok = 3;
    const exam = 9;
    const transfer = "15";

    if(category_id.val() == fok) {
        examiner.hide();
        post.show();
        faculty.show();
    }else {
        post.hide();
        faculty.hide();
    }

    if(category_id.val() == transfer) {
        examiner.hide();
        post.hide();
        faculty.show();
    }else {
        faculty.hide();
    }

    if(category_id.val() == exam) {
        examiner.show();
        faculty.hide();
        post.hide();
    }else {
        examiner.hide();
    }

    category_id.on("change", function() {
        if (this.value == "") {
            faculty.hide();
            post.hide();
            examiner.hide()
        } else if (this.value == fok) {
            examiner.hide();
            faculty.show();
            post.show();
        }
        else if (this.value == transfer) {
            examiner.hide();
            faculty.show();
       }
        else if (this.value == exam) {
            examiner.show();
            post.hide();
            faculty.hide();
        }
        else {
            post.hide();
            faculty.hide();
            examiner.hide();
        }
    });