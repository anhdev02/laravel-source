@extends('layout.layout')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection

@section('header')
    <header class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/imgs/logo.png') }}" alt="Logo" height="50" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/booking') }}">Đặt vé</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/checking') }}">Tra cứu đặt vé</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="wrapper">
        <div class="container my-5">
            <div class="main border border-2 rounded">
                <div class="p-3">
                    <span class="title"></span>
                    <div style="display: none" class="loader">
                        <div class="spinner"></div>
                    </div>
                    <div class="content">

                    </div>
                </div>
                <div class="info bg-light gap-2 py-3 border-top">
                    <div class="bg-secondary py-1 px-2 rounded-pill text-white">
                        <i class="fa-solid fa-clock"></i>
                        <span class=" routeTime"></span>
                    </div>
                    <div class="bg-secondary py-1 px-2 rounded-pill text-white">
                        <i class="fa-solid fa-arrows-left-right-to-line"></i>
                        <span class=" routeLength"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            fetchroutes();

            function fetchroutes() {
                const route_id = 1;
                $('.loader').show();
                $.ajax({
                    type: "GET",
                    url: "/get-route/" + route_id,
                    success: function(response) {
                        var time = response.route.start_time.substring(0, 5) + ' - ' + response.route
                            .end_time.substring(0, 5);
                        $('.title').text(response.route.route_name);
                        $('.routeTime').text(time);
                        $('.routeLength').text(response.route.length + 'km');
                    }
                });

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
                                data: data,
                                dataType: "json",
                                success: function(response) {
                                    var chuoi = 'Tuyến';
                                    $.each(response.tooltips, function(tkey,
                                    titem) {
                                        chuoi += ' ' + '<span>' + titem
                                            .route_id + '</span>'
                                    });
                                    if (response.tooltips.length == 1) {
                                        $('#tooltips' + key).addClass('short');
                                    }
                                    $('#tooltips' + key).append(chuoi);
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
                                                    <label for="' + item.order +
                                    '" class="line"><span class="tooltips" id="tooltips' + key + '"></span></label>\
                                                </div>\
                                                 ');                         
                            }else{
                                $('.content').append(
                                    '<input type="radio" name="place" id="' + item
                                    .order + '"/>\
                                                <div class="process">\
                                                    <label for="' + item.order + '" class="placeName">' + item.station_name + '</label>\
                                                    <label for="' + item.order +
                                    '" class="line"><span class="tooltips" id="tooltips' + key + '"></span></label>\
                                                </div>\
                                                 ');   
                            }
                        });
                        $('.loader').hide();

                    }
                });
            }
        });
    </script>
@endsection
