@extends('index')

@section('title', 'Dealers List')

@section('header-title', 'All Dealers')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dealers as $dealer)
                    <tr>
                        <td>{{ $dealer->id }}</td>
                        <td>{{ $dealer->name }}</td>
                        <td>{{ $dealer->location }}</td>
                        <td>
                            <!-- You can add links to edit or delete dealers -->
                            <a href="{{ route('dealers.edit', $dealer->id) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('dealers.show', $dealer->id) }}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
