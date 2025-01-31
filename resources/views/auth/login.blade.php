<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <style>
        /* Same styles as the Register Blade */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0faff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 400px;
            padding: 20px;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
            color: #333;
        }
        .container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        .container form input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .container form input[type="submit"] {
            background-color: #4070f4;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        .container form input[type="submit"]:hover {
            background-color: #305dc9;
        }
        .container p {
            text-align: center;
        }
        .container p a {
            color: #4070f4;
            text-decoration: none;
        }
        .container p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
            @error('email')
                <div>{{ $message }}</div>
            @enderror
            <input type="password" name="password" placeholder="Password" required>
            @error('password')
                <div>{{ $message }}</div>
            @enderror
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
    </div>

    <script>
        @if (session('status'))
            alert("{{ session('status') }}");
        @endif
    </script>
</body>
</html>
