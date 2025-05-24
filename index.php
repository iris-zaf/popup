<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>📦 Popup Modal Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #ffffff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero {
            padding: 100px 20px;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #212529;
        }

        .hero p {
            font-size: 1.25rem;
            color: #555;
            max-width: 600px;
            margin: 0 auto 30px;
        }

        .hero .btn {
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
        }

        footer {
            text-align: center;
            margin-top: 60px;
            padding: 20px;
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>

<body>

    <div class="container hero">
        <h1>🎯 PHP Popup Modal System</h1>
        <p>This project showcases a customizable modal popup system with admin settings, delay/intent triggers, and targeted page control.</p>
        <a href="./admin/index.php" class="btn btn-primary shadow-lg" target="_blank">🛠 Enter Admin Panel</a>
        <a href="/documentation/index.html" class="btn btn-secondary shadow-lg" target="_blank">Documentation</a>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Iris Kalogirou · Junior Full Stack Developer
    </footer>

</body>

</html>