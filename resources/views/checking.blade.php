@extends('layout.layout')

@section('title')
    <title>Trang tra cứu đặt vé</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/checking.css') }}" />
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
                        <a class="nav-link" aria-current="page" href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/booking') }}">Đặt vé</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/checking') }}">Tra cứu đặt vé</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container my-5">
        <div class="form-inline mb-3 search-box">
            <form id="searchForm">
                <input type="text" id="phone" name="phone" class="form-control form-control-sm mr-2"
                    placeholder="Số điện thoại" /><br>
                <button style="outline: none" class="btn btn-sm" type="submit">
                    <i class="fa-solid fa-search" style="font-size: 25px"></i>
                </button>
            </form>
        </div>

        <div class="table-responsive text-center">
            <span class="displayNone" id="messageChecking">Không tìm thấy thông tin đặt vé !</span>
            <table id="checkingTable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Thời gian đặt</th>
                        <th>Tuyến</th>
                        <th>Ga lên</th>
                        <th>Ga xuống</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="tbody_bookings">

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchbooking();

            function fetchbooking() {
                $.ajax({
                    type: "GET",
                    url: "/fetch-booking",
                    dataType: "json",
                    success: function(response) {
                        $('.tbody_bookings').html('');
                        var dateTimeString;
                        var formattedString;
                        $.each(response.bookings, function(key, item) {
                            $('.tbody_bookings').append('<tr>\
                                                    <td>' + item.id + '</td>\
                                                    <td>' + item.time + '</td>\
                                                    <td>' + item.route_name + '</td>\
                                                    <td>' + item.start_station + '</td>\
                                                    <td>' + item.end_station + '</td>\
                                                    <td>' + item.quantity + '</td>\
                                                    <td>' + item.total.toLocaleString('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }) + '</td>\
                                                </tr>');
                        });
                    }
                });
            }
            $.validator.addMethod("phoneVN", function(value, element) {
                return /^(0\d{9}|(\+|)84\d{9})$/.test(value);
            });

            $('#searchForm').validate({
                rules: {
                    phone: {
                        required: true,
                        phoneVN: true
                    }
                },
                messages: {
                    phone: {
                        required: "Bạn phải nhập số điện thoại !",
                        phoneVN: "Số điện thoại không hợp lệ !"
                    }
                },
                submitHandler: function(form) {
                    event.preventDefault();
                    var sdt = $('#phone').val();
                    $.ajax({
                        type: "GET",
                        url: "/get-bookings/" + sdt,
                        success: function(response) {
                            if(response.bookings.length==0){
                                $('#checkingTable').addClass('displayNone');
                                $('#messageChecking').removeClass('displayNone');
                            }else{
                                $('#messageChecking').addClass('displayNone');
                                $('#checkingTable').removeClass('displayNone');
                                $('.tbody_bookings').html('');
                                $.each(response.bookings, function(key, item) {
                                    $('.tbody_bookings').append('<tr>\
                                                        <td>' + item.id + '</td>\
                                                        <td>' + item.time + '</td>\
                                                        <td>' + item.route_name + '</td>\
                                                        <td>' + item.start_station + '</td>\
                                                        <td>' + item.end_station + '</td>\
                                                        <td>' + item.quantity + '</td>\
                                                        <td>' + item.total.toLocaleString('vi-VN', {
                                        style: 'currency',
                                        currency: 'VND'
                                    }) + '</td>\
                                                    </tr>');
                                });
                            }
                        }
                    });
                }
            })
        });
    </script>
@endsection