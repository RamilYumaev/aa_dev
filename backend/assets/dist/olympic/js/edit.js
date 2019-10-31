var formOfPassage = $("div.field-olympiceditform-form_of_passage");
var mpguStatus = $("div.field-olympiceditform-only_mpgu_students");
var typeOfTime = $("div.field-olympiceditform-time_of_distants_tour");
var hideTypeOfTime = $("div.field-olympiceditform-time_of_distants_tour_type");
var hideTimeOfOchTour = $("div.field-olympiceditform-date_time_start_tour");
var hideDateTimeStartOchTour = $("div.field-olympiceditform-date_time_start_tour");
var hideAddress = $("div.field-olympiceditform-address");
var hideTimeOchTur = $("div.field-olympiceditform-time_of_tour");
var hideZaochRequired = $("div.field-olympiceditform-requiment_to_work_of_distance_tour");
var hideOchRequired = $("div.field-olympiceditform-requiment_to_work");
var hideZaochCriteria = $("div.field-olympiceditform-criteria_for_evaluating_dt");
var hideOchCriteria = $("div.field-olympiceditform-criteria_for_evaluating");

$("#olympiceditform-form_of_passage").on("change init", function() {
    if(this.value == 1){
        hideTimeOfOchTour.show();
        hideDateTimeStartOchTour.show();
        hideAddress.show();
        hideTimeOchTur.show();
        hideOchRequired.show();
        hideOchCriteria.show();
    }else{
        hideTypeOfTime.hide();
        hideTimeOfOchTour.hide();
        hideDateTimeStartOchTour.hide();
        hideAddress.hide();
        typeOfTime.hide();
        hideTimeOchTur.hide();
        hideOchRequired.hide();
        hideOchCriteria.hide();
    };

    if(this.value == 2){
        hideZaochRequired.show();
        hideZaochCriteria.show();
        hideTypeOfTime.show();
    }else{
        hideZaochRequired.hide();
        hideZaochCriteria.hide();
    }
}).trigger("init");

$("#olympiceditform-number_of_tours").on("change init", function() {
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
    }
});

$("#olympiceditform-number_of_tours").on("change init", function() {
    if (this.value == 1 || this.value == 3) { //@todo сделать константой
        formOfPassage.show();
        $("#olympiceditform-form_of_passage option[value='3']").remove();
    } else {
        formOfPassage.hide();
    }
}).trigger("init");



$("#olympiceditform-edu_level_olymp").on("change init", function() {
    if (this.value == 2) { //@todo сделать константой
        mpguStatus.show();
    } else {
        mpguStatus.hide();
    }
}).trigger("init");

$("#olympiceditform-time_of_distants_tour_type").on("change init", function() {
    if (this.value == 1) { //@todo сделать константой
        typeOfTime.show();
    } else {
        typeOfTime.hide();
    }
}).trigger("init");


var levelSelect = $("#olympiceditform-edu_level_olymp");
var loadedCg = []; // Текущий список КГ
var loadedClass = [];
var clSelect = $("#olympiceditform-classeslist");
var cGSelect = $("#olympiceditform-competitivegroupslist");

levelSelect.on("change init", function(){
    $.ajax({
        url: "index.php?r=dictionary/dict-competitive-group/get-cg",
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
        url: "/index.php?r=dictionary/dict-class/get-class-on-type",
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
