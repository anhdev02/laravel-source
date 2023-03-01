@extends('layout.layout')

@section('title')
    <title>Trang đặt vé</title>
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
                        <a class="nav-link active" href="{{ url('/booking') }}">Đặt vé</a>
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
    <div class="container">
        <form id="bookingForm">
            <div class="row justify-content-center my-5 mx-3">
                <div id="successMessage"></div>
                <div class="col-md-6">
                    <div class="form-group my-2">
                        <label for="tuyen">Tuyến:</label>
                        <select class="form-control" id="route" name="route">

                        </select>
                    </div>
                    <div class="form-group my-2">
                        <label for="startStation">Ga lên:</label>
                        <select class="form-control" id="startStation" name="startStation">

                        </select>
                    </div>
                    <div class="form-group my-2">
                        <label for="quantity">Số lượng đặt:</label>
                        <input min="1" max="100" value="1" name="quantity" type="number"
                            class="form-control" id="quantity" />
                    </div>
                    <div class="form-group my-2">
                        <label for="total">Thành tiền:</label><br />
                        <span id="total" data-total="12000"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group my-2">
                        <label style="margin-top: 15px">Còn trống:</label><br />
                        <span id="availableSeats"></span>
                    </div>
                    <div class="form-group my-2">
                        <label for="endStation">Ga xuống:</label>
                        <select class="form-control" name="endStation" id="endStation">

                        </select>
                    </div>
                    <div class="form-group my-2">
                        <label for="phone">Điện thoại:</label>
                        <input type="tel" class="form-control" name="phone" id="phone" />
                    </div>
                    <br />
                    <button type="submit" class="booking btn btn-primary">Đặt vé</button>
                </div>
            </div>
        </form>
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
                url: "/fetch-routes",
                dataType: "json",
                success: function(response) {
                    $('#route').html('');
                    $('#availableSeats').text('100 ghế');
                    $.each(response.routes, function(key, item) {
                        if (item.id == 1) {
                            $('#route').append('<option data-minprice = "' + item
                                .min_price + '" data-stationprice = "' + item
                                .station_price + '" data-totalstation = "' + item
                                .total_station + '" selected value="' + item.id + '">' +
                                item.route_name + '</option>');
                            $('#total').text(item.min_price.toLocaleString(
                                'vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                }));
                        } else {
                            $('#route').append('<option data-minprice = "' + item
                                .min_price + '" data-stationprice = "' + item
                                .station_price + '" data-totalstation = "' + item
                                .total_station + '" value="' + item.id + '">' + item
                                .route_name + '</option>');
                        }
                    });
                }
            });


            $.ajax({
                type: "GET",
                url: "/get-station/" + 1,
                success: function(response) {
                    $.each(response.station, function(key, item) {
                        $('#startStation').append('<option value="' + item.order + '">' + item
                            .station_name + '</option>');
                        $('#endStation').append('<option value="' + item.order + '">' + item
                            .station_name + '</option>');
                    });
                }
            });

        }

        $('#route').change(function(e) {
            e.preventDefault();
            var route_id = $(this).val();
            var minPrice = $('#route option:selected').data('minprice');
            var quantity = $('#quantity').val();
            var total = minPrice*quantity;
            $('#total').text(total.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }));
            $('#startStation').text('');
            $('#endStation').text('');
            $('#availabelSeats').text('');
            if (route_id == '1') {
                $('#availabelSeats').text('100 ghế');
            } else if (route_id == '2') {
                $('#availabelSeats').text('50 ghế');
            } else {
                $('#availabelSeats').text('25 ghế');
            }
            $.ajax({
                type: "GET",
                url: "/get-station/" + route_id,
                success: function(response) {
                    $.each(response.station, function(key, item) {
                        $('#startStation').append('<option value="' + item.order + '">' +
                            item
                            .station_name + '</option>');
                        $('#endStation').append('<option value="' + item.order +
                            '">' + item
                            .station_name + '</option>');
                    });
                }
            });
        });

        $('#startStation, #endStation, #quantity').change(function(e) {
            e.preventDefault();
            var total = 0;
            var minPrice = $('#route option:selected').data('minprice');
            var stationPrice = $('#route option:selected').data('stationprice');
            var totalStation = $('#route option:selected').data('totalstation');
            var halfTotalStations = Math.round(totalStation / 2);
            var quantity = $('#quantity').val();
            var startStationNumber = $('#startStation option:selected').val(),
            endStationNumber = $('#endStation option:selected').val();
            if ((Math.abs(startStationNumber - endStationNumber) + 1) <= halfTotalStations) {
                total = minPrice * quantity;
            } else {
                total = (minPrice + ((Math.abs(startStationNumber - endStationNumber) + 1) - halfTotalStations) *
                stationPrice) * quantity;
            }
            $('#total').attr('data-total', total);
            $('#total').text(total.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }));
        });

        $.validator.addMethod("phoneVN", function(value, element) {
            return /^(0\d{9}|(\+|)84\d{9})$/.test(value);
        });

        $("#bookingForm").validate({
            rules: {
                startStation: "required",
                startStation: "required",
                quantity: {
                    required: true,
                    min: 1,
                    max: 100
                },
                phone: {
                    required: true,
                    phoneVN: true,
                },
            },
            messages: {
                startStation: "Bạn phải chọn ga lên !",
                startStation: "Bạn phải chọn ga xuống !",
                quantity: {
                    required: "Bạn phải nhập số lượng vé !",
                    min: "Số lượng vé phải lớn hơn hoặc bằng 1 !",
                    max: "Số lượng vé phải nhỏ hơn hoặc bằng 100 !"
                },
                phone: {
                    required: "Bạn phải nhập số điện thoại !",
                    phoneVN: "Số điện thoại không hợp lệ !"
                },
            },
            submitHandler: function(form) {
                event.preventDefault();
                var data = {
                    'route_name': $('#route option:selected').text(),
                    'start_station': $('#startStation option:selected').text(),
                    'end_station': $('#endStation option:selected').text(),
                    'quantity': $('#quantity').val(),
                    'phone': $('#phone').val(),
                    'total': parseInt($('#total').data('total')),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/bookings",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#successMessage').addClass('alert alert-success');
                        $('#successMessage').css('color', 'green');
                        $('#successMessage').text(response.message);
                    },
                    error: function (response){
                        console.log(response);
                    }
                });
            }
        }); 
    });
</script>
@endsection