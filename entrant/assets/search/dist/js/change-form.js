var yearSelect = $("#userolympicsearch-year");
var loadedOlympic = [];
var loadedUser = [];
var olympicSelect = $("#userolympicsearch-olympiads_id");
var userSelect = $("#userolympicsearch-user_id");

yearSelect.on("change init", function(){
    $.ajax({
        url: "/user-schools/olympics",
        method: "GET",
        dataType: "json",
        async: false,
        data: {year: yearSelect.val()},
        success: function (groups){
            var cg = groups.olympics;
            loadedOlympic = cg;
            var oldCg = olympicSelect.val();
            olympicSelect.val("").trigger("change");
            olympicSelect.empty();
            olympicSelect.append("<option value=''></option>");

            for (var num in cg) {
                olympicSelect.
                append($("<option></option>").attr("value", cg[num].id).text(cg[num].name));
            }

            if (oldCg) {
                olympicSelect.val(oldCg).trigger("change");
            }
        },
        error: function() {
        }
    });
});

olympicSelect.change(function(){
    console.log(olympicSelect.val())
    $.ajax({
        url: "/user-schools/users",
        method: "GET",
        dataType: "json",
        async: false,
        data: {olympic: olympicSelect.val()},
        success: function (result){
            var user = result.users;
            loadedUser = user;
            var usersOld = userSelect.val();
            userSelect.val("").trigger("change");
            userSelect.empty();
            userSelect.append("<option value=''></option>");

            for (var num in user) {
                userSelect.
                append($("<option></option>").attr("value", user[num].id).text(user[num].name));
            }

            if (usersOld) {
                userSelect.val(usersOld).trigger("change");
            }
        },
        error: function() {

        }
    });
});


yearSelect.trigger("init");
