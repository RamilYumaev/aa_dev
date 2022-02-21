var formOfPassage = $("div.field-olimpiclisteditform-form_of_passage");
var mpguStatus = $("div.field-olimpiclisteditform-only_mpgu_students");
var typeOfTime = $("div.field-olimpiclisteditform-time_of_distants_tour");
var hideTypeOfTime = $("div.field-olimpiclisteditform-time_of_distants_tour_type");
var hideTimeOfOchTour = $("div.field-olimpiclisteditform-date_time_start_tour");
var hideDateTimeStartOchTour = $("div.field-olimpiclisteditform-date_time_start_tour");
var hideAddress = $("div.field-olimpiclisteditform-address");
var hideTimeOchTur = $("div.field-olimpiclisteditform-time_of_tour");
var hideZaochRequired = $("div.field-olimpiclisteditform-requiment_to_work_of_distance_tour");
var hideOchRequired = $("div.field-olimpiclisteditform-requiment_to_work");
var hideZaochCriteria = $("div.field-olimpiclisteditform-criteria_for_evaluating_dt");
var hideOchCriteria = $("div.field-olimpiclisteditform-criteria_for_evaluating");
var calculate = $("div.field-olimpiclisteditform-percent_to_calculate");


$("#olimpiclisteditform-number_of_tours").on("change init", function() {
    if(this.value == 2){
        hideTimeOfOchTour.show();
        hideDateTimeStartOchTour.show();
        hideAddress.show();
        hideTimeOchTur.show();
        hideOchRequired.show();
        hideOchCriteria.show();
        hideZaochRequired.show();
        hideZaochCriteria.show();
        hideTypeOfTime.show();
        calculate.show();
    }else{
        hideTypeOfTime.hide();
        hideTimeOfOchTour.hide();
        hideDateTimeStartOchTour.hide();
        hideAddress.hide();
        typeOfTime.hide();
        hideTimeOchTur.hide();
        hideOchRequired.hide();
        hideOchCriteria.hide();
        hideZaochRequired.hide();
        hideZaochCriteria.hide();
        calculate.hide();
    }
});

function forms(value) {

    var  $form1 = $("#olimpiclisteditform-form_of_passage option[value='1']");
    var  $form2 = $("#olimpiclisteditform-form_of_passage option[value='2']");
    var  $form3 = $("#olimpiclisteditform-form_of_passage option[value='3']");
    var  $form4 = $("#olimpiclisteditform-form_of_passage option[value='4']");
    var  $form5 = $("#olimpiclisteditform-form_of_passage option[value='5']");

    if (value == 1) { //@todo сделать константой
        formOfPassage.show();
        $form1.show();
        $form2.show();
        $form3.hide();
        $form4.hide();
        $form5.hide()
    } else if (value == 2) {
        formOfPassage.show();
        $form3.show();
        $form4.hide();
        $form2.hide();
        $form1.hide();
        $form5.show()
    } else if (value == 3) {
        formOfPassage.show();
        $form3.hide();
        $form4.show();
        $form2.hide();
        $form1.hide();
        $form5.hide()
    }
    else {
        formOfPassage.hide();
    }
}

$("#olimpiclisteditform-number_of_tours").on("init", function() {
    forms(this.value)
}).trigger("init");

$("#olimpiclisteditform-number_of_tours").on("change", function() {
    forms(this.value);
    $("#olimpiclisteditform-form_of_passage").val("");
});

$("#olimpiclisteditform-form_of_passage").on("change init", function() {
    if(this.value == 1 ||  this.value == 3) {
        hideTimeOfOchTour.show();
        hideDateTimeStartOchTour.show();
        hideAddress.show();
        hideTimeOchTur.show();
        hideOchRequired.show();
        hideOchCriteria.show();
    } else if(this.value == 2 || this.value == 5 ){
        hideZaochRequired.show();
        hideZaochCriteria.show();
        hideTypeOfTime.show();
        hideTimeOfOchTour.hide();
        hideDateTimeStartOchTour.hide();
        hideAddress.hide();
    }else {
        hideTypeOfTime.hide();
        hideTimeOfOchTour.hide();
        hideDateTimeStartOchTour.hide();
        hideAddress.hide();
        typeOfTime.hide();
        hideTimeOchTur.hide();
        hideOchRequired.hide();
        hideOchCriteria.hide();
        hideZaochRequired.hide();
        hideZaochCriteria.hide();
    }
}).trigger("init");


$("#olimpiclisteditform-edu_level_olymp").on("change init", function() {
    if (this.value == 2) { //@todo сделать константой
        mpguStatus.show();
    } else {
        mpguStatus.hide();
    }
}).trigger("init");

$("#olimpiclisteditform-time_of_distants_tour_type").on("change init", function() {
    if (this.value == 1) { //@todo сделать константой
        typeOfTime.show();
    } else {
        typeOfTime.hide();
    }
}).trigger("init");


var levelSelect = $("#olimpiclisteditform-edu_level_olymp");
var yearSelect = $("#olimpiclisteditform-year");
var loadedCg = []; // Текущий список КГ
var loadedClass = [];
var clSelect = $("#olimpiclisteditform-classeslist");
var cGSelect = $("#olimpiclisteditform-competitivegroupslist");

levelSelect.on("change init", function(){
    $.ajax({
        url: "/dictionary/dict-competitive-group/get-cg",
        method: "GET",
        dataType: "json",
        async: false,
        data: {levelId: levelSelect.val(), year: yearSelect.val()},
        success: function (groups){
            var cg = groups.result;
            loadedCg = cg;
            var oldCg = cGSelect.val();
            cGSelect.val("").trigger("change");
            cGSelect.empty();
            cGSelect.append("<option value=''></option>");

            for (var num in cg) {
                cGSelect.
                append($("<option></option>").attr("value", cg[num].id).text(cg[num].text));
            }

            if (oldCg) {
                cGSelect.val(oldCg).trigger("change");
            }
        },
        error: function() {
        }

    });
    $.ajax({
        url: "/dictionary/dict-class/get-class-on-type",
        method: "GET",
        dataType: "json",
        async: false,
        data: {onlyHs: levelSelect.val()},

        success: function (classes){
            var cl = classes.class;
            loadedClass = cl;
            var oldClass = clSelect.val();
            clSelect.val("").trigger("change");
            clSelect.empty();
            clSelect.append("<option value=''></option>");

            for (var num in cl) {
                clSelect.
                append($("<option></option>").attr("value", cl[num].id).text(cl[num].name));
            }

            if (oldClass) {
                clSelect.val(oldClass).trigger("change");
            }
        },
        error: function() {

        }

    });


});


levelSelect.trigger("init");
