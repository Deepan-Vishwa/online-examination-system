/* 
1. Functionality for login mail & Main mail
2. Request To mailer.php
*/

$(document).ready(function () {
    $("#send_mail").click(function () {
        $("#send_mail").attr("disabled", true);
        $("#send_mail").html(
            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" id="load"></span>Sending...'
        );

        var email = $("#help_email").val().trim();
        var ci = $("#help_ci").val().trim();
        var oi = $("#help_oi").val().trim();
        var pd = $("#help_pd").val().trim();
        if (email != "" && ci != "" && (oi != "") & (pd != "")) {
            $.ajax({
                url: "mailer.php",
                type: "POST",
                data: {
                    email: email,
                    ci: ci,
                    oi: oi,
                    pd: pd,
                    action: "login_mail",
                },
                success: function (dataResult) {
                    $("#login_mail_modal").modal("show");
                    $("#login_mail_modal_body").text(dataResult);

                    $("#load").remove();
                    $("#send_mail").attr("disabled", false);
                    $("#send_mail").html("Send");
                    $("#mail_login_form")
                        .closest("form")
                        .find("input[type=text], textarea")
                        .val("");
                    $("#help_ci").val("none");
                    $("#help_email").val("");
                },
            });
        } else {
            $("#load").remove();
            $("#send_mail").attr("disabled", false);
            $("#send_mail").html("Send");

            $("#alert_login_mail")
                .removeClass()
                .attr("hidden", false)
                .toggleClass(" alert alert-yellow")
                .html(
                    "<i class='fas fa-exclamation-circle'></i> Please Fill in the Required Fields"
                );
        }
    });

    $("#main_mail").click(function () {
        $("#main_mail").attr("disabled", true);
        $("#main_mail").html(
            '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" id="load"></span>Sending...'
        );
        var coi = $("#help_common").val().trim();
        var oti = $("#help_other").val().trim();
        var prd = $("#help_problem").val().trim();

        if (coi != "" && oti != "" && prd != "") {
            $.ajax({
                url: "mailer.php",
                type: "POST",
                data: {
                    coi: coi,
                    oti: oti,
                    prd: prd,
                    action: "main_mail",
                },
                success: function (dataResult) {
                    $("#main_mail_modal").modal("show");
                    $("#main_mail_modal_body").text(dataResult);

                    $("#load").remove();
                    $("#main_mail").attr("disabled", false);
                    $("#main_mail").html("Send");
                    $("#mail_form")
                        .closest("form")
                        .find("input[type=text], textarea")
                        .val("");
                    $("#help_common").val("none");
                },
            });
        } else {
            $("#load").remove();
            $("#main_mail").attr("disabled", false);
            $("#main_mail").html("Send");
            $("#alert_main_mail")
                .removeClass()
                .attr("hidden", false)
                .toggleClass(" alert alert-yellow")
                .html(
                    "<i class='fas fa-exclamation-circle'></i> Please Fill in the Required Fields"
                );
        }
    });
});