//$(function(){
//    (function(){
//        var csrf = $('[name = csrf]').attr('content');
//        $('[name = ___ft]').val(csrf);
//
//        var registerOptions = {
//            href: 'register',
//            overlayClose: true,
//            width: '60%',
//            height: '80%',
//            close: 'x',
//            onComplete: function() {
//                var csrf = $('[name = csrf]').attr('content');
//                $('[name = ___ft]').val(csrf);
//            }
//        },
//            loginOptions = {
//                href: 'login',
//                overlayClose: true,
//                width: '40%',
//                height: '60%',
//                close: 'x',
//                onComplete: function() {
//                    var csrf = $('[name = csrf]').attr('content');
//                    $('[name = ___ft]').val(csrf);
//                }
//            };
//
//        $('#registration').colorbox(registerOptions);
//        //$('#entrance').colorbox(loginOptions);
//
//        $('body').on('click', '#login-submit', function(){
//            $.ajax({
//                method: 'POST',
//                url: 'login',
//                data: {
//                    user: $('#user').val(),
//                    password: $('#password').val()
//                }
//            }).done(function(msg){
//                if(msg) {
//                    $('#cboxLoadedContent').html(msg);
//                } else {
//                    $(location).attr('href', 'home');
//                }
//            });
//        });
//
//        $('body').on('click', '#submit-registration', function(){
//            $.ajax({
//                method: 'POST',
//                url: 'register',
//                data: {
//                    user: $('#user').val(),
//                    password: $('#password').val(),
//                    confirm: $('#confirm-password').val(),
//                    fname: $('#fname').val(),
//                    family: $('#family').val(),
//                    email: $('#email').val()
//                }
//            }).done(function(msg){
//                if(msg) {
//                    $('#cboxLoadedContent').html(msg);
//                } else {
//                    $(location).attr('href', '');
//                }
//            });
//        });
//    }());
//});