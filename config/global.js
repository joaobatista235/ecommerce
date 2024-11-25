function loadContentIntoMain(url, mainSelector) {
    $.ajax({
        url: url,
        method: "GET",
        success: function (response) {
            $(mainSelector).html(response);
        },
        error: function () {
            $(mainSelector).html(
                "<p>Failed to load content. Please try again later.</p>"
            );
        },
    });
}

$(document).ready(function () {
    const body = $("body");
    const sidebar = body.find(".sidebar");
    const toggleButton = $("#btn-close-sidebar");
    const menuIcon = $("#menu-icon");
    const closeIcon = $("#close-icon");

    toggleButton.on("click", function () {
        sidebar.toggleClass("collapsed");

        if (sidebar.hasClass("collapsed")) {
            menuIcon.hide();
            closeIcon.show();
        } else {
            menuIcon.show();
            closeIcon.hide();
        }
    });
});