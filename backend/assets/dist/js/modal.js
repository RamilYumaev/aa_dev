$("[data-toggle=\"modal\"]").click(function(e) {
    e.preventDefault();
    var url = $(this).attr("href");
    $('#modal').modal('show')
        .find('#modalContent').load(url);
});


