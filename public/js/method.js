let page;
function main_content(cont){
    $('#content_list').hide();
    $('#content_input').hide();
    $('#content_detail').hide();
    $('#' + cont).show();
}

function payment_content(cont){
    $('#address_content').hide();
    $('#payment_content').hide();
    $('#order_content').hide();
    $('#' + cont).show();
}

function validate_address(){
    let address = $('#address').val(),
    province = $('#province').val(),
    city = $('#city').val(),
    subdistrict= $('#subdistrict').val(),
    postcode= $('#postcode').val(),
    select_service= $('#select_service').val(),
    select_ekspedisi= $('#select_ekspedisi').val();

    if( address.length  > 0 && 
        postcode.length > 0 &&
        select_service.length > 0 &&
        select_ekspedisi.length > 0) {
        payment_content('payment_content');
    }else{
        error_toastr('Lengkapi Data');
    }
   
}

$(window).on('hashchange', function(){
    if (window.location.hash) {
        page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        }else{
            load_list(page);
        }
    }
});
$(document).ready(function(){
    $(document).on('click', '.paginasi',function(event){
        event.preventDefault();
        $('.paginasi').removeClass('active');
        $(this).parent('.paginasi').addClass('active');
        // var myurl = $(this).attr('href');
        page = $(this).attr('halaman').split('page=')[1];
        load_list(page);
    });
});
load_cart(localStorage.getItem("route_cart"));
function load_cart(url){
    // let data = "view="+ view + "&load_keranjang=";
    $.ajax({
        type: "GET",
        url: url,
        dataType: 'json',
        success: function (response){
            $('.top-cart-items').html(response.collection);
            $('.top-checkout-price').html('Rp. '+thousand(response.total_harga));
            $('.top-cart-number').html(thousand(response.total_item) ?? 0);
        },
    });
}
function load_list(page){
    loading();
    $.get('?page=' + page, $('#content_filter').serialize(), function(result){
        $('#list_result').html(result);
        main_content('content_list');
        loaded();
    }, "html");
}
function load_input(url){
    loading();
    $.get(url, {}, function(result) {
        $('#content_input').html(result);
        main_content('content_input');
        loaded();
    }, "html");
}
function load_detail(url){
    loading();
    $.get(url, {}, function(result) {
        $('#content_detail').html(result);
        main_content('content_detail');
        loaded();
    }, "html");
}
function add_cart(tombol, form, url, title, product){
    $(tombol).submit(function () {
        return false;
    });
    let data = $(form).serialize()+"&product="+ product;
    $(tombol).prop("disabled", true);
    $(tombol).html("Please wait");
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'json',
        beforeSend: function() {
            
        },
        success: function (response) {
            if (response.alert=="success") {
                success_toastr(response.message);
                $(form)[0].reset();
                setTimeout(function () {
                    $(tombol).prop("disabled", false);
                        $(tombol).html(title);
                        load_cart(localStorage.getItem("route_cart"));
                }, 2000);
            } else {
                error_toastr(response.message);
                setTimeout(function () {
                    $(tombol).prop("disabled", false);
                    $(tombol).html(title);
                }, 2000);
            }
        },
    });
}
function handle_confirm(url){
    $.confirm({
        animationSpeed: 1000,
        animation: 'zoom',
        closeAnimation: 'scale',
        animateFromElement: false,
        columnClass: 'medium',
        title: 'Confirmation',
        content: 'Are you sure want to confirm this data ?',
        // icon: 'fa fa-question',
        theme: 'material',
        closeIcon: true,
        type: 'orange',
        autoClose: 'No|5000',
        buttons: {
            Yes: {
                btnClass: 'btn-red any-other-class',
                action: function(){
                    $.ajax({
                        type:"PATCH",
                        url: url,
                        dataType: "json",
                        success:function(response){
                            if (response.alert == "success") {
                                success_toastr(response.message);
                                load_list(1);
                            }else{
                                error_toastr(response.message);
                                load_list(1);
                            }
                        },
                    });
                }
            },
            No: {
                btnClass: 'btn-blue', // multiple classes.
                // ...
            }
        }
    });
}
function handle_delete(url){
    $.confirm({
        animationSpeed: 1000,
        animation: 'zoom',
        closeAnimation: 'scale',
        animateFromElement: false,
        columnClass: 'medium',
        title: 'Delete Confirmation',
        content: 'Are you sure want to delete this data ?',
        // icon: 'fa fa-question',
        theme: 'material',
        closeIcon: true,
        type: 'orange',
        autoClose: 'No|5000',
        buttons: {
            Yes: {
                btnClass: 'btn-red any-other-class',
                action: function(){
                    $.ajax({
                        type:"DELETE",
                        url: url,
                        dataType: "json",
                        success:function(response){
                            if (response.alert == "success") {
                                success_toastr(response.message);
                                load_list(1);
                                load_cart(localStorage.getItem("route_cart"));
                            }else{
                                error_toastr(response.message);
                                load_list(1);
                            }
                        },
                    });
                }
            },
            No: {
                btnClass: 'btn-blue', // multiple classes.
                // ...
            }
        }
    });
}

function handle_recomend(url){
    $.confirm({
        animationSpeed: 1000,
        animation: 'zoom',
        closeAnimation: 'scale',
        animateFromElement: false,
        columnClass: 'medium',
        title: 'Recomendation Confirmation',
        content: 'Anda yakin ingin merekomendasikan produk ini ?',
        // icon: 'fa fa-question',
        theme: 'material',
        closeIcon: true,
        type: 'orange',
        autoClose: 'No|5000',
        buttons: {
            Yes: {
                btnClass: 'btn-red any-other-class',
                action: function(){
                    $.ajax({
                        type:"PATCH",
                        url: url,
                        dataType: "json",
                        success:function(response){
                            if (response.alert == "success") {
                                success_toastr(response.message);
                                load_list(1);
                            }else{
                                error_toastr(response.message);
                                load_list(1);
                            }
                        },
                    });
                }
            },
            No: {
                btnClass: 'btn-blue', // multiple classes.
                // ...
            }
        }
    });
}

function handle_unrecomend(url){
    $.confirm({
        animationSpeed: 1000,
        animation: 'zoom',
        closeAnimation: 'scale',
        animateFromElement: false,
        columnClass: 'medium',
        title: 'Recomendation Confirmation',
        content: 'Anda yakin ingin membatalkan rekomendasi produk ini ?',
        // icon: 'fa fa-question',
        theme: 'material',
        closeIcon: true,
        type: 'orange',
        autoClose: 'No|5000',
        buttons: {
            Yes: {
                btnClass: 'btn-red any-other-class',
                action: function(){
                    $.ajax({
                        type:"PATCH",
                        url: url,
                        dataType: "json",
                        success:function(response){
                            if (response.alert == "success") {
                                success_toastr(response.message);
                                load_list(1);
                            }else{
                                error_toastr(response.message);
                                load_list(1);
                            }
                        },
                    });
                }
            },
            No: {
                btnClass: 'btn-blue', // multiple classes.
                // ...
            }
        }
    });
}

function handle_open_modal(url,modal,content){
    $.ajax({
        type: "POST",
        url: url,
        success: function (html) {
            $(content).html(html);
            $(modal).modal('show');
        },
        error: function () {
            $(content).html('<h3>Ajax Bermasalah !!!</h3>')
        },
    });
}
function handle_save(tombol, form, url, method, title){
    $(tombol).submit(function () {
        return false;
    });
    let data = $(form).serialize();
    $(tombol).prop("disabled", true);
    $(tombol).html("Please wait");
    $.ajax({
        type: method,
        url: url,
        data: data,
        dataType: 'json',
        beforeSend: function() {
            
        },
        success: function (response) {
            if (response.alert=="success") {
                success_toastr(response.message);
                $(form)[0].reset();
                setTimeout(function () {
                    $(tombol).prop("disabled", false);
                        $(tombol).html(title);
                        main_content('content_list');
                        load_list(1);
                }, 2000);
            } else {
                error_toastr(response.message);
                setTimeout(function () {
                    $(tombol).prop("disabled", false);
                    $(tombol).html(title);
                }, 2000);
            }
        },
    });
}
function handle_save_modal(tombol,form,url,modal, title){
    $(tombol).submit(function () {
        return false;
    });
    let data = $(form).serialize();
    // $(tombol).addClass(spinner);
    $(tombol).prop("disabled", true);
    $(tombol).html("Please wait");
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        dataType: 'json',
        success: function (response) {
            if (response.alert=="success") {
                success_toastr(response.message);
                $(form)[0].reset();
                $(modal).modal('toggle');
                setTimeout(function () {
                    $(tombol).html(title);
                    main_content('content_list');
                    load_list(1);
                }, 2000);
            } else {
                error_toastr(response.message);
                setTimeout(function () {
                    $(tombol).prop("disabled", false);
                    $(tombol).html(title);
                }, 2000);
            }
        },
    });
}
function handle_upload(tombol,form,url,method){
    $(document).one('submit', form, function (e) {
        let data = new FormData(this);
        data.append('_method', method);
        $(tombol).prop("disabled", true);
        $(tombol).html("Please Wait");
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            resetForm: true,
            processData: false,
            dataType: 'json',
            beforeSend: function() {
            
            },
            success: function (response) {
                if (response.alert=="success") {
                    success_toastr(response.message);
                    $(form)[0].reset();
                    setTimeout(function () {
                        if(response.redirect){
                            location.href = response.redirect;
                        }
                        $(tombol).prop("disabled", false);
                        main_content('content_list');
                        load_list(1);
                    }, 2000);
                } else {
                    error_toastr(response.message);
                    setTimeout(function () {
                        $(tombol).prop("disabled", false);
                    }, 2000);
                }
            },
        });
        return false;
    });
}