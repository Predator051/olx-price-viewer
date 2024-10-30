<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Subscription Form</title>
    <style>
        /* Basic reset for clean styling */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f3f4f6;
        }

        .form-container {
            background-color: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-bottom: 1em;
            color: #333;
            text-align: center;
        }

        label {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 0.5em;
            display: block;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 0.8em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .is-invalid {
            border-color: #e3342f;
        }

        .error-message {
            font-size: 0.8em;
            color: #e3342f;
            margin-top: -0.8em;
            margin-bottom: 1em;
        }

        button {
            width: 100%;
            padding: 0.8em;
            font-size: 1em;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .success-message {
            font-size: 0.9em;
            color: #28a745;
            background-color: #e6f4ea;
            padding: 0.8em;
            border-radius: 4px;
            margin-bottom: 1em;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Subscribe</h2>

    <!-- Success message -->
    @if(session('status'))
        <div class="success-message">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="/subscribe">
        @csrf
        <label for="email">Enter email:</label>
        <input
            id="email"
            name="email"
            type="email"
            class="@error('email') is-invalid @enderror"
            placeholder="example@example.com"
            required
        />
        @error('email')
        <div class="error-message">Invalid email address.</div>
        @enderror

        <label for="link">Enter link:</label>
        <input
            id="link"
            name="link"
            type="text"
            class="@error('link') is-invalid @enderror"
            placeholder="https://www.olx.ua/d/uk/obyavlenie"
            required
        />
        @error('link')
        <div class="error-message">Invalid link format.</div>
        @enderror

        <button type="submit">Subscribe</button>
    </form>
</div>

</body>
</html>
