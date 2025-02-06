@extends('index')

@section('content')

<!-- FontAwesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    /* Dashboard Styling */
    .tile {
        background: #ffffff;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .tile:hover {
        transform: translateY(-5px);
    }

    .tile-primary {
        border-left: 5px solid #667eea;
        color: #667eea;
    }

    .tile-success {
        border-left: 5px solid #42e695;
        color: #42e695;
    }

    .tile-info {
        border-left: 5px solid #ff758c;
        color: #ff758c;
    }

    .tile-warning {
        border-left: 5px solid #fbc2eb;
        color: #fbc2eb;
    }

    .tile-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .tile-footer {
        margin-top: 10px;
        font-size: 14px;
    }

    .tile-footer a {
        text-decoration: none;
        font-weight: bold;
        color: inherit;
    }

    .tile-footer a:hover {
        text-decoration: underline;
    }

    /* Page Header & Breadcrumb */
    .page-header {
        padding: 15px 0;
        border-bottom: 2px solid #ddd;
        margin-bottom: 20px;
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item a {
        text-decoration: none;
        color: #a0a9b3;
        font-weight: bold;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    /* Page Title */
    .page-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>

<!-- Content Wrapper -->
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="float-end">
                <button type="button" id="button-setting" class="btn btn-info" aria-label="Developer Setting">
                    <i class="fa-solid fa-cog"></i>
                </button>
            </div>
            <h1 class="page-title">Dashboard</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Total Orders -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="tile tile-primary">
                    <div class="tile-heading">Total Orders <span class="float-end">+5%</span></div>
                    <div class="tile-body">
                        <i class="fa-solid fa-shopping-cart fa-2x"></i>
                        <h2 class="float-end">1.7K</h2>
                    </div>
                    <div class="tile-footer">
                        <a href="#">View more...</a>
                    </div>
                </div>
            </div>

            <!-- Total Sales -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="tile tile-success">
                    <div class="tile-heading">Total Sales <span class="float-end"><i class="fa-solid fa-caret-up"></i> +64%</span></div>
                    <div class="tile-body">
                        <i class="fa-solid fa-credit-card fa-2x"></i>
                        <h2 class="float-end">$1.1M</h2>
                    </div>
                    <div class="tile-footer">
                        <a href="#">View more...</a>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="tile tile-info">
                    <div class="tile-heading">Total Customers <span class="float-end">+10%</span></div>
                    <div class="tile-body">
                        <i class="fa-solid fa-user fa-2x"></i>
                        <h2 class="float-end">16.2K</h2>
                    </div>
                    <div class="tile-footer">
                        <a href="#">View more...</a>
                    </div>
                </div>
            </div>

            <!-- Online Users -->
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="tile tile-warning">
                    <div class="tile-heading">People Online</div>
                    <div class="tile-body">
                        <i class="fa-solid fa-users fa-2x"></i>
                        <h2 class="float-end">230</h2>
                    </div>
                    <div class="tile-footer">
                        <a href="#">View more...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
