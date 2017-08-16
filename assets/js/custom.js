//==============//
//  login page  //
//==============//

$(document).ready(function(){
    $('body').on('submit', '#login', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/auth/login',
            data: $('#login').serialize(),
            success: function(response) {
                if (response === 'TRUE') {
                    window.location = '/main'
                }
                else {
                    $('#error').fadeIn('slow', function() {
                        $("#error").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Wrong username or password!</div>')
                    })
                }
            }   
        })
    })
})

//==============//
//  users page  //
//==============//
$(document).ready(function() {
    var id,
    modaldelete ="<div class='modal-header alert-danger'><h1 class='modal-title'>Delete User</h1></div><div id='error_delete_user'></div><div class='modal-body'><div class='alert'><h4>Tindakan ini akan menghapus pengguna secara permanen.<br><strong>Hapus pengguna?</strong></h4></div></div><div class='modal-footer'><div class='col-xs-6'><button class='btn btn-danger' type='button' id='save_delete_user'><i class='fa fa-trash'></i> Delete</button></div><div class='col-xs-6 push-left'><button class='btn btn-default push-left' type='button' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button></div></div>"
    
    $('body').on('click', '#show_password', function() {
        ($("input[id^='password_']").attr('type') === 'password' ? $("input[id^='password_']").attr('type', 'text') && $('#show_password_icon').removeClass('fa-eye-slash') && $('#show_password_icon').addClass('fa-eye') : $("input[id^='password_']").attr('type', 'password') && $('#show_password_icon').removeClass('fa-eye') && $('#show_password_icon').addClass('fa-eye-slash'))
    })

    $("button[id^='edit_user']").on('click', function() {
        id = this.id.replace('edit_user_', '')
        $.ajax({
            url: '/users/read/' + id,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : '')
            }
        })
    })

    $("button[id^='delete_user_']").click(function() {
        id = this.id.replace('delete_user_', '')
        $('.modal-content').html(modaldelete)
    })

    $("button[id='add_user']").on('click', function() {
        $.ajax({
            url: '/users/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : '')
            }
        })
    })

    $('body').on('submit', '#add_form_user', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            type: 'post',
            url: '/users/add',
            data: $('#add_form_user').serialize(),
            success: function(response){
                switch (response) {
                    case 'TRUE':
                        console.log(response)
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        console.log(response)
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        console.log(response)
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
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
                        $('#error_delete_user').fadeIn('slow', function() {
                            $("#error_delete_user").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menghapus data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_delete_user').fadeIn('slow', function() {
                            $("#error_delete_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_user').fadeIn('slow', function() {
                            $("#error_delete_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
                        })
                        break
                }
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
                    case 'TRUE':
                        console.log(response)
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        console.log(response)
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        console.log(response)
                        $('#error_form_user').fadeIn('slow', function() {
                            $("#error_form_user").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data sudah ada!</div>')
                        })
                        break
                }
            }
        })
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
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete Jurusan</h1></div><div id="error_delete_jurusan"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus jurusan.<br><strong>Hapus jurusan?</strong></h4></div></div><div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_jurusan"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"><button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
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
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan jurusan baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Jurusan sudah ada!</div>')
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
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan perubahan jurusan!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_jurusan').fadeIn('slow', function() {
                            $("#error_form_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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
                        $('#error_delete_jurusan').fadeIn('slow', function() {
                            $("#error_delete_jurusan").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menghapus data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_delete_jurusan').fadeIn('slow', function() {
                            $("#error_delete_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menghapus jurusan!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_jurusan').fadeIn('slow', function() {
                            $("#error_delete_jurusan").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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

    $("#add_mahasiswa").on('click', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/mahasiswa/add',
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
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
                        $('#error_form_mahasiswa').fadeIn('slow', function() {
                            $("#error_form_mahasiswa").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_mahasiswa').fadeIn('slow', function() {
                            $("#error_form_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan mahasiswa baru!</div>')
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
                        $('#error_form_mahasiswa').fadeIn('slow', function() {
                            $("#error_form_mahasiswa").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_mahasiswa').fadeIn('slow', function() {
                            $("#error_form_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan perubahan mahasiswa!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_mahasiswa').fadeIn('slow', function() {
                            $("#error_form_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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
                        $('#error_delete_mahasiswa').fadeIn('slow', function() {
                            $("#error_delete_mahasiswa").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menghapus data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_delete_mahasiswa').fadeIn('slow', function() {
                            $("#error_delete_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menghapus mahasiswa!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_mahasiswa').fadeIn('slow', function() {
                            $("#error_delete_mahasiswa").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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
            url: '/dosen/add',
            data: $('#add_form_dosen').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        $('#error_form_dosen').fadeIn('slow', function() {
                            $("#error_form_dosen").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_dosen').fadeIn('slow', function() {
                            $("#error_form_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan dosen baru!</div>')
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
                        $('#error_form_dosen').fadeIn('slow', function() {
                            $("#error_form_dosen").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_dosen').fadeIn('slow', function() {
                            $("#error_form_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan perubahan dosen!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_dosen').fadeIn('slow', function() {
                            $("#error_form_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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
                        $('#error_delete_dosen').fadeIn('slow', function() {
                            $("#error_delete_dosen").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menghapus data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_delete_dosen').fadeIn('slow', function() {
                            $("#error_delete_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menghapus dosen!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_dosen').fadeIn('slow', function() {
                            $("#error_delete_dosen").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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

    $("button[id^='edit_matakuliah_']").on('click', function() {
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

    $('body').on('submit', '#add_form_matakuliah', function() {
        event.preventDefault()
        $.ajax({
            type: 'post',
            url: '/matakuliah/add',
            data: $('#add_form_matakuliah').serialize(),
            success: function(response) {
                console.log(response)
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        $('#error_form_matakuliah').fadeIn('slow', function() {
                            $("#error_form_matakuliah").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_matakuliah').fadeIn('slow', function() {
                            $("#error_form_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan mata kuliah baru!</div>')
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
        return false
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
                        $('#error_form_matakuliah').fadeIn('slow', function() {
                            $("#error_form_matakuliah").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Data berhasil diubah!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_matakuliah').fadeIn('slow', function() {
                            $("#error_form_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_matakuliah').fadeIn('slow', function() {
                            $("#error_form_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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
                        $('#error_delete_matakuliah').fadeIn('slow', function() {
                            $("#error_delete_matakuliah").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Data Berhasil Dihapus!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_delete_matakuliah').fadeIn('slow', function() {
                            $("#error_delete_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pengguna baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_matakuliah').fadeIn('slow', function() {
                            $("#error_delete_matakuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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
            url: '/ajar/add/',
            data: $('#add_form_ajar').serialize(),
            success: function(response) {
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan data mengajar baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Dosen sudah mengajar mata kuliah ini!</div>')
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
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan perubahan data mengajar!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_ajar').fadeIn('slow', function() {
                            $("#error_form_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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
                        $('#error_delete_ajar').fadeIn('slow', function() {
                            $("#error_delete_ajar").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menghapus data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_delete_ajar').fadeIn('slow', function() {
                            $("#error_delete_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menghapus data mengajar!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_ajar').fadeIn('slow', function() {
                            $("#error_delete_ajar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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

    $('body').on('change', 'input[id^="tgl_buka_"]', function(event) {
        var tgl_buka = new Date($('input[id^="tgl_buka_"]').val())
        var tgl = (tgl_buka.getDate() < 10 ? '0' : '')+tgl_buka.getDate()
        var bulan = (tgl_buka.getMonth()+1 < 10 ? '0' : '')+ (tgl_buka.getMonth()+1)
        var tahun = tgl_buka.getFullYear()
        var tgl_tutup = tahun+'-'+bulan+'-'+tgl
        $('input[id^="tgl_tutup_"]').val(tgl_tutup)
    
        console.log(tgl_buka)
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
                        $('#error_form_uangkuliah').fadeIn('slow', function() {
                            $("#error_form_uangkuliah").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
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
                if (response.search('!LOGIN')=== 0){
                    window.location = '/auth/logout'
                }
                else if (response.search('TRUE')=== 0){
                    $('#error_form_uangkuliah').fadeIn('slow', function() {
                        $("#error_form_uangkuliah").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                    })

                }
                else if (response.search('FALSE')=== 0){
                    $('#error_form_uangkuliah').fadeIn('slow', function() {
                        $("#error_form_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan perubahan uang kuliah!</div>')
                    })

                }
                else if (response.search('ERROR')=== 0){
                    $('#error_form_uangkuliah').fadeIn('slow', function() {
                        $("#error_form_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
                    })

                }
                switch (response) {
                    case '!LOGIN':
                        break
                    case 'TRUE':
                        break
                    case 'FALSE':
                        break
                    case 'ERROR':
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
                        $('#error_delete_uangkuliah').fadeIn('slow', function() {
                            $("#error_delete_uangkuliah").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menghapus data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_delete_uangkuliah').fadeIn('slow', function() {
                            $("#error_delete_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menghapus uang kuliah!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_uangkuliah').fadeIn('slow', function() {
                            $("#error_delete_uangkuliah").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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
            url: '/orangtua/add',
            data: $('#add_form_orangtua').serialize(),
            success: function(response) {
                console.log(response)
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        $('#error_form_orangtua').fadeIn('slow', function() {
                            $("#error_form_orangtua").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_orangtua').fadeIn('slow', function() {
                            $("#error_form_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan orangtua baru!</div>')
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
                        $('#error_form_orangtua').fadeIn('slow', function() {
                            $("#error_form_orangtua").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_orangtua').fadeIn('slow', function() {
                            $("#error_form_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan perubahan orangtua!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_form_orangtua').fadeIn('slow', function() {
                            $("#error_form_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
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
                        $('#error_delete_orangtua').fadeIn('slow', function() {
                            $("#error_delete_orangtua").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menghapus data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_delete_orangtua').fadeIn('slow', function() {
                            $("#error_delete_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menghapus orangtua!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_orangtua').fadeIn('slow', function() {
                            $("#error_delete_orangtua").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
                        })
                        break
                }
            }
        })
    })
})

//=================//
//  bayar page  //
//=================//
$(document).ready(function() {
    var uri

    $('a[id^="bayar_add_"]').on('click', function(event) {
        event.preventDefault()
        uri = this.id.replace(/_/g, '/')
        console.log(uri)
        $.ajax({
            url: '/'+uri,
            success: function(response) {
                (response !== '!LOGIN' ? $('.modal-content').html(response) : window.location = '/auth/logout')
            }
        })
    })

    $('body').on('change', '#tgl_bayar_add', function(event) {
    })

    $('body').on('keyup', '#nominal_bayar_add', function() {
        var tipe = uri.replace('bayar/add/', '')
        $.ajax({
            url: '/bayar/validate_payment/'+tipe+'/'+$('#nim_bayar_add').val()+'/'+$('#nominal_bayar_add').val()+'/'+$('#semester_bayar_add').val(),
            success: function(response) {
                console.log(uri)
                if(response !== '') {
                    $('#nominal_bayar_add').val(response)
                }
            }
        })
    })

    $('body').on('submit', '#add_form_bayar', function(event) {
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/'+ uri,
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response)
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        $('#error_form_bayar').fadeIn('slow', function() {
                            $("#error_form_bayar").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menyimpan data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_form_bayar').fadeIn('slow', function() {
                            $("#error_form_bayar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menyimpan pembayaran baru!</div>')
                        })
                        break
                    default:
                        $('#error_form_bayar').fadeIn('slow', function() {
                            $("#error_form_bayar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; '+response+'</div>')
                        })
                        break
                }
            }
        })
    })

    $("button[id^='bayar_delete_']").click(function(event) {
        event.preventDefault()
        uri = this.id.replace(/_/g, '/')
        console.log(uri)
        $('.modal-content').html('<div class="modal-header alert-danger"><h1 class="modal-title">Delete Data Pembayaran</h1></div><div id="error_delete_bayar"></div><div class="modal-body"><div class="alert"><h4>Tindakan ini akan menghapus pembayaran.<br><strong>Hapus pembayaran?</strong></h4></div></div><div class="modal-footer"><div class="col-xs-6"><button class="btn btn-danger" type="button" id="save_delete_bayar"><i class="fa fa-trash"></i> Delete</button></div><div class="col-xs-6 push-left"><button class="btn btn-default push-left" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button></div></div>')
    })

    $('body').on('click', '#save_delete_bayar', function(event) {
        event.preventDefault()
        $.ajax({
            url: '/'+uri,
            success: function(response) {
                console.log(response)
                switch (response) {
                    case '!LOGIN':
                        window.location = '/auth/logout'
                        break
                    case 'TRUE':
                        $('#error_delete_bayar').fadeIn('slow', function() {
                            $("#error_delete_bayar").html('<div class="alert alert-success"> <span class="fa fa-exclamation"></span> &nbsp; Berhasil menghapus data!</div>')
                        })
                        break
                    case 'FALSE':
                        $('#error_delete_bayar').fadeIn('slow', function() {
                            $("#error_delete_bayar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Gagal menghapus pembayaran baru!</div>')
                        })
                        break
                    case 'ERROR':
                        $('#error_delete_bayar').fadeIn('slow', function() {
                            $("#error_delete_bayar").html('<div class="alert alert-danger"> <span class="fa fa-exclamation"></span> &nbsp; Data tidak ada!</div>')
                        })
                        break
                }
            }
        })
    })
})

//==============//
//  nilai page  //
//==============//
$(document).ready(function() {
    $('[id^="matakuliah_nilai"]').on('change', function(event) {
        if ($('[id^="matakuliah_nilai"]').val() !== '') {
            $.ajax({
                url: '/nilai/getKelas/'+$('[id^="matakuliah_nilai"]').val().substr(1),
                success: function(response) {
                    response === '!LOGIN' ? window.location = '/' : $('[id^="kelas_nilai"]').val('') && $('[id^="kelas_nilai"]').attr('disabled', false).html(response) && $('[id^="jenis_nilai"]').val('') && $('[id^="jenis_nilai"]').attr('disabled', false)
                }
            })
        }
        else
        {
            $('#form-nilai').html('')
            $('#save-form-nilai').addClass('hide')
            $('[id^="kelas_nilai"]').attr('disabled', true).html('')
            $('#pengambilan_nilai').addClass('hide')
            $('[id^="jenis_nilai"]').attr('disabled', true).val('')
        }
    })

    $('[id^="kelas_nilai"]').change(function(event) {
        $('[id^="jenis_nilai"]').val('')
        $('#form-nilai').html('')
        $('#save-form-nilai').addClass('hide')
        $('#pengambilan_nilai').addClass('hide')
    })

    $('#browse_nilai').on('submit',function(event){
        event.preventDefault()
        // console.log($('#pencarian_nilai').serialize())
        $.ajax({
            cache: false,
            url: '/nilai/browse',
            type: 'POST',
            data: $('#browse_nilai').serialize(),
            success: function(response){
                (response === '!LOGIN' ? window.location = '/' : $('.table-responsive').html(response))
            }
        })
    })

    $('#jenis_nilai_add').on('change', function(event) {
        event.preventDefault()
        if($('#jenis_nilai_add').val() !== '' && $('#matakuliah_nilai_add').val() !== '' && $('#kelas_nilai_add').val() !== ''){
            $.ajax({
                cache: false,
                url: '/nilai/add/',
                method: 'post',
                data: $('#form_add_nilai').serialize(),
                success: function(response) {
                    $('#save-form-nilai').removeClass('hide')
                    $('#form-nilai').html(response)
                }
            })
        }
        else{
            $('#form-nilai').html('')
            $('#save-form-nilai').addClass('hide')
        }
    })

    $('#jenis_nilai_edit').on('change', function(event) {
        event.preventDefault()
        if($('#jenis_nilai_edit').val() !== '' && $('#jenis_nilai_edit').val() !== 'nilai_lain' && $('#matakuliah_nilai_edit').val() !== '' && $('#kelas_nilai_edit').val() !== ''){
            $.ajax({
                cache: false,
                url: '/nilai/read',
                method: 'post',
                data: {
                    matakuliah: $('#matakuliah_nilai_edit').val(),
                    jenis: $('#jenis_nilai_edit').val(),
                    kelas: $('#kelas_nilai_edit').val(),
                    pengambilan: $('#pengambilan_nilai_edit').val(),
                },
                success: function(response) {
                    console.log($('#form_edit_nilai').serialize())
                    $('#save-form-nilai').removeClass('hide')
                    $('#form-nilai').html(response)
                    $('#pengambilan_nilai').addClass('hide')
                }
            })
        }
        else if($('#jenis_nilai_edit').val() === 'nilai_lain' && $('#matakuliah_nilai_edit').val() !== '' && $('#kelas_nilai_edit').val() !== ''){
            $.ajax({
                cache: false,
                url: '/nilai/getPengambilan/'+$('#matakuliah_nilai_edit').val().substr(1)+'/'+$('#kelas_nilai_edit').val()+'/'+$('#matakuliah_nilai_edit').val().substr(0,1),
                success: function(response) {
                    $('#pengambilan_nilai').removeClass('hide')
                    $('#pengambilan_nilai_edit').html(response)
                }
            })
        }
        else{
            $('#pengambilan_nilai').addClass('hide')
            $('#form-nilai').html('')
            $('#save-form-nilai').addClass('hide')
        }
    })

    $('#pengambilan_nilai_edit').on('change', function(event) {
        event.preventDefault()
        if($('#jenis_nilai_edit').val() !== '' && $('#pengambilan_nilai_edit').val() !== '' && $('#matakuliah_nilai_edit').val() !== '' && $('#kelas_nilai_edit').val() !== ''){
            $.ajax({
                cache: false,
                url: '/nilai/read/',
                method: 'post',
                data: $('#form_edit_nilai').serialize(),
                success: function(response) {
                    $('#save-form-nilai').removeClass('hide')
                    $('#form-nilai').html(response)
                }
            })
        }
    })

    $('body').on('submit','#form_add_nilai',function(event){
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/nilai/add/TRUE',
            method: 'post',
            data: $('#form_add_nilai').serialize(),
            success: function(response) {
                // console.log(response)
                switch(response) {
                    case 'TRUE':
                        $('#form-nilai').html('<div class="alert alert-success"><span class="fa fa-check"></span> &nbsp; Data nilai berhasil disimpan!</div>') && $('#save-form-nilai').addClass('hide')
                        break
                    case 'FALSE':
                        $('#form-nilai').html('<div class="alert alert-danger"><span class="fa fa-exclamation"></span> &nbsp; Data nilai gagal disimpan!</div>') && $('#save-form-nilai').addClass('hide')
                        break
                    case 'ERROR':
                        $('#form-nilai').html('<div class="alert alert-warning"><span class="fa fa-exclamation"></span> &nbsp; Data nilai sudah ada!</div>') && $('#save-form-nilai').addClass('hide')
                        break
                }
            },
        })
    })

    $('body').on('submit','#form_edit_nilai',function(event){
        event.preventDefault()
        $.ajax({
            cache: false,
            url: '/nilai/edit',
            method: 'post',
            data: $('#form_edit_nilai').serialize(),
            success: function(response) {
                // console.log(response)
                switch(response) {
                    case 'TRUE':
                        $('#error_form_edit_nilai').html('<div class="alert alert-success"><span class="fa fa-check"></span> &nbsp; Data nilai berhasil disimpan!</div>') && $('#save-form-nilai').addClass('hide')
                        break
                    case 'FALSE':
                        $('#error_form_edit_nilai').html('<div class="alert alert-danger"><span class="fa fa-exclamation"></span> &nbsp; Data nilai gagal disimpan!</div>') && $('#save-form-nilai').addClass('hide')
                        break
                    case 'ERROR':
                        $('#error_form_edit_nilai').html('<div class="alert alert-warning"><span class="fa fa-exclamation"></span> &nbsp; Data nilai tidak ada!</div>') && $('#save-form-nilai').addClass('hide')
                        break
                }
            },
        })
    })
})

//============//
//  khs page  //
//============//
$(document).ready(function() {
  $('#read_khs').submit(function(event) {
    event.preventDefault()
      $.ajax({
          url: '/KHS/read',
          type: 'POST',
          data: {semester: $('#semester_khs').val()},
          success: function(response) {
            (response !== '!LOGIN' ? $('#table-khs').html(response) : window.location = '/')
          }
      })
  })
})

// //====================//
// //  kartu ujian page  //
// //====================//
// $(document).ready(function() {
//     function opt_kelas() {
//         $.ajax({
//           url: '/kartu_ujian/browse_kelas/'+$('#kartu-ujian-jurusan').val()+'/'+$('#kartu-ujian-semester').val(),
//           success: function(response) {
//             (response !== '!LOGIN' ? $('#kartu-ujian-kelas').html(response) : window.location = '/')
//           }
//       })
//     }

//     function opt_matakuliah() {
//         $.ajax({
//           url: '/kartu_ujian/browse_matakuliah/'+$('#kartu-ujian-jurusan').val()+'/'+$('#kartu-ujian-semester').val(),
//           success: function(response) {
//             (response !== '!LOGIN' ? $('#kartu-ujian-jadwal').html(response) : window.location = '/')
//           }
//       })
//     }

//   // $('#kartu-ujian-semester').change(function(event) {
//   //   event.preventDefault()
//   //   opt_kelas($('#kartu-ujian-jurusan').val(), $('#kartu-ujian-semester').val()) &&
//   //   opt_matakuliah($('#kartu-ujian-jurusan').val(), $('#kartu-ujian-semester').val())
//   // })

// })

