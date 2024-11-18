function loadContentIntoMain(url, mainSelector) {
    $.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            $(mainSelector).html(response);
        },
        error: function () {
            $(mainSelector).html('<p>Failed to load content. Please try again later.</p>');
        },
    });
}
