var region = $("div.field-signupolympicform-region_id");
region.hide();
var school = $("div.field-signupolympicform-school_id");
school.hide();
var regionSch = $("div.field-signupolympicform-region_school");
regionSch.hide();
var countrySch = $("div.field-signupolympicform-country_school");
countrySch.hide();
const russia = 46;
function dataAjax(dataParams) {
    $.ajax({
        url: "/schools/all",
        method: "GET",
        dataType: "json",
        async: false,
        data: dataParams,
        success: function (groups) {
            var schools = groups.result;
            console.log(schools);
            schoolSelect = $("#signupolympicform-school_id");
            schoolSelect.val("").trigger("change");
            schoolSelect.empty();
            schoolSelect.append("<option value=''>Выберите учебную организацию</option>");
            for (var sch in schools) {
                schoolSelect.append($("<option></option>").attr("value", schools[sch].id).text(schools[sch].text));
            }
        },
        error: function () {
        }
    });
}
$('#signupolympicform-check_region_and_country_school').on('change', function() {
    // From the other examples
    if (this.checked) {
        console.log('true');
        regionSch.hide();
        countrySch.hide();
        $("#signupolympicform-country_id").val("")
        $("#signupolympicform-country_school").val("")
        $("#signupolympicform-region_school").val("")
        $("#signupolympicform-school_id").val("");
        school.hide();
    } else {
        $("#signupolympicform-school_id").val("").trigger("change");
        school.hide();
        countrySch.show();
    }
});

$("#signupolympicform-country_id").on("change", function() {
    var dataParams;
    if (this.value == russia) {
        region.show();
        school.hide();
    } else {
        region.hide();
        dataParams = {country_id : this.value};
        dataAjax(dataParams);
        school.show();
        console.log(dataParams);
    }
});

$("#signupolympicform-region_id").on("change", function() {
    var dataParams;
    dataParams = {country_id : russia, region_id : this.value};
    dataAjax(dataParams)
    school.show();
    console.log(dataParams);
});

$("#signupolympicform-country_school").on("change", function() {
    var dataParams;
    if (this.value == russia) {
        regionSch.show();
        school.hide();
    } else {
        regionSch.hide();
        dataParams = {country_id : this.value};
        dataAjax(dataParams);
        school.show();
        console.log(dataParams);
    }
});

$("#signupolympicform-region_school").on("change", function() {
    var dataParams;
    dataParams = {country_id : russia, region_id : this.value};
    dataAjax(dataParams)
    school.show();
    console.log(dataParams);
});