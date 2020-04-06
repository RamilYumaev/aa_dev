var newOrg = $("div.field-agreementform-name");
newOrg.hide();
var chNewOrg = $("div.field-agreementform-check_new");
var chRenOrg = $("div.field-agreementform-check_rename");
chRenOrg.hide();

function propCheck(selector, attr, bool) {
    $(selector).prop(attr, bool);
}

function validateOrganization() {
    $('#form-agreement').yiiActiveForm('validateAttribute', 'organization_id');
}

function changeNewOrganization() {
    $("#agreementform-name").val("").change();
    validateOrganization();
    $("#agreementform-name").val("");
}

$('#agreementform-check_new').on('change', function () {
    // From the other examples
    if (this.checked) {
        changeNewOrganization();
        newOrg.show();
    } else {
        changeNewOrganization();
        newOrg.hide();
    }
});

$('#agreementform-check_rename').on('change', function () {
    if (this.checked) {
        newOrg.show();
        validateOrganization();
    } else {
        changeNewOrganization();
        newOrg.hide();
    }
});

$("#agreementform-organization_id").on("change", function () {
    if (this.value == "") {
        chNewOrg.show();
        chRenOrg.hide();
        $("#agreementform-name").val("");
        validateOrganization()
        newOrg.hide();
    } else {
        propCheck("#agreementform-check_rename", 'checked', false);
        chNewOrg.hide();
        propCheck("#agreementform-check_new", 'checked', false);
        chRenOrg.show();
        newOrg.hide();
    }
});

$("#agreementform-organization_id").trigger("change");