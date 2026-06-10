<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>403 - {{ $exception->getMessage() ?: 'Akses Ditolak' }} | Kantin Kita</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #FBF5E8;
            color: #3B2A1A;
            padding: 20px;
            text-align: center;
        }
        .card {
            background: #fff;
            border-radius: 24px;
            padding: 48px 40px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .code {
            font-size: 80px;
            font-weight: 800;
            color: #A0522D;
            line-height: 1;
        }
        .message {
            font-size: 18px;
            font-weight: 600;
            margin: 16px 0 8px;
        }
        .detail {
            font-size: 14px;
            color: #7A6B5A;
            margin-bottom: 32px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 32px;
            border: none;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-logout {
            background: #A0522D;
            color: #fff;
        }
        .btn-logout:hover { background: #8B4513; }
        .btn-home {
            background: #E8D9C8;
            color: #3B2A1A;
        }
        .btn-home:hover { background: #DCC9B4; }
        .actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    </style>
</head>
<body>
    <div class="card">
        <div class="code">403</div>
        <div class="message">{{ $exception->getMessage() ?: 'Akses Ditolak' }}</div>
        <p class="detail">Kamu tidak memiliki akses ke halaman ini.</p>
        <div class="actions">
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
            <a href="/" class="btn btn-home">Ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>
