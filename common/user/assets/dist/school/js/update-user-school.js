var regionSch = $("div.field-schooluserupdateform-region_school");
regionSch.hide();
var school = $("div.field-schooluserupdateform-school_id");
var countrySch = $("div.field-schooluserupdateform-country_school");
countrySch.hide();
var newSch = $("div.field-schooluserupdateform-new_school");
newSch.hide();
var chNewSch = $("div.field-schooluserupdateform-check_new_school");
chNewSch.hide();
var chRenSch = $("div.field-schooluserupdateform-check_rename_school");
chRenSch.hide();

var vaLCountry = $("#schoolusercreateform-country_id").val();
var vaLRegion = $("#schoolusercreateform-region_id").val();

var vaLCountrySchool = $("#schooluserupdateform-country_school_h").val();
var vaLRegionSchool = $("#schooluserupdateform-region_school_h").val();
var vaLSchool = $("#schooluserupdateform-school").val();



function  propCheck(selector, attr, bool) {
    $(selector).prop(attr, bool);
}
function validateSchools() {
    $('#form-school-user').yiiActiveForm('validateAttribute', 'schooluserupdateform-school_id');
}

function changeNewSchool() {
    $("#schooluserupdateform-school_id").val("").change();
    validateSchools();
    $("#schooluserupdateform-new_school").val("");
}

const russia1 = 46;

function dataAjax(dataParams) {
    $.ajax({
        url: "/schools/all",
        method: "GET",
        dataType: "json",
        async: false,
        data: dataParams,
        success: function (groups) {
            propCheck("#schooluserupdateform-check_rename_school",'checked', false);
            var schools = groups.result;
            schoolSelect = $("#schooluserupdateform-school_id");
            schoolSelect.val("").trigger("change");
            schoolSelect.empty();
            var countSch = schools.length;
            if (countSch) {
                schoolSelect.append("<option value=''>Выберите учебную организацию</option>");
                for (var sch in schools) {
                    schoolSelect.append($("<option></option>").attr("value", schools[sch].id).text(schools[sch].text));
                }
                newSch.hide();
                propCheck("#schooluserupdateform-check_new_school",'checked', false);
                propCheck("#schooluserupdateform-check_new_school",'hidden', false);
            } else  {
                schoolSelect.append("<option value=''>Учебных организаций не найдено</option>");
                chRenSch.hide();
                chNewSch.hide();
                propCheck("#schooluserupdateform-check_new_school",'checked', true);
                propCheck("#schooluserupdateform-check_new_school",'hidden', true);
                newSch.show();
            }
        },
        error: function () {
        }
    });
}


$('#schooluserupdateform-check_rename_school').on('change', function() {
    if (this.checked) {
        newSch.show();
        validateSchools();
    } else {
        newSch.hide();
        validateSchools();

    }
});

$('#schooluserupdateform-check_region_and_country_school').on('change init', function() {
    // From the other examples
    if (this.checked) {
        regionSch.hide();
        countrySch.hide();
        chNewSch.show();
        chRenSch.hide();
        newSch.hide();
        $("#schooluserupdateform-country_school").val("")
        $("#schooluserupdateform-region_school").val("")
        $("#schooluserupdateform-new_school").val("");
        propCheck("#schooluserupdateform-check_new_school",'checked', false);
        propCheck("#schooluserupdateform-check_rename_school",'checked', false);
        dataParams = {country_id: vaLCountry, region_id: vaLRegion ? vaLRegion : null};
        dataAjax(dataParams);
        school.show();
    } else {
        $("#schooluserupdateform-school_id").val("").trigger("change");
        propCheck("#schooluserupdateform-check_new_school",'checked', false);
        propCheck("#schooluserupdateform-check_rename_school",'checked', false);
        $("#schooluserupdateform-new_school").val("");
        if (vaLCountry != russia1) {
            $("#schooluserupdateform-country_school option[value=" +  vaLCountry  + "]").attr('disabled','disabled');
        }
        school.hide();
        countrySch.show();
        chNewSch.hide();
        chRenSch.hide();
        newSch.hide();
    }
}).trigger('init');

$('#schooluserupdateform-check_new_school').on('change', function() {
    // From the other examples
    if (this.checked) {

        newSch.show();
       // changeNewSchool();
    } else {

        newSch.hide();
      // changeNewSchool();
    }
});

$("#schooluserupdateform-school_id").on("change", function() {
    if (this.value == "") {
        chNewSch.show();
        chRenSch.hide();
        $("#schooluserupdateform-new_school").val("");
        newSch.hide();
    } else {
        propCheck("#schooluserupdateform-check_rename_school",'checked', false);
        chNewSch.hide();
        $("#schooluserupdateform-new_school").val("");
        chRenSch.show();
        newSch.hide();
    }
});

$("#schooluserupdateform-country_school").on("change", function() {
    var dataParams;
    if (this.value == "") {
        region.hide();
        chNewSch.hide();
        chRenSch.hide();
        school.hide();
        $("#schooluserupdateform-region_school").val("")
    }
    else if (this.value == russia1) {
        $("#schooluserupdateform-region_school option[value=" +  vaLRegion  + "]").attr('disabled','disabled');
        regionSch.show();
        school.hide();
        chNewSch.hide();
        chRenSch.hide();
    } else {
        regionSch.hide();
        dataParams = {country_id : this.value};
        dataAjax(dataParams);
        school.show();

        $("#schooluserupdateform-region_school").val("")
    }
});

$("#schooluserupdateform-region_school").on("change", function() {
    if (this.value !== "" ) {
    var dataParams;
    dataParams = {country_id : russia1, region_id : this.value};
    school.show();
    dataAjax(dataParams);

    }
});

if ((vaLCountry == russia1 && vaLCountrySchool== russia1)  && vaLRegionSchool == vaLRegion) {
    $("#schooluserupdateform-school_id").val(vaLSchool);
} if ((vaLCountry ==  vaLCountrySchool)) {
        $("#schooluserupdateform-school_id").val(vaLSchool);
} else if(vaLCountry == vaLCountrySchool  && (vaLRegionSchool && vaLRegion)) {
    countrySch.show();
    $("#schooluserupdateform-country_school").val(vaLCountrySchool);
    regionSch.show();
    $("#schooluserupdateform-region_school").val(vaLRegionSchool);
    dataParams = {country_id: vaLCountrySchool, region_id: vaLRegionSchool};
    dataAjax(dataParams);
    school.show();
    chNewSch.hide();
    chRenSch.show();
    $("#schooluserupdateform-school_id").val(vaLSchool);
    $('#schooluserupdateform-check_region_and_country_school').removeAttr("checked");
} else if(vaLCountrySchool ==  russia1  && (vaLRegionSchool)) {
    countrySch.show();
    $("#schooluserupdateform-country_school").val(vaLCountrySchool);
    regionSch.show();
    $("#schooluserupdateform-region_school").val(vaLRegionSchool);
    dataParams = {country_id: vaLCountrySchool, region_id: vaLRegionSchool};
    dataAjax(dataParams);
    school.show();
    chNewSch.hide();
    chRenSch.show();
    $("#schooluserupdateform-school_id").val(vaLSchool);
    $('#schooluserupdateform-check_region_and_country_school').removeAttr("checked");
}
else if(vaLCountry != vaLCountrySchool && vaLRegionSchool != vaLRegion) {
    countrySch.show();
    $("#schooluserupdateform-country_school").val(vaLCountrySchool);
    regionSch.hide();
    dataParams = {country_id: vaLCountrySchool, region_id: null};
    dataAjax(dataParams);
    school.show();
    chNewSch.hide();
    chRenSch.show();
    $("#schooluserupdateform-school_id").val(vaLSchool);
    $('#schooluserupdateform-check_region_and_country_school').removeAttr("checked");

}
