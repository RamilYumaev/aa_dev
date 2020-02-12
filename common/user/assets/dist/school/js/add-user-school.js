var regionSch = $("div.field-schooluserform-region_school");
regionSch.hide();
var school = $("div.field-schooluserform-school_id");
var countrySch = $("div.field-schooluserform-country_school");
countrySch.hide();
var newSch = $("div.field-schooluserform-new_school");
newSch.hide();
var chNewSch = $("div.field-schooluserform-check_new_school");
chNewSch.hide();
var chRenSch = $("div.field-schooluserform-check_rename_school");
chRenSch.hide();
var vaLCountry = $("#schoolusercreateform-country_id").val();
var vaLRegion = $("#schoolusercreateform-region_id").val();

function  propCheck(selector, attr, bool) {
    $(selector).prop(attr, bool);
}
function validateSchools() {
    $('#form-school-user').yiiActiveForm('validateAttribute', 'schooluserform-school_id');
}

function changeNewSchool() {
    $("#schooluserform-school_id").val("").change();
    validateSchools();
    $("#schooluserform-new_school").val("");
}


const russia = 46;
function dataAjax(dataParams) {
    $.ajax({
        url: "/schools/all",
        method: "GET",
        dataType: "json",
        async: false,
        data: dataParams,
        success: function (groups) {
            propCheck("#schooluserform-check_rename_school",'checked', false);
            var schools = groups.result;

            schoolSelect = $("#schooluserform-school_id");
            schoolSelect.val("").trigger("change");
            schoolSelect.empty();
            var countSch = schools.length;
            if (countSch) {
                schoolSelect.append("<option value=''>Выберите учебную организацию</option>");
                for (var sch in schools) {
                    schoolSelect.append($("<option></option>").attr("value", schools[sch].id).text(schools[sch].text));
                }
                newSch.hide();
                propCheck("#schooluserform-check_new_school",'checked', false);
                propCheck("#schooluserform-check_new_school",'hidden', false);
            } else  {
                schoolSelect.append("<option value=''>Учебных организаций не найдено</option>");
                chRenSch.hide();
                chNewSch.hide();
                propCheck("#schooluserform-check_new_school",'checked', true);
                propCheck("#schooluserform-check_new_school",'hidden', true);
                newSch.show();
            }
        },
        error: function () {
        }
    });
}


$('#schooluserform-check_rename_school').on('change', function() {
    if (this.checked) {
        newSch.show();
        validateSchools();
    } else {
        newSch.hide();
        validateSchools();

    }
});

$('#schooluserform-check_region_and_country_school').on('change init', function() {
    // From the other examples
    if (this.checked) {
        regionSch.hide();
        countrySch.hide();
        chNewSch.show();
        chRenSch.hide();
        newSch.hide();
        $("#schooluserform-country_school").val("")
        $("#schooluserform-region_school").val("")
        $("#schooluserform-new_school").val("");
        propCheck("#schooluserform-check_new_school",'checked', false);
        propCheck("#schooluserform-check_rename_school",'checked', false);
        dataParams = {country_id: vaLCountry, region_id: vaLRegion ? vaLRegion : null};
        dataAjax(dataParams);
        school.show();
    } else {
        $("#schooluserform-school_id").val("").trigger("change");
        propCheck("#schooluserform-check_new_school",'checked', false);
        propCheck("#schooluserform-check_rename_school",'checked', false);
        $("#schooluserform-new_school").val("");
        if (vaLCountry != russia) {
            $("#schooluserform-country_school option[value=" +  vaLCountry  + "]").attr('disabled','disabled');
        }
        school.hide();
        countrySch.show();
        chNewSch.hide();
        chRenSch.hide();
        newSch.hide();
    }
}).trigger('init');

$('#schooluserform-check_new_school').on('change', function() {
    // From the other examples
    if (this.checked) {
        newSch.show();
       // changeNewSchool();
    } else {
        newSch.hide();
      // changeNewSchool();
    }
});

$("#schooluserform-school_id").on("change", function() {
    if (this.value == "") {
        chNewSch.show();
        chRenSch.hide();
        $("#schooluserform-new_school").val("");
        newSch.hide();
    } else {
        propCheck("#schooluserform-check_rename_school",'checked', false);
        chNewSch.hide();
        $("#schooluserform-new_school").val("");
        chRenSch.show();
        newSch.hide();
    }
});



$("#schooluserform-country_school").on("change", function() {
    var dataParams;
    if (this.value == "") {
        region.hide();
        chNewSch.hide();
        chRenSch.hide();
        school.hide();
        $("#schooluserform-region_school").val("")
    }
    else if (this.value == russia) {
        $("#schooluserform-region_school option[value=" +  vaLRegion  + "]").attr('disabled','disabled');
        regionSch.show();
        school.hide();
        chNewSch.hide();
        chRenSch.hide();
    } else {
        regionSch.hide();
        dataParams = {country_id : this.value};
        dataAjax(dataParams);
        school.show();
        $("#schooluserform-region_school").val("")
    }
});

$("#schooluserform-region_school").on("change", function() {
    if (this.value !== "" ) {
    var dataParams;
    dataParams = {country_id : russia, region_id : this.value};
    school.show();
    dataAjax(dataParams);
    }
});