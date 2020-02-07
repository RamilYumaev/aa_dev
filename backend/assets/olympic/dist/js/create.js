var formOfPassage = $("div.field-olimpiclistcreateform-form_of_passage");
var mpguStatus = $("div.field-olimpiclistcreateform-only_mpgu_students");
var typeOfTime = $("div.field-olimpiclistcreateform-time_of_distants_tour");
var hideTypeOfTime = $("div.field-olimpiclistcreateform-time_of_distants_tour_type");
var hideTimeOfOchTour = $("div.field-olimpiclistcreateform-date_time_start_tour");
var hideDateTimeStartOchTour = $("div.field-olimpiclistcreateform-date_time_start_tour");
var hideAddress = $("div.field-olimpiclistcreateform-address");
var hideTimeOchTur = $("div.field-olimpiclistcreateform-time_of_tour");
var hideZaochRequired = $("div.field-olimpiclistcreateform-requiment_to_work_of_distance_tour");
var hideOchRequired = $("div.field-olimpiclistcreateform-requiment_to_work");
var hideZaochCriteria = $("div.field-olimpiclistcreateform-criteria_for_evaluating_dt");
var hideOchCriteria = $("div.field-olimpiclistcreateform-criteria_for_evaluating");
var calculate = $("div.field-olimpiclistcreateform-percent_to_calculate");

$("#olimpiclistcreateform-form_of_passage").on("change init", function() {
    if(this.value == 1 ||   this.value == 3 ){
        hideTimeOfOchTour.show();
        hideDateTimeStartOchTour.show();
        hideAddress.show();
        hideTimeOchTur.show();
        hideOchRequired.show();
        hideOchCriteria.show();
    }else if (this.value == 2 ||  this.value == 5 ){
        hideZaochRequired.show();
        hideZaochCriteria.show();
        hideTypeOfTime.show();
        hideTimeOfOchTour.hide();
        hideDateTimeStartOchTour.hide();
        hideAddress.hide();
        typeOfTime.hide();
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

$("#olimpiclistcreateform-number_of_tours").on("change init", function() {
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
        calculate.show()
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
        calculate.hide()
    }
});

$("#olimpiclistcreateform-number_of_tours").on("change init", function() {
    var  $form1 = $("#olimpiclistcreateform-form_of_passage option[value='1']");
    var  $form2 = $("#olimpiclistcreateform-form_of_passage option[value='2']");
    var  $form3 = $("#olimpiclistcreateform-form_of_passage option[value='3']");
    var  $form4 = $("#olimpiclistcreateform-form_of_passage option[value='4']");
    var  $form5 = $("#olimpiclistcreateform-form_of_passage option[value='5']");

    if (this.value == 1) { //@todo сделать константой
        formOfPassage.show();
        $("#olimpiclistcreateform-form_of_passage").val("");
        $form1.show();
        $form2.show();
        $form3.hide();
        $form4.hide();
        $form5.hide()
    } else if (this.value == 2) {
        formOfPassage.show();
        $("#olimpiclistcreateform-form_of_passage").val("");
        $form3.show();
        $form4.hide();
        $form2.hide();
        $form1.hide();
        $form5.show()
    } else if (this.value == 3) {
        formOfPassage.show();
        $("#olimpiclistcreateform-form_of_passage").val("");
        $form3.hide();
        $form4.show();
        $form2.hide();
        $form1.hide();
        $form5.hide()
    }
    else {
        formOfPassage.hide();
    }
}).trigger("init");



$("#olimpiclistcreateform-edu_level_olymp").on("change init", function() {
    if (this.value == 2) { //@todo сделать константой
        mpguStatus.show();
    } else {
        mpguStatus.hide();
    }
}).trigger("init");

$("#olimpiclistcreateform-time_of_distants_tour_type").on("change init", function() {
    if (this.value == 1) { //@todo сделать константой
        typeOfTime.show();
    } else {
        typeOfTime.hide();
    }
}).trigger("init");


var levelSelect = $("#olimpiclistcreateform-edu_level_olymp");
var loadedCg = []; // Текущий список КГ
var loadedClass = [];
var clSelect = $("#olimpiclistcreateform-classeslist");
var cGSelect = $("#olimpiclistcreateform-competitivegroupslist");

levelSelect.on("change init", function(){
    $.ajax({
        url: "/dictionary/dict-competitive-group/get-cg",
        method: "GET",
        dataType: "json",
        async: false,
        data: {levelId: levelSelect.val()},
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
