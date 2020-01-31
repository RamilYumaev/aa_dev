    var region = $("div.field-profileeditform-region_id");
    var countryId = $("#profileeditform-country_id");
    var regionId = $("#profileeditform-region_id");

    const russia = 46;

    if(countryId.val()== russia) {
        region.show();
    }else {
        region.hide();
    }

    countryId.on("change", function() {
        if (this.value == "") {
            region.hide();
            regionId.val("");
        } else if (this.value == russia) {
            region.show();
        }
        else {
            region.hide();
            regionId.val("");
            }
    });