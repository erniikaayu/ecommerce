<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e6f2ff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .verification-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .verification-header {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .verification-body {
            color: #34495e;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .alert {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .resend-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .resend-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="verification-header">Verify Your Email Address</div>

        <div class="verification-body">
            @if (session('resent'))
                <div class="alert">
                    A fresh verification link has been sent to your email address.
                </div>
            @endif

            <p>Before proceeding, please check your email for a verification link.</p>
            <p>If you did not receive the email, click the button below to request another.</p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="resend-button">Resend Verification Link</button>
            </form>
        </div>
    </div>
</body>
</html>