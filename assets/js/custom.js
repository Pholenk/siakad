//==============//
//  login page  //
//==============//

$(document).ready(
    $('#login').on('submit', function() {
        $.ajax({
            cache: false,
            type: 'post',
            url: '/auth/login',
            data: {
                username: $('#username').val(),
                password: $('#password').val()
            },
            success: function(response) {
                if (response === 'TRUE') {
                    window.location = '/'
                } else {
                    $('#error').fadeIn('slow', function() {
                        $("#error").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; ' + response + '</div>')
                    })
                }
            }
        })
        return false
    })
)

//==============//
//  users page  //
//==============//
$(document).ready(function() {
    var id

    $("button[id^='edit_user']").on('click', function(event) {
        event.preventDefault()
        id = this.id.replace('edit_user_', '')
        $.ajax({
            url: '/users/read/' + id,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("#add_user").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/users/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $('body').on('submit', '#edit_form_user', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/users/edit/' + id,
            data: $('#edit_form_user').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/users'
                        break
                    case 'FALSE':
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('submit', '#add_form_user', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/users/add/' + $('#username_add').val(),
            data: $('#add_form_user').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/users'
                        break
                    case 'FALSE':
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $("button[id^='delete_user_']").click(function(event) {
        event.preventDefault()
        id = this.id.replace('delete_user_', '')
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete User</h1></div><div id="error_delete_user"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus pengguna secara permanen.<br><strong>Hapus pengguna?</strong></h4></div></div> <div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_user"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"> <button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
    })

    $('body').on('click', '#save_delete_user', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/users/delete/' + id,
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/users'
                        break
                    case 'FALSE':
                        $('#error_delete_user').fadeIn('slow', function() {
                            $("#error_delete_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_user').fadeIn('slow', function() {
                            $("#error_delete_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('click', '#show_password', function() {
        ($("input[id^='password_']").attr('type') === 'password' ? $("input[id^='password_']").attr('type', 'text') && $('#show_password_icon').removeClass('fa-eye-slash') && $('#show_password_icon').addClass('fa-eye') : $("input[id^='password_']").attr('type', 'password') && $('#show_password_icon').removeClass('fa-eye') && $('#show_password_icon').addClass('fa-eye-slash'))
    })
})

//================//
//  jurusan page  //
//================//

$(document).ready(function() {
    var id

    $("#add_jurusan").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/jurusan/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='edit_jurusan_']").on('click', function(event) {
        event.preventDefault()
        id = this.id.replace('edit_jurusan_', '')
        $.ajax({
            url: '/jurusan/read/' + id,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='delete_jurusan_']").click(function(event) {
        event.preventDefault()
        id = this.id.replace('delete_jurusan_', '')
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete Jurusan</h1></div><div id="error_delete_user"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus jurusan.<br><strong>Hapus jurusan?</strong></h4></div></div><div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_jurusan"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"><button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
    })

    $('body').on('submit', '#add_form_jurusan', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/jurusan/add/' + $('#idjurusan_add').val(),
            data: $('#add_form_jurusan').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/jurusan'
                        break
                    case 'FALSE':
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan jurusan baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Id Jurusan sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('submit', '#edit_form_jurusan', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/jurusan/edit/' + id,
            data: $('#edit_form_jurusan').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/jurusan'
                        break
                    case 'FALSE':
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('click', '#save_delete_jurusan', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/jurusan/delete/' + id,
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/jurusan'
                        break
                    case 'FALSE':
                        $('#error_delete_jurusan').fadeIn('slow', function() {
                            $("#error_delete_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_jurusan').fadeIn('slow', function() {
                            $("#error_delete_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

})

//==================//
//  mahasiswa page  //
// fix me //
//==================//
$(document).ready(function() {
    var id

    $("#add_mahasiswa").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/mahasiswa/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='edit_mahasiswa_']").on('click', function(event) {
        event.preventDefault()
        id = this.id.replace('edit_mahasiswa_', '')
        $.ajax({
            url: '/mahasiswa/read/' + id,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='delete_mahasiswa_']").click(function(event) {
        event.preventDefault()
        id = this.id.replace('delete_mahasiswa_', '')
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete mahasiswa</h1></div><div id="error_delete_mahasiswa"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus mahasiswa.<br><strong>Hapus mahasiswa?</strong></h4></div></div><div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_mahasiswa"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"><button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
    })

    $('body').on('submit', '#add_form_mahasiswa', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/mahasiswa/add/' + $('#nim_add').val(),
            data: $('#add_form_mahasiswa').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/mahasiswa'
                        break
                    case 'FALSE':
                        $('#error_form_mahasiswa').fadeIn('slow', function() {
                            $("#error_form_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan mahasiswa baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_mahasiswa').fadeIn('slow', function() {
                            $("#error_form_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Id mahasiswa sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('submit', '#edit_form_mahasiswa', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/mahasiswa/edit/' + id,
            data: $('#edit_form_mahasiswa').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/mahasiswa'
                        break
                    case 'FALSE':
                        $('#error_form_mahasiswa').fadeIn('slow', function() {
                            $("#error_form_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_mahasiswa').fadeIn('slow', function() {
                            $("#error_form_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('click', '#save_delete_mahasiswa', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/mahasiswa/delete/' + id,
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/mahasiswa'
                        break
                    case 'FALSE':
                        $('#error_delete_mahasiswa').fadeIn('slow', function() {
                            $("#error_delete_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_mahasiswa').fadeIn('slow', function() {
                            $("#error_delete_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })  
})

//==============//
//  dosen page  //
//==============//
$(document).ready(function() {
    var id

    $("#add_dosen").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/dosen/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='edit_dosen_']").on('click', function(event) {
        event.preventDefault()
        id = this.id.replace('edit_dosen_', '')
        $.ajax({
            url: '/dosen/read/' + id,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='delete_dosen_']").click(function(event) {
        event.preventDefault()
        id = this.id.replace('delete_dosen_', '')
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete dosen</h1></div><div id="error_delete_dosen"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus dosen.<br><strong>Hapus dosen?</strong></h4></div></div><div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_dosen"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"><button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
    })

    $('body').on('submit', '#add_form_dosen', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/dosen/add/' + $('#id_dosen_add').val(),
            data: $('#add_form_dosen').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/dosen'
                        break
                    case 'FALSE':
                        $('#error_form_dosen').fadeIn('slow', function() {
                            $("#error_form_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan dosen baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_dosen').fadeIn('slow', function() {
                            $("#error_form_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Id dosen sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('submit', '#edit_form_dosen', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/dosen/edit/' + id,
            data: $('#edit_form_dosen').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/dosen'
                        break
                    case 'FALSE':
                        $('#error_form_dosen').fadeIn('slow', function() {
                            $("#error_form_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_dosen').fadeIn('slow', function() {
                            $("#error_form_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('click', '#save_delete_dosen', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/dosen/delete/' + id,
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/dosen'
                        break
                    case 'FALSE':
                        $('#error_delete_dosen').fadeIn('slow', function() {
                            $("#error_delete_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_dosen').fadeIn('slow', function() {
                            $("#error_delete_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })
})

//===================//
//  matakuliah page  //
//===================//
$(document).ready(function() {
    var id

    $("#add_matakuliah").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/matakuliah/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='edit_matakuliah_']").on('click', function(event) {
        event.preventDefault()
        id = this.id.replace('edit_matakuliah_', '')
        $.ajax({
            url: '/matakuliah/read/' + id,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='delete_matakuliah_']").click(function(event) {
        event.preventDefault()
        id = this.id.replace('delete_matakuliah_', '')
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete matakuliah</h1></div><div id="error_delete_matakuliah"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus matakuliah.<br><strong>Hapus matakuliah?</strong></h4></div></div><div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_matakuliah"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"><button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
    })

    $('body').on('submit', '#add_form_matakuliah', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/matakuliah/add/' + $('#idmatakuliah_add').val(),
            data: $('#add_form_matakuliah').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/matakuliah'
                        break
                    case 'FALSE':
                        $('#error_form_matakuliah').fadeIn('slow', function() {
                            $("#error_form_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan matakuliah baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_matakuliah').fadeIn('slow', function() {
                            $("#error_form_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Id matakuliah sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('submit', '#edit_form_matakuliah', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/matakuliah/edit/' + id,
            data: $('#edit_form_matakuliah').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/matakuliah'
                        break
                    case 'FALSE':
                        $('#error_form_matakuliah').fadeIn('slow', function() {
                            $("#error_form_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_matakuliah').fadeIn('slow', function() {
                            $("#error_form_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('click', '#save_delete_matakuliah', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/matakuliah/delete/' + id,
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/matakuliah'
                        break
                    case 'FALSE':
                        $('#error_delete_matakuliah').fadeIn('slow', function() {
                            $("#error_delete_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_matakuliah').fadeIn('slow', function() {
                            $("#error_delete_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })
})

//===================//
//  ajar page  //
//===================//
$(document).ready(function() {
    var id

    $("#add_ajar").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/ajar/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='edit_ajar_']").on('click', function(event) {
        event.preventDefault()
        id = this.id.replace('edit_ajar_', '')
        $.ajax({
            url: '/ajar/read/' + id,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='delete_ajar_']").click(function(event) {
        event.preventDefault()
        id = this.id.replace('delete_ajar_', '')
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete ajar</h1></div><div id="error_delete_ajar"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus ajar.<br><strong>Hapus ajar?</strong></h4></div></div><div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_ajar"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"><button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
    })

    $('body').on('submit', '#add_form_ajar', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/ajar/add/' + $('#idajar_add').val(),
            data: $('#add_form_ajar').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/ajar'
                        break
                    case 'FALSE':
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan ajar baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Id ajar sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('submit', '#edit_form_ajar', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/ajar/edit/' + id,
            data: $('#edit_form_ajar').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/ajar'
                        break
                    case 'FALSE':
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('click', '#save_delete_ajar', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/ajar/delete/' + id,
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/ajar'
                        break
                    case 'FALSE':
                        $('#error_delete_ajar').fadeIn('slow', function() {
                            $("#error_delete_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_ajar').fadeIn('slow', function() {
                            $("#error_delete_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })
})

//===================//
//  uangkuliah page  //
//===================//
$(document).ready(function() {
    var id

    $("#add_uangkuliah").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/uangkuliah/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='edit_uangkuliah_']").on('click', function(event) {
        event.preventDefault()
        id = this.id.replace('edit_uangkuliah_', '')
        $.ajax({
            url: '/uangkuliah/read/' + id,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='delete_uangkuliah_']").click(function(event) {
        event.preventDefault()
        id = this.id.replace('delete_uangkuliah_', '')
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete uangkuliah</h1></div><div id="error_delete_uangkuliah"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus uangkuliah.<br><strong>Hapus uangkuliah?</strong></h4></div></div><div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_uangkuliah"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"><button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
    })

    $('body').on('submit', '#add_form_uangkuliah', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/uangkuliah/add/' + $('#iduangkuliah_add').val(),
            data: $('#add_form_uangkuliah').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/uangkuliah'
                        break
                    case 'FALSE':
                        $('#error_form_uangkuliah').fadeIn('slow', function() {
                            $("#error_form_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan uangkuliah baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_uangkuliah').fadeIn('slow', function() {
                            $("#error_form_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Id uangkuliah sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('submit', '#edit_form_uangkuliah', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/uangkuliah/edit/' + id,
            data: $('#edit_form_uangkuliah').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/uangkuliah'
                        break
                    case 'FALSE':
                        $('#error_form_uangkuliah').fadeIn('slow', function() {
                            $("#error_form_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_uangkuliah').fadeIn('slow', function() {
                            $("#error_form_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('click', '#save_delete_uangkuliah', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/uangkuliah/delete/' + id,
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/uangkuliah'
                        break
                    case 'FALSE':
                        $('#error_delete_uangkuliah').fadeIn('slow', function() {
                            $("#error_delete_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_uangkuliah').fadeIn('slow', function() {
                            $("#error_delete_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })
})

//=================//
//  orangtua page  //
//=================//
$(document).ready(function() {
    var id

    $("#add_orangtua").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/orangtua/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='edit_orangtua_']").on('click', function(event) {
        event.preventDefault()
        id = this.id.replace('edit_orangtua_', '')
        $.ajax({
            url: '/orangtua/read/' + id,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $("button[id^='delete_orangtua_']").click(function(event) {
        event.preventDefault()
        id = this.id.replace('delete_orangtua_', '')
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete orangtua</h1></div><div id="error_delete_orangtua"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus orangtua.<br><strong>Hapus orangtua?</strong></h4></div></div><div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_orangtua"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"><button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
    })

    $('body').on('submit', '#add_form_orangtua', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/orangtua/add/' + $('#id_orangtua_add').val(),
            data: $('#add_form_orangtua').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/orangtua'
                        break
                    case 'FALSE':
                        $('#error_form_orangtua').fadeIn('slow', function() {
                            $("#error_form_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan orangtua baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_orangtua').fadeIn('slow', function() {
                            $("#error_form_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Id orangtua sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('submit', '#edit_form_orangtua', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/orangtua/edit/' + id,
            data: $('#edit_form_orangtua').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/orangtua'
                        break
                    case 'FALSE':
                        $('#error_form_orangtua').fadeIn('slow', function() {
                            $("#error_form_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_orangtua').fadeIn('slow', function() {
                            $("#error_form_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $('body').on('click', '#save_delete_orangtua', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/orangtua/delete/' + id,
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        window.location = '/orangtua'
                        break
                    case 'FALSE':
                        $('#error_delete_orangtua').fadeIn('slow', function() {
                            $("#error_delete_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_orangtua').fadeIn('slow', function() {
                            $("#error_delete_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })
})
