$(document).ready(function () {
    $(document).ajaxSend(function (event, jqxhr, settings) {
        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (csrfToken) {
            jqxhr.setRequestHeader("X-CSRF-TOKEN", csrfToken); // Añadir CSRF Header
        }
    });
});
