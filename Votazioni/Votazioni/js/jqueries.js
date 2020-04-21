$(document).ready(function () {
    $("[type='number']").keypress(function (evt) {
        evt.preventDefault();
    });

    $("#openInvite").click(function () {
        $("#myForm").show();
    });

    $("#closeInvite").click(function () {
        $("#myForm").hide();
    });

    $(".searchInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".searchTable tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});