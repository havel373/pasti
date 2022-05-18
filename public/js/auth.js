$("body").on("contextmenu", "img", function (e) {
    return false;
});
$('img').attr('draggable', false);
$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function auth_content(cont) {
    $('#login_page').hide();
    $('#register_page').hide();
    $('#forgot_page').hide();
    $('#' + cont).show();
}
$("#form_login").on('keydown', 'input', function (event) {
    if (event.which == 13) {
        event.preventDefault();
        var $this = $(event.target);
        var index = parseFloat($this.attr('data-login'));
        var val = $($this).val();
        if (val == 1) {
            $('[data-login="' + (index + 1).toString() + '"]').focus();
        } else {
            $('#tombol_login').trigger("click");
        }
    }
});
var KTSigninGeneral = (function () {
    var e, t, i;
    return {
        init: function () {
            (e = document.querySelector("#form_login")),
                (t = document.querySelector("#tombol_login")),
                (i = FormValidation.formValidation(e, {
                    fields: {
                        email: { validators: { notEmpty: { message: "Email address is required" }, emailAddress: { message: "The value is not a valid email address" } } },
                        password: {
                            validators: {
                                notEmpty: { message: "The password is required" },
                                callback: {
                                    message: "Please enter valid password",
                                    callback: function (e) {
                                        if (e.value.length > 8) return _validatePassword();
                                    },
                                },
                            },
                        },
                    },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),
                t.addEventListener("click", function (n) {
                    n.preventDefault(),
                        i.validate().then(function (i) {
                            login_data = {
                                email: $("#email_login").val(),
                                password: $("#password_login").val()
                            };
                            if (i == "Valid") {
                                t.setAttribute("data-kt-indicator", "on"), (t.disabled = !0);
                                $.ajax({
                                    type: "POST",
                                    url: "auth/login",
                                    data: login_data,
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.alert == "success") {
                                            setTimeout(function () {
                                                t.removeAttribute("data-kt-indicator"),
                                                    (t.disabled = !1),
                                                    Swal.fire({ text: response.message, icon: "success", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } }).then(function (t) {
                                                        t.isConfirmed && (e.reset());
                                                    }).then(function () {
                                                        if(response.route){
                                                            location.href = response.route;
                                                        }
                                                    });
                                            }, 2e3);
                                        } else {
                                            setTimeout(function () {
                                                t.removeAttribute("data-kt-indicator"),
                                                    (t.disabled = !1),
                                                    Swal.fire({ text: response.message, icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } }).then(function (t) {
                                                        // t.isConfirmed && (e.reset());
                                                    });
                                            }, 2e3);
                                        }
                                    }
                                });
                            } else {
                                t.removeAttribute("data-kt-indicator"), (t.disabled = !1);
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: { confirmButton: "btn btn-primary" },
                                });
                            }
                        });
                });
        },
    };
})();

KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
var KTSignupGeneral = (function () {
    var e, t, a, s, r = function () {
        return 100 === s.getScore();
    };
    return {
        init: function () {
            (e = document.querySelector("#form_register")),
                (t = document.querySelector("#tombol_daftar")),
                (s = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]'))),
                (a = FormValidation.formValidation(e, {
                    fields: {
                        name: { validators: { notEmpty: { message: "Name is required" } } },
                        phone: { validators: { notEmpty: { message: "Phone is required" } } },
                        email: { validators: { notEmpty: { message: "Email address is required" }, emailAddress: { message: "The value is not a valid email address" } } },
                        password: {
                            validators: {
                                notEmpty: { message: "The password is required" },
                                callback: {
                                    message: "Please enter valid password",
                                    callback: function (e) {
                                    },
                                },
                            },
                        },
                        "confirm-password": {
                            validators: {
                                notEmpty: { message: "The password confirmation is required" },
                                identical: {
                                    compare: function () {
                                        return e.querySelector('[id="password_register"]').value;
                                    },
                                    message: "The password and its confirm are not the same",
                                },
                            },
                        },
                        toc: { validators: { notEmpty: { message: "You must accept the terms and conditions" } } },
                    },
                    plugins: { trigger: new FormValidation.plugins.Trigger({ event: { password: !1 } }), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),
                t.addEventListener("click", function (r) {
                    r.preventDefault(),
                        a.revalidateField("password"),
                        a.validate().then(function (a) {
                            register_data = {
                                name: $("#name").val(),
                                phone: $("#phone").val(),
                                email: $("#email_register").val(),
                                password: $("#password_register").val()
                            };
                            t.setAttribute("data-kt-indicator", "on"), (t.disabled = !0);
                            if (a == "Valid") {
                                $.ajax({
                                    type: "POST",
                                    url: "auth/register",
                                    data: register_data,
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.alert == "success") {
                                            setTimeout(function () {
                                                t.removeAttribute("data-kt-indicator"), (t.disabled = !1),
                                                    Swal.fire({ text: response.message, icon: "success", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } }).then(function (t) {
                                                        t.isConfirmed && (e.reset(), e.reset());
                                                    }).then(function () {
                                                        auth_content('login_page');
                                                    });
                                            }, 2e3);
                                        } else {
                                            setTimeout(function () {
                                                t.removeAttribute("data-kt-indicator"),
                                                    (t.disabled = !1),
                                                    Swal.fire({ text: response.message, icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } }).then(function (t) {
                                                        // 
                                                    });
                                            }, 2e3);
                                        }
                                    }
                                });
                            } else {
                                t.removeAttribute("data-kt-indicator"), (t.disabled = !1);
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: { confirmButton: "btn btn-primary" },
                                });
                            }
                        });
                }),
                e.querySelector('input[id="password_register"]').addEventListener("input", function () {
                    this.value.length > 0 && a.updateFieldStatus("password", "NotValidated");
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSignupGeneral.init();
});

var KTPasswordResetGeneral = (function () {
    var t, e, i;
    return {
        init: function () {
            (t = document.querySelector("#forgot_form")),
                (e = document.querySelector("#tombol_lupa")),
                (i = FormValidation.formValidation(t, {
                    fields: { email: { validators: { notEmpty: { message: "Email address is required" }, emailAddress: { message: "The value is not a valid email address" } } } },
                    plugins: { trigger: new FormValidation.plugins.Trigger(), bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: ".fv-row", eleInvalidClass: "", eleValidClass: "" }) },
                })),
                e.addEventListener("click", function (o) {
                    o.preventDefault(),
                        i.validate().then(function (i) {
                            forgot_data = {
                                email: $("#email_forgot").val()
                            };
                            e.setAttribute("data-kt-indicator", "on"), (t.disabled = !0);
                            if (i == "Valid") {
                                $.ajax({
                                    type: "POST",
                                    url: "auth/forgot",
                                    data: forgot_data,
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response.alert == "success") {
                                            setTimeout(function () {
                                                e.removeAttribute("data-kt-indicator"), (e.disabled = !1),
                                                    Swal.fire({ text: response.message, icon: "success", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } }).then(function (t) {
                                                        e.isConfirmed && (t.reset());
                                                    }).then(function () {
                                                        auth_content('login_page');
                                                    });
                                            }, 2e3);
                                        } else {
                                            setTimeout(function () {
                                                e.removeAttribute("data-kt-indicator"),
                                                    (e.disabled = !1),
                                                    Swal.fire({ text: response.message, icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn btn-primary" } }).then(function (t) {
                                                        // 
                                                    });
                                            }, 2e3);
                                        }
                                    }
                                });
                            } else {
                                e.removeAttribute("data-kt-indicator"), (e.disabled = !1);
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: { confirmButton: "btn btn-primary" },
                                });
                            }
                        });
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTPasswordResetGeneral.init();
});