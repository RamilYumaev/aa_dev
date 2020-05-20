$("[data-target=\"#modal\"]").click(function() {
    e.preventDefault();
    var pjax = $(this).attr("data-pjax");
    var url = $(this).attr("data-url");
    var modalTitle = $(this).attr("data-modalTitle");
    var modal = $('#modal');
        modal.find('#header-h4').text(modalTitle);
        modal.find('#modalContent').load(url);
});

