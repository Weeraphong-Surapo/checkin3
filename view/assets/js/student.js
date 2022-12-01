$('button.btn-edit').click(function () {
    let id = $(this).attr('data-id')
    $.ajax({
        url: 'function/action.php',
        type: 'post',
        dataType:'json',
        data: {
            id: id,
            editstudent:1
        },
        error: function (xhr, textStatus) {
            alert(textStatus)
        },
        success: function (res) {
            console.log(res);
            $('#id-student').val(res.id)
            $('#student_id').val(res.Student_id)
            $('#student_name').val(res.Student_name)
            $('#email').val(res.Email)
            $('#ModalStudent').modal('show')
        }
    })
})


$('button.btn-del').click(function () {
    let id = $(this).attr('data-id')
    let name = $(this).attr('data-name')

    Swal.fire({
        title: 'คุณต้องการลบ ' + name + ' ใช่ไหม?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'function/action.php',
                type: 'post',
                data: {
                    id: id,
                    delStudent: 1
                },
                error: function (xhr, textStatus) {
                    alert(textStatus)
                },
                success: function (res) {
                    alertsuccess('success', 'ลบเรียบร้อย', '')
                    setTimeout(function(){location.reload()},1000)
                }
            })
        }
    })
})

function insertStudent() {
    $('#formStudent')[0].reset()
    $('#ModalStudent').modal('show')
}


$('#formStudent').submit(function (e) {
    e.preventDefault();
    $('p').css('color', 'red')
    let fd = new FormData()
    let id = $('#id-student').val()
    let student_id = $('#student_id').val()
    let student_name = $('#student_name').val()
    let email = $('#email').val()
    if (student_id == "" && student_name == "" && email == "") {
        $('#error-student_id').text('กรุณากรอกรหัสนักศึกษา')
        $('#error-student_name').text('กรุณากรอกชื่อนักศึกษา')
        $('#error-email').text('กรุณากรอกอีเมลล์ศึกษา')
    } else if (student_id == "") {
        $('#error-student_id').text('กรุณากรอกรหัสนักศึกษา')
    } else if (student_name == "") {
        $('#error-student_id').empty()
        $('#error-student_name').text('กรุณากรอกชื่อนักศึกษา')
    } else if (email == "") {
        $('p').empty()
        $('#error-student_name').empty()
        $('#error-email').text('กรุณากรอกอีเมลล์ศึกษา')
    } else {
        $('p').empty()
        fd.append('student_id', student_id)
        fd.append('student_name', student_name)
        fd.append('email', email)
        fd.append('id',id)
        fd.append('insertStudent',1)
        $.ajax({
            url: 'function/action.php',
            type: 'post',
            data: fd,
            async: false,
            contentType: false,
            processData: false,
            error: function (xhr, textStatus) {
                alert(textStatus)
            },
            success: function (res) {
                alertsuccess('success', 'บันทึกสำเร็จ', '');
                setTimeout(function(){location.reload()},1000)
            }
        })
    }
})

$('button#warn').click(function () {
    let id = $(this).attr('data-id')
    let name = $(this).attr('data-name')
    Swal.fire({
        title: 'ตักเตือน '+name+' ใช่ไหม?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'function/action.php',
                type: 'post',
                beforeSend: function () {
                    $.blockUI({
                        message: $('#indicator'),
                        css: { background: '#ffc', color: '#be94eb',border:'none' },
                        overlayCSS: { background: '#ceacf2', opacity: false }
                    })
                },
                data: {
                    id: id,
                    warn:1
                },
                success: function (res) {
                    $.unblockUI()
                    alertsuccess('success', 'ส่งอีเมล์เตือนสำเร็จ', '');
                }
            })
        }
    })
})

function logout() {
    $.ajax({
        url: 'function/action.php',
        type: 'post',
        data: {
            logout:1
        },
        success: function (res) {
            alertsuccess('success', 'ออกจากระบบ', '')
            setTimeout(() => {location.reload()},900)
        }
    })
}