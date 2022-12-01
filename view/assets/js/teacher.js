function insertTeacher() {
    $('#formTeacher')[0].reset()
    $('#ModalTeacher').modal('show')
}

$('#formTeacher').submit(function (e) {
    e.preventDefault();
    $('p').css('color', 'red')
    let id_edit = $('#id_edit').val()
    let department = $('#department').val()
    let title = $('#title').val()
    let teacher = $('#teacher').val()
    let username = $('#username').val()
    let password = $('#password').val()
    let phone = $('#phone').val()
    let lavel = $('#lavel').val()
    let formData = new FormData();
    if (department == null) {
        $('p').empty()
        $('p#department-error').text('กรุณาเลือกสาขา')
    } else if (title == null) {
        $('p').empty()
        $('#title-error').text('กรุณาเลือกคำนำหน้า')
    } else if (teacher == "") {
        $('p').empty()
        $('#teacher-error').text('กรุณาป้อนชื่ออาจารย์')
    } else if (phone == "") {
        $('p').empty()
        $('#phone-error').text('กรุณากรอกเบอร์โทร [0-9]')
    } else if (username == "") {
        $('p').empty()
        $('#username-error').text('กรุณากรอกชื่อผู้ใช้')
    } else if (password == "") {
        $('p').empty()
        $('#password-error').text('กรุณากรอกรหัสผ่านด้วย')
    } else if (isNaN(phone)) {
        $('p').empty()
        $('#phone-error').text('กรุณากรอกเบอร์โทรเป็นตัวเลข')
    } else if (password.length <= 8) {
        $('p').empty()
        $('#password-error').text('กรุณาตั้งรหัสผ่าน 8 ตัวขึ้นไป')
    } else {
        formData.append('id',id_edit)
        formData.append('department', department)
        formData.append('title', title)
        formData.append('teacher', teacher)
        formData.append('username', username)
        formData.append('password', password)
        formData.append('phone', phone)
        formData.append('lavel',lavel)
        formData.append('add_teacher',1)
        $.ajax({
            url: 'function/action.php',
            type: 'post',
            data: formData,
            async: false,
            contentType: false,
            processData: false,
            error: function (xhr, textStatus) {
                alertError()
            },
            success: function (res) {
                alertsuccess('success', 'บันทึกสำเร็จ', '')
                $('#formTeacher')[0].reset()
                setTimeout(function(){location.reload()},1000)
            }
        })
    }
})


$('button#del-teacher').click(function () {
    let id = $(this).attr('data-id')
    let teacher = $(this).attr('data-name')
    Swal.fire({
        title: 'คุณต้องการลบ ' + teacher + ' ใช่ไหม?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText:'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: 'function/action.php',
                type: 'post',
                data: {
                    id: id,
                    delTeacher: 1
                },
                error: function (xhr, textStatus) {
                    alertError()
                },
                success: function (res) {
                    alertsuccess('success', 'ลบข้อมูลสำเร็จ', '')
                    setTimeout(function () { location.reload() }, 1000)
                }
            })
        }
    })
})

$('button#edit-teacher').click(function () {
    let id = $(this).attr('data-id')
    $.ajax({
        url: 'function/action.php',
        type: 'post',
        dataType:'json',
        data: {
            id: id,
            edit_teacher:1
        },
        error: function (xhr, textStatus) {
            alert(textStatus)
        },
        success: function (res) {
            $('#id_edit').val(res.id)
            $('#lavel').val(res.lavel)
            $('#department').val(res.Department)
            $('#title').val(res.title)
            $('#teacher').val(res.Teacher_name)
            $('#username').val(res.username)
            $('#password').val(res.password)
            $('#phone').val(res.phone)
            $('#ModalTeacher').modal('show')
        }
    })
})

$('button#show-teacher').click(function () {
    let id = $(this).attr('data-id')
    $.ajax({
        url: 'function/action.php',
        type: 'post',
        data: {
            id: id,
            view_teacher:1
        },
        success: function (res) {
            $('#detailTeacher').html(res)
            $('#viewTeacher').modal('show')
        }
    })
})

