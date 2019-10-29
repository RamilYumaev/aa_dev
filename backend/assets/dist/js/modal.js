$("[data-toggle=\"modal\"]").click(function(e) {
    e.preventDefault();
    var url = $(this).attr("href");
    var modalTitle = $(this).attr("data-modalTitle");
    var modal = $('#modal').modal('show');
        modal.find('#header-h4').text(modalTitle)
        modal.find('#modalContent').load(url);
});

