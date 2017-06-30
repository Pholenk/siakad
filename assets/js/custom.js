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
                        $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + '</div>')
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

    $('#users_search').on('keyup', function() {
        if ($('#users_search').val() !== '') {
            $.ajax({
                url: '/users/read/search/' + $('#users_search').val(),
                success: function(result) {
                    (result !== '!LOGIN' ? $('#users-data').html(result) : window.location = '/auth/logout')
                }
            })

        } else {
            $.ajax({
                url: '/users/read/',
                success: function(result) {
                    (result !== '!LOGIN' ? $('#users-data').html(result) : window.location = '/auth/logout')
                }
            })
        }
    })

    $("button[id^='edit_user']").on('click', function(event) {
        event.preventDefault()
        id = this.id.replace('edit_user_', '')
        $.ajax({
            url: '/users/read/read/' + id,
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

    $('body').on('submit', '#edit_form_user', function() {
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
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Data sudah ada!</div>')
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
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })

    $("button[id^='delete_user_']").click(function(event) {
        id = this.id.replace('delete_user_', '')
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete User</h1></div><div id="error_delete_user"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus pengguna secara permanen.<br><strong>Hapus pengguna?</strong></h4></div></div> <div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_user"><i class="fa fa-save"></i> Save</button></div><div class="col-xs-6 push-left"> <button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
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
                            $("#error_delete_user").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_user').fadeIn('slow', function() {
                            $("#error_delete_user").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Data sudah ada!</div>')
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
    $('#jurusan_search').on('keyup', function() {
        if ($('#jurusan_search').val() !== '') {
            $.ajax({
                url: '/jurusan/read/search/' + $('#jurusan_search').val(),
                success: function(result) {
                    (result !== '!LOGIN' ? $('#jurusan-data').html(result) : window.location = '/auth/logout')
                }
            })
        } else {
            $.ajax({
                url: '/jurusan/read/',
                success: function(result) {
                    (result !== '!LOGIN' ? $('#jurusan-data').html(result) : window.location = '/auth/logout')
                }
            })
        }
    })

    $("#add_jurusan").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/jurusan/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
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
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Gagal menyimpan jurusan baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
    })
})