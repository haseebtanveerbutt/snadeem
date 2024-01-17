$(document).ready(function() {

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

    $(document).on('click','.next',function () {
        var this_var = $(this);
        order_paginate_render_div(this_var);
    });

    $(document).on('click','.prev',function () {
        var this_var = $(this);
        order_paginate_render_div(this_var);
    });

    $(document).on('keyup','.filter-order-by-search',function () {
        var this_var = $(this);
        var search = this_var.val();
        var url = this_var.attr("data-href")
        $.ajax({
            "type": "GET",
            "url": url,
            "data":{search:search},
            "success": function (res) {
                if(res.status == "success"){
                    $('.table-responsive-wrapper').html(res.filter_orders_render_view)
                }

            }
        });

    });

    function order_paginate_render_div(this_var) {
        var url = this_var.attr('data-href');
        var filter_type = this_var.parents('.order_render_div').find('.active').data('filtertype');

        $.ajax({
            "type": "GET",
            "url": url,
            "data":{filter_type:filter_type},
            "success": function (res) {
                if(res.status == "success"){
                    $('.order_render_div').html(res.filter_orders_render_view)
                }

            }
        });

    }
    function order_render_div(filter_type,this_var) {

        var url = this_var.attr('data-shopid');

        $.ajax({
            "type": "GET",
            "url": '/admin/filter/admin/orders/'+url,
            "data":{filter_type:filter_type},
            "success": function (res) {
                if(res.status == "success"){
                    $('.order_render_div').html(res.filter_orders_render_view)
                }

            }
        });

    }

});
