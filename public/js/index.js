function logout() {
    $.ajax({
        type: "GET",
        url: "/admin",
        async: false,
        username: "logmeout",
        password: "123456",
        headers: {"Authorization": "Basic xxx"}
    })
        .done(function () {
        })
        .fail(function () {
            window.location = "/";
        });

    return false;
}