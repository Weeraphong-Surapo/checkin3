function loginTeacher(event) {
    event.preventDefault();
    $('span#error-username').css('color','red')
    $('span#error-password').css('color','red')
    let username = $('#username').val()
    let password = $('#password').val()
    if (username == "" && password == "") {
        $('#error-username').text('กรุณากรอกชื่อผู้ใช้งานด้วย')
        $('#error-password').text('กรุณากรอกรหัสผ่านด้วย')
    } else if (username == "") {
        $('#error-password').empty()
        $('#error-username').text('กรุณากรอกชื่อผู้ใช้งานด้วย')
    } else if (password == "") {
        $('#error-username').empty()
        $('#error-password').text('กรุณากรอกรหัสผ่านด้วย')
    } else {
        $('#error-username').empty()
        $('#error-password').empty()
        $.ajax({
            url: 'function/action.php',
            type: 'post',
            data: {
                username: username,
                password: password,
                loginTeacher:1
            },
            error: function (xhr, textStatus) { alert(textStatus) },
            success: function (res) {
                if (res == "userfail") {
                    $('#password').val('')
                    alertsuccess('error', 'ไม่มีชื่อผู้ใช้นี้ในระบบ', '');
                } else if (res == "passwordfail") {
                    $('#password').val('')
                    alertsuccess('error','รหัสผ่านไม่ถูกต้อง','');
                } else {
                    alertsuccess('success', 'เข้าสู่ระบบ', '')
                    setTimeout(function(){window.location.href="index.php"},1000)
                }
            }
        })
    }
}