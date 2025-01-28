@extends('index')

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="https://app.ecfy.in/public/assets/admin/img/store.png" class="w--26" alt="">
                </span>
                <span>All Dealers</span>
            </h1>
        </div>
        <!-- End Page Header -->

        <!-- Dealers Table -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Dealer List</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Store Name</th>
                            <th>Address</th>
                            <th>Dealer Logo</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dealers as $dealer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dealer->store->name }}</td>
                                <td>{{ $dealer->address }}</td>
                                <td><img src="{{ asset('storage/dealer_logos/' . $dealer->logo) }}" alt="Dealer Logo" style="width: 100px; height: 60px;"></td>
                                <td>{{ $dealer->phone }}</td>
                                <td>{{ $dealer->email }}</td>
                                <td>
                                    <a href="{{ route('dealers.edit', $dealer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('dealers.destroy', $dealer->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this dealer?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
