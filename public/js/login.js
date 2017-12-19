//根据用户选择，自动填充用户名和密码
window.onload = function () {
    var rememberStatus = getCookieValue("rememberpwd");

    if (1 == rememberStatus) {
        var userNameValue = getCookieValue("username");
        var userpwdValue = getCookieValue("userpwd");

        $("#username").val(userNameValue);
        $("#userpwd").val(userpwdValue);
        $("#rememberpwd").attr("checked", true);
    }
    else {
        $("#rememberpwd").attr("checked", false);
    }
}

//检查是否选择了“记住密码”，是，则保存登陆用户名和密码，否则清除用户名和密码。
function checkRememberStatus() {
    if ($("#rememberpwd").attr("checked")) {
        var userNameValue = $("#username").val();
        var userpwdValue = $("#userpwd").val();

        setCookie("username", userNameValue, 7, "/");
        setCookie("userpwd", userpwdValue, 7, "/");
        setCookie("rememberpwd", 1, 7, "/");
    }
    else {
        deleteCookie("username", "/");
        deleteCookie("userpwd", "/");
        deleteCookie("rememberpwd", "/");
    }
}

//login
function login_submit() {

    checkRememberStatus();

    let username = $("#username").val();
    let password = $("#userpwd").val();

    if (username == "" || password == "") {
        $("#login_msg").html('用户名或密码不能为空！');
        return false;
    } else {
        $("#login_msg").html("");
    }

    let data = {
        "username": username,
        "password": password
    }

    $.post(
        './index.php/login/do',
        { 'data': data },
        function (msg) {
            if (msg.status === 'success') {
                location.href = msg.url;
            } else {
                $("#login_msg").html(msg.status);
            }
        },
        'json'
    );
}

//响应Enter按键登录
document.onkeydown = function (event) {
    var e = event || window.event || arguments.callee.caller.arguments[0];
    if (e && e.keyCode == 13) {
        login_submit();
    }
}


/**
 *  login
 */
$(document).ready(function () {
    $("#login_btn").click(function () {
        login_submit();
    });
});

