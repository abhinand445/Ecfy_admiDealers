@extends('index')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">Dealer List</h2>
        <a href="{{ route('dealers.create') }}" class="btn btn-primary mb-3">Add Dealer</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dealers as $dealer)
                    <tr id="dealer-{{ $dealer->id }}">
                        <td>{{ $dealer->id }}</td>
                        <td>{{ $dealer->name }}</td>
                        <td>{{ $dealer->location }}</td>
                        <td>
                            <a href="{{ route('dealers.edit', $dealer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('dealers.destroy', $dealer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this dealer?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="container mt-4">
        <h2>Dealer Locations</h2>
        <div id="map" style="height: 400px;"></div>
    </div>
    
    <script>
        function initMap() {
            var defaultLocation = { lat: 10.0159, lng: 76.3419 };
            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: defaultLocation
            });
            new google.maps.Marker({
                position: defaultLocation,
                map: map
            });
        }
    </script>

@endsection
