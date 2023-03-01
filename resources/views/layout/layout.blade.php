<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/headerFooter.css') }}">
    @yield('css')
</head>
<body>
    @yield('header')

    @yield('content')

    @include('layout.footer')
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-3.6.3.min.js') }}" ></script>
    @yield('script')
    <script>
        $(document).ready(function () {

            // fetch routes
            $.ajax({
                type: "GET",
                url: "/fetch-routes",
                dataType: "json",
                success: function(response) {
                    $('.tbody_routes').html('');
                    $.each(response.routes, function(key, item) {
                        var time = item.start_time.substring(0, 5) + ' - ' + item.end_time.substring(0, 5); 
                        $('.tbody_routes').append('<tr>\
                                          <td data-id=' + item.id + ' class="routeName" style="cursor: pointer">' + item.route_name + '</td>\
                                          <td>' + time + '</td>\
                                          <td>' + item.length + ' km</td>\
                                          <td>' + item.min_price.toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }) + '</td>\
                                          <td>' + item.station_price.toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        }) + '</td>\
                                        </tr>');
                    });
                }
            });

            $(document).on('click', '.routeName', function(e) {
                e.preventDefault();
                $('.loader').show();
                $('.title').text($(this).html());
                var route_id = $(this).data('id')
                $.ajax({
                    type: "GET",
                    url: "/get-route/" + route_id,
                    success: function(response) {
                        var time = response.route.start_time.substring(0, 5) + ' - ' + response.route.end_time.substring(0, 5); 
                        $('.routeTime').text(time);
                        $('.routeLenght').text(response.route.length + 'km');
                    }
                });

                if (route_id == '5') {
                    $.ajax({
                        type: "GET",
                        url: "/get-station/" + route_id,
                        success: function(response) {
                            $('.content').html('');
                            $.each(response.station, function(key, item) {
                                var data = {
                                    'station_name': item.station_name,
                                }
                                $.ajax({
                                    type: "GET",
                                    url: "/get-tooltips",
                                    data:data,
                                    dataType: "json",
                                    success: function (response) {
                                        var chuoi = 'Tuyến';
                                        $.each(response.tooltips, function (tkey, titem) { 
                                            chuoi+=' '+'<span>'+titem.route_id+'</span>'
                                        });
                                        if(response.tooltips.length==1){
                                        $('#tooltips'+key).addClass('short');
                                        }
                                        $('#tooltips'+key).append(chuoi);
                                    },
                                    error: function(response) {
                                        console.log(response);
                                    }
                                });
                                if(key==0){
                                    $('.content').append(
                                        '<input type="radio" name="place" id="' + item
                                        .order + '" checked />\
                                        <div class="process">\
                                            <label for="' + item.order + '" class="placeName">' + item.station_name + '</label>\
                                            <label for="' + item.order + '" class="line short"><span class="tooltips" id="tooltips'+key+'"></span></label>\
                                        </div>\
                                         ');
                                }else{
                                    $('.content').append(
                                        '<input type="radio" name="place" id="' + item
                                        .order + '"/>\
                                        <div class="process">\
                                            <label for="' + item.order + '" class="placeName">' + item.station_name + '</label>\
                                            <label for="' + item.order + '" class="line short"><span class="tooltips" id="tooltips'+key+'"></span></label>\
                                        </div>\
                                         ');
                                }
                            });
                            $('.loader').hide();

                        }
                    });
                } else {
                    $.ajax({
                        type: "GET",
                        url: "/get-station/" + route_id,
                        success: function(response) {
                            $('.content').html('');
                            $.each(response.station, function(key, item) {
                                var data = {
                                    'station_name': item.station_name,
                                }
                                $.ajax({
                                    type: "GET",
                                    url: "/get-tooltips",
                                    data:data,
                                    dataType: "json",
                                    success: function (response) {
                                        var chuoi = 'Tuyến';
                                        $.each(response.tooltips, function (tkey, titem) { 
                                            chuoi+=' '+'<span>'+titem.route_id+'</span>'
                                        });
                                        if(response.tooltips.length==1){
                                        $('#tooltips'+key).addClass('short');
                                        }
                                        $('#tooltips'+key).append(chuoi);
                                    },
                                    error: function(response) {
                                        console.log(response);
                                    }
                                });
                                if(key==0){
                                    $('.content').append(
                                        '<input type="radio" name="place" id="' + item
                                        .order + '" checked />\
                                        <div class="process">\
                                            <label for="' + item.order + '" class="placeName">' + item.station_name + '</label>\
                                            <label for="' + item.order + '" class="line short"><span class="tooltips" id="tooltips'+key+'"></span></label>\
                                        </div>\
                                         ');
                                }else{
                                    $('.content').append(
                                        '<input type="radio" name="place" id="' + item
                                        .order + '"/>\
                                        <div class="process">\
                                            <label for="' + item.order + '" class="placeName">' + item.station_name + '</label>\
                                            <label for="' + item.order + '" class="line short"><span class="tooltips" id="tooltips'+key+'"></span></label>\
                                        </div>\
                                         ');
                                }
                            });
                            $('.loader').hide();

                        }
                    });
                }
            });
        });
    </script>
</body>
</html>