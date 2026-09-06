<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azure VM - Apache2 & MySQL</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.5em;
        }
        .status {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .status-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .status-item:last-child { border-bottom: none; }
        .label { font-weight: bold; color: #495057; }
        .value { color: #28a745; }
        .links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 30px;
        }
        .link-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            transition: transform 0.3s;
        }
        .link-card:hover { transform: translateY(-5px); }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Welcome to Azure VM</h1>
        <div class="status">
            <div class="status-item">
                <span class="label">Server:</span>
                <span class="value">✓ Apache2 Running</span>
            </div>
            <div class="status-item">
                <span class="label">Language:</span>
                <span class="value">✓ PHP <?php echo PHP_VERSION; ?></span>
            </div>
            <div class="status-item">
                <span class="label">Hostname:</span>
                <span class="value"><?php echo gethostname(); ?></span>
            </div>
            <div class="status-item">
                <span class="label">Server IP:</span>
                <span class="value"><?php echo $_SERVER['SERVER_ADDR']; ?></span>
            </div>
            <div class="status-item">
                <span class="label">Current Time:</span>
                <span class="value"><?php echo date('Y-m-d H:i:s'); ?></span>
            </div>
        </div>
        
        <div class="links">
            <a href="info.php" class="link-card">
                <h3>📋 PHP Info</h3>
                <p>View PHP configuration</p>
            </a>
            <a href="db_test.php" class="link-card">
                <h3>🗄️ Database Test</h3>
                <p>Test MySQL connection</p>
            </a>
            <a href="manage_users.php" class="link-card">
                <h3>👥 Manage Users</h3>
                <p>View, edit & delete users</p>
            </a>
            <a href="add_user.php" class="link-card">
                <h3>➕ Add User</h3>
                <p>Add new user to database</p>
            </a>
        </div>
        
        <div class="footer">
            <p>Powered by Azure VM | Apache2 | MySQL | PHP</p>
        </div>
    </div>
</body>
</html>
