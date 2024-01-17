$(document).ready(function() {

    $(document).on('change','.header_button_bg_color',function () {
        var this_var = $(this);
        $('.widget-button-parent-div').find('button').css({"background":this_var.val()})
        $('.widget-button-parent-div').find('button').css({"background":this_var.val()})
        $('.widget-view-form').find('.card-header').css({"background":this_var.val()})
        $('.widget-view-form').find('.card-footer').find('button').css({"background":this_var.val()})
    });

    $(document).on('change','.header_button_text_color',function () {
        var this_var = $(this);

        $('.widget-button-parent-div').find('button').css({"color":this_var.val()})
        $('.widget-button-parent-div').find('.widget-svg').attr("fill",this_var.val())
        // $('.widget-view-form').find('.card-header').find('p').css({"color":this_var.val()})
        // $('.widget-view-form').find('.card-footer').find('button').css({"color":this_var.val()})
    });
    $(document).on('change','.body_bg_color',function () {
        var this_var = $(this);

        $('.widget-view-form').find('.card-body').css({"background": this_var.val()})
        $('.widget-view-form').find('.card-footer').css({"background": this_var.val()})
    });
    $(document).on('change','.body_text_color',function () {
        var this_var = $(this);

        $('.widget-view-form').find('.card-body,.card-body p,.card-body p b').css({"color":this_var.val()})
        // $('.widget-view-form').find('.card-body').find('input,textarea').css({"color":this_var.val()})
    });

    $(document).on('change','.font_family',function () {
        var this_var = $(this).val();
        $('.widget-view-form,.widget-button-parent-div').find('b,p,button,span').css("font-family",this_var)
    })

    $(document).on('change','.widget_position',function () {
        var this_var = $(this).val();
        $('.widget-button-parent-div').css({"inset":"unset"})

        if(this_var == "upper right"){
            $('.widget-button-parent-div').css({"top":10,"right":10})
        }else if(this_var == "upper left"){
            $('.widget-button-parent-div').css({"top":10,"left":10})
        // }else if(this_var == "upper center"){
        //     $('.widget-button-parent-div').css({"top":10,"right":152})
        }else if(this_var == "lower right"){
            $('.widget-button-parent-div').css({"bottom":10,"right":10})
        }else if(this_var == "lower left"){
            $('.widget-button-parent-div').css({"bottom":10,"left":10})
        // }else if(this_var == "lower center"){
        //     $('.widget-button-parent-div').css({"bottom":10,"right":152})
        // }else if(this_var == "middle right"){
        //     $('.widget-button-parent-div').css({"top":60,"right":10})
        // }else if(this_var == "middle left"){
        //     $('.widget-button-parent-div').css({"top":60,"left":10})
        // }else if(this_var == "middle center"){
        //     $('.widget-button-parent-div').css({"top":60,"right":152})
        }


    });


    // $(document).on('change','.header_button_bg_color',function () {
    //     var this_var = $(this);
    //     $('.widget-button-parent-div').find('button').css("background",this_var.val())
    // });


    $(document).on('click','.all',function () {
        var this_var = $(this);
        var filter_type = 'all';
        order_render_div(filter_type,this_var);
    });

    $(document).on('click','.unfulfilled',function () {
        var this_var = $(this);
        var filter_type = 'unfulfilled';
        order_render_div(filter_type,this_var);
    });

    $(document).on('click','.partial',function () {
        var this_var = $(this);
        var filter_type = 'partial';
        order_render_div(filter_type,this_var);
    });

    $(document).on('click','.paid',function () {
        var this_var = $(this);
        var filter_type = 'paid';
        order_render_div(filter_type,this_var);
    });

    $(document).on('click','.unpaid',function () {
        var this_var = $(this);
        var filter_type = 'unpaid';
        order_render_div(filter_type,this_var);
    });

    $(document).on('click','.pickup',function () {
        var this_var = $(this);
        var filter_type = 'pickup';
        order_render_div(filter_type,this_var);
    });
    $(document).on('click','.fulfilled',function () {
        var this_var = $(this);
        var filter_type = 'fulfilled';
        order_render_div(filter_type,this_var);
    });

    $(document).on('click','.delivery',function () {
        var this_var = $(this);
        var filter_type = 'delivery';
        order_render_div(filter_type,this_var);
    });

    $(document).on('click','.location',function () {
        var this_var = $(this);
        var filter_type = this_var.attr('data-filtertype');
        order_render_div(filter_type,this_var);
    });

    $(document).on('click','.pagination_btn',function () {
        var this_var = $(this);
        $('.loading').css('display', 'block');
        var url = this_var.attr('data-href');
        var filter_type = $('.card-header-tabs').find('.active').data('filtertype');
        console.log(url,filter_type);
        $.ajax({
            "type": "GET",
            "url": url,
            "data":{filter_type:filter_type},
            "success": function (res) {
                if(res.status == "success"){
                    $('.order_render_div').html(res.filter_orders_render_view)
                }
                $('.loading').css('display', 'none');
            }
        });

    });

    $(document).on('click','.next',function () {
        var this_var = $(this);
        order_paginate_render_div(this_var);
    });
    $(document).on('click','.prev',function () {
        var this_var = $(this);
        order_paginate_render_div(this_var);
    });

    $(document).on('click','.next2',function () {
        var this_var = $(this);
        var url = this_var.attr('data-href');
        var filter_type = this_var.parents('.order_render_div').find('.active').data('filtertype');
        $('.loading').css('display', 'block');
        $.ajax({
            "type": "GET",
            "url": url,
            "data":{filter_type:filter_type},
            "success": function (res) {
                if(res.status == "success"){
                    $('.table-responsive-wrapper').html(res.filter_orders_render_view)
                }
                $('.loading').css('display', 'none');
            }
        });

    });

    $(document).on('click','.prev2',function () {
        var this_var = $(this);
        var url = this_var.attr('data-href');
        var filter_type = this_var.parents('.order_render_div').find('.active').data('filtertype');
        $('.loading').css('display', 'block');
        $.ajax({
            type: "GET",
            url: url,
            data:{filter_type:filter_type},
            success: function (res) {
                if(res.status == "success"){
                    $('.table-responsive-wrapper').html(res.filter_orders_render_view)
                }
                $('.loading').css('display', 'none');
            },
            error:function (error){
                $('.loading').css('display', 'none');
            }
        });

    });

    $(document).on('keyup','.contact_button',function () {
        $('.send-btn').text($(this).val())
    })

    $(document).on('keyup','.launcher_label',function () {
        $('.launcher_label_text').text($(this).val())
    })

    $(document).on('keyup','.contact_form_title',function () {
        $('.contact_form_title_text').text($(this).val())
    })

    $(document).on('keyup','.filter-order-by-search',function () {
        var this_var = $(this);
        var search = this_var.val();
        var location_id = this_var.attr('data-filtertype');
        var url = this_var.attr("data-href")
        var filter_type = this_var.parents('.order_render_div').find('.active').data('filtertype');
        $('.loader-c').css('display', 'block');
        $.ajax({
            type: "GET",
            url: url,
            data:{search:search,location_id:location_id,filter_type:filter_type,},
            success: function (res) {
                if(res.status == "success"){

                    $('.table-responsive-wrapper').html(res.filter_orders_render_view)
                    $('.loader-c').css('display', 'none');
                }
                $('.loader-c').css('display', 'none');
            },
            error:function (error){
                $('.loader-c').css('display', 'none');
            }
        });

    });

    function order_paginate_render_div(this_var) {
        $('.loading').css('display', 'block');
        var url = this_var.attr('data-href');
        var filter_type = this_var.parents('.order_render_div').find('.active').data('filtertype');

        $.ajax({
            type: "GET",
            url: url,
            data:{filter_type:filter_type},
            success: function (res) {
                if(res.status == "success"){
                    $('.order_render_div').html(res.filter_orders_render_view)
                }
                $('.loading').css('display', 'none');
            },
            error:function (error){
                $('.loading').css('display', 'none');
            }
        });

    }

    function order_render_div(filter_type,this_var) {
        $('.loading').css('display', 'block');
        var url = this_var.attr('data-shopid');
        var location_id = this_var.attr('data-filtertype');

        $.ajax({
            type: "GET",
            url: '/filter/orders/'+url,
            data:{filter_type:filter_type,location_id:location_id},
            success: function (res) {
                if(res.status == "success"){
                    $('.order_render_div').html(res.filter_orders_render_view)
                }
                $('.loading').css('display', 'none');
            },
            error:function (error){
                $('.loading').css('display', 'none');
            }
        });

    }

});
