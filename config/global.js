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

document.addEventListener("DOMContentLoaded", () => {
    const body = document.querySelector("body"),
          sidebar = body.querySelector(".sidebar"),
          toggleButton = body.querySelector(".close"),
          menuIcon = document.getElementById("menu-icon"),
          closeIcon = document.getElementById("close-icon");

    toggleButton.addEventListener("click", () => {
        sidebar.classList.toggle('collapsed');

        if (sidebar.classList.contains('collapsed')) {
            menuIcon.style.display = 'none';
            closeIcon.style.display = 'block';
        } else {
            menuIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        }
    });
});


