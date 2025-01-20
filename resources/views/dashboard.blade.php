<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f0faff;
        }
        /* Navbar styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #4070f4;
            padding: 15px 30px;
            color: white;
        }
        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .navbar .links a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 0 10px;
            font-size: 16px;
        }
        .navbar .links a:hover {
            background-color: #305dc9;
            border-radius: 5px;
        }
        /* Main content styles */
        .container {
            padding: 30px;
            max-width: 1000px;
            margin: 20px auto;
        }
        .container h2 {
            color: #333;
            text-align: center;
        }
        .container .user-info {
            text-align: center;
            margin: 20px 0;
        }
        .container .user-info h3 {
            margin: 10px 0;
            color: #4070f4;
        }
        .container .user-info p {
            margin: 5px 0;
            color: #666;
        }
        .logout-btn {
            display: block;
            background-color: #e74c3c;
            color: white;
            padding: 12px;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">MyApp</div>
        <div class="links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('profile') }}">Profile</a>
            <a href="{{ route('change-password') }}">Change Password</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h2>Welcome to Your Dashboard</h2>
        <div class="user-info">
            {{-- <h3>Hello, {{ Auth::user()->name }}!</h3>
            <p>Email: {{ Auth::user()->email }}</p> --}}
        </div>
    </div>

</body>
</html>
