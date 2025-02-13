    @extends('index')

    @section('content')
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="preload" href="{{ asset('assets/fonts/fontawesome/fa-solid-900.woff2') }}" as="font"
                type="font/woff2" crossorigin="anonymous">
            <link rel="preload" href="{{ asset('assets/fonts/fontawesome/fa-regular-400.woff2') }}" as="font"
                type="font/woff2" crossorigin="anonymous">
            <link rel="preload" href="{{ asset('assets/fonts/fontawesome/fa-brands-400.woff2') }}" as="font"
                type="font/woff2" crossorigin="anonymous">


            </script>

            <title>Document</title>
            <style>
                /* General Page Styling */
               
                .container-fluid {
                    padding: 20px;
                }

                /* Page Header */
                .page-header {
                    background-color: #ffffff;
                    padding: 20px;
                    margin-bottom: 20px;
                    border-radius: 5px;
                    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
                }

                .page-header-title {
                    display: flex;
                    align-items: center;
                    font-size: 24px;
                    font-weight: bold;
                    color: #333333;
                }

                .page-header-icon img {
                    margin-right: 10px;
                }

                /* Card Styles */
                .card {
                    background-color: #ffffff;
                    border: 1px solid #dddddd;
                    border-radius: 5px;
                    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
                    margin-bottom: 20px;
                    box-sizing: border-box;
                }

                .card-header {
                    background-color: #f7f7f7;
                    border-bottom: 1px solid #dddddd;
                    padding: 15px;
                    font-size: 18px;
                    font-weight: bold;
                    color: #555555;
                    display: flex;
                    align-items: center;
                }

                .card-body {
                    padding: 15px;
                }

                /* Navigation Tabs */
                .nav-tabs {
                    border-bottom: 2px solid #e6e6e6;
                }

                .nav-tabs .nav-link {
                    color: #555555;
                    font-weight: bold;
                    border: none;
                    padding: 10px 15px;
                }

                .nav-tabs .nav-link.active {
                    background-color: #007bff;
                    color: #ffffff;
                    border-radius: 5px;
                }

                /* Form Styles */
                .form-group {
                    margin-bottom: 20px;
                }

                .input-label {
                    display: block;
                    font-weight: bold;
                    margin-bottom: 5px;
                    color: #333333;
                }

                .form-control {
                    border: 1px solid #cccccc;
                    border-radius: 5px;
                    padding: 10px;
                    width: 100%;
                    box-sizing: border-box;
                }

                textarea.form-control {
                    min-height: 100px;
                }

                /* File Upload Section */
                .custom-upload-img {
                    text-align: center;
                }

                .custom-upload-img img {
                    width: 171px;
                    height: 110px;
                    border-radius: 10%;
                    border: 2px dashed #cccccc;
                    object-fit: cover;
                    margin-bottom: 10px;
                    margin-right: 50%;
                    margin-left: 20px;
                }


                .icon-file-group {
                    display: flex;
                    justify-content: center;
                    margin-top: 10px;
                }

                .icon-file {
                    position: relative;
                    cursor: pointer;
                }

                .icon-file i {
                    font-size: 24px;
                    color: #007bff;
                }

                .icon-file input {
                    position: absolute;
                    top: 0;
                    left: 0;
                    opacity: 0;
                    width: 100%;
                    height: 100%;
                }

                /* Floating Date Selector */
                .floating--date {
                    display: none;
                    position: absolute;
                    top: 50px;
                    left: 0;
                    z-index: 1000;
                    background-color: #ffffff;
                    border: 1px solid #cccccc;
                    border-radius: 5px;
                    padding: 10px;
                    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                }

                .floating-date-toggler:hover+.floating--date {
                    display: block;
                }

                /* Buttons */
                .btn {
                    padding: 10px 20px;
                    font-size: 14px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;

                }

                .btn--primary {
                    background-color: #007bff;
                    color: #ffffff;
                }

                .btn--primary:hover {
                    background-color: #0056b3;
                }

                /* Responsive Adjustments */
                @media (max-width: 768px) {
                    .page-header-title {
                        font-size: 20px;
                    }

                    .form-group {
                        margin-bottom: 15px;
                    }

                    .custom-upload-img img {
                        width: 106px;
                        height: 80px;
                    }
                }

                /* Responsive Buttons */

                .btn-responsive {
                    padding: 10px 20px;
                    font-size: 16px;
                    width: auto;


                }

                @media (max-width: 768px) {
                    .btn-responsive {
                        width: 100%;
                        margin-bottom: 10px;

                    }
                }

                /* #map {
                        height: 400px;
                        width: 100%;
                    } */
            </style>
        </head>

        <body>

            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-header-title">
                        <span class="page-header-icon">
                            <img src="https://app.ecfy.in/public/assets/admin/img/store.png" class="w--26" alt="">
                        </span>
                        <span>
                            Add New Dealer
                        </span>
                    </h1>
                </div>
                <!-- End Page Header -->

                <form action="{{ route('dealers.store') }}" method="post" enctype="multipart/form-data" class="js-validate"
                    id="dealer_form" novalidate>
                    @csrf

                    <div class="row g-2">
                        <!-- Store Information -->
                        <div class="col-lg-6">
                            <div class="card shadow--card-2">
                                <div class="card-body">
                                    <h4>Store Information</h4>
                                    <div class="form-group">
                                        <label class="input-label" for="store_name">Store Name</label>
                                        <input type="text" name="store_name" id="store_name" class="form-control"
                                            required>

                                        @error('store_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label class="input-label" for="address_default">Address</label>
                                        <textarea name="address" id="address_default" class="form-control min-h-90px" placeholder="Dealer address" required></textarea>
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dealer Logo -->
                        <div class="col-lg-6">
                            <div class="card shadow--card-2">
                                <div class="card-header">
                                    <h5 class="card-title">Dealer Logo</h5>
                                </div>
                                <div class="card-body">
                                    <div class="custom-upload-img text-center">
                                        <label for="customFileEg1">Logo</label>
                                        <label for="customFileEg1" style="margin-right: 45%">
                                            <img id="viewer"
                                                class="img--110 min-height-170px min-width-170px image--border cursor-pointer"
                                                src="https://app.ecfy.in/public/assets/admin/img/upload-img.png"
                                                alt="Logo image">
                                        </label>
                                        <div class="icon-file-group mt-2">
                                            <div class="icon-file">
                                                <i class="tio-edit"></i>
                                                <input type="file" name="logo" id="customFileEg1"
                                                    class="custom-file-input d-none" accept="image/*" required>
                                            </div>
                                        </div>
                                        @error('logo')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dealer Information -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Dealer Information</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Modules -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-label">Modules</label>
                                                <select name="module_id" id="module_id" class="form-control" required>
                                                    <option value="" selected>Select Module</option>
                                                    @foreach ($modules as $module)
                                                        <option value="{{ $module->id }}">{{ $module->module_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('module_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Zone -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="input-label">Zone</label>
                                                <select name="zone_id" id="zone_id" class="form-control" required>
                                                    <option value="" selected>Select Zone</option>
                                                    @foreach ($zones as $zone)
                                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('zone_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- Latitude and Longitude -->
                                        <h5 class="col-12 mt-3">Map and Store Coordinates</h5>
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="latitude">Latitude Store</label>
                                                <input type="text" id="latitude" name="latitude" value=""
                                                    readonly class="form-control" placeholder="Enter Latitude" required>
                                                @error('latitude')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6">
                                            {{-- <div class="form-group">
                                                <label for="longitude">Longitude Store</label>
                                                <input type="text" id="longitude" name="longitude" value=""
                                                    readonly class="form-control" placeholder="Enter Longitude" required>
                                                @error('longitude')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div> --}}
                                        </div>
                                        <!-- Map Placeholder -->
                                        <div class="col-12">
                                            <div id="map"
                                                style="width: 100%; height: 300px; background-color: #f3f3f3; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center;">
                                                <p class="text-center text-muted">Map Placeholder</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Account Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="f_name">First Name</label>
                                            <input type="text" name="f_name" id="f_name" class="form-control"
                                                placeholder="First Name" required>
                                            @error('f_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="l_name">Last Name</label>
                                            <input type="text" name="l_name" id="l_name" class="form-control"
                                                placeholder="Last Name" required>
                                            @error('l_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input type="tel" name="phone" id="phone" class="form-control"
                                                placeholder="Phone Number" required>
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="Email Address" required>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Password -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            {{-- <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Password" required> --}}

                                            {{-- <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Password" required autocomplete="new-password"> --}}
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autocomplete="new-password">


                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Confirm Password -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password</label>
                                            {{-- <input type="password" name="confirm_password" id="confirm_password"
                                                class="form-control" placeholder="Confirm Password" required
                                                autocomplete="new-password"> --}}

                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required autocomplete="new-password">

                                            @error('confirm_password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('dealers.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
            </div>
            </form>
            </div>


           <script>
                function initMap() {
                    var defaultLocation = {
                        lat: 10.0159,
                        lng: 76.3419
                    }; // Default Location

                    var map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 12,
                        center: defaultLocation,
                    });

                    var marker = new google.maps.Marker({
                        position: defaultLocation,
                        map: map,
                        draggable: true
                    });

                    // Update latitude and longitude fields on marker drag
                    marker.addListener("dragend", function(event) {
                        document.getElementById("latitude").value = event.latLng.lat();
                        document.getElementById("longitude").value = event.latLng.lng();
                    });

                    // Update fields when clicking on map
                    map.addListener("click", function(event) {
                        marker.setPosition(event.latLng);
                        document.getElementById("latitude").value = event.latLng.lat();
                        document.getElementById("longitude").value = event.latLng.lng();
                    });
                }
            </script>

            <!-- Load Google Maps API with async & defer and call initMap() after it loads -->
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClsxlefHaPWrg0sxXMRaERr9JZozv_gwM"></script>
            
             {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_VALID_API_KEY&callback=initMap" async defer></script> --}}




        </body>

        </html>
    @endsection

    