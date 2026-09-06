<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySQL Database Test</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 1000px;
            margin: 20px auto;
        }
        h1 { color: #333; margin-bottom: 20px; text-align: center; }
        h2 { color: #667eea; margin: 20px 0; }
        .success { color: #28a745; padding: 15px; background: #d4edda; border-radius: 5px; margin: 20px 0; }
        .error { color: #dc3545; padding: 15px; background: #f8d7da; border-radius: 5px; margin: 20px 0; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: bold;
        }
        tr:hover { background-color: #f5f5f5; }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .back-link:hover { background: #764ba2; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗄️ MySQL Database Connection Test</h1>
        
        <?php
        $servername = "localhost";
        $username = "webuser";
        $password = "webpass123";
        $database = "webdb";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);
        
        // Check connection
        if ($conn->connect_error) {
            echo '<div class="error">';
            echo '<h2>❌ Connection Failed!</h2>';
            echo '<p>Error: ' . $conn->connect_error . '</p>';
            echo '</div>';
        } else {
            echo '<div class="success">';
            echo '<h2>✅ MySQL Connection Successful!</h2>';
            echo '<p><strong>Connected to database:</strong> ' . $database . '</p>';
            echo '<p><strong>Server version:</strong> ' . $conn->server_info . '</p>';
            echo '</div>';
            
            // Display data from test table
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                echo '<h2>Users in Database:</h2>';
                echo '<table>';
                echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr>';
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["created_at"]) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>No users found in the database.</p>';
            }
            
            $conn->close();
        }
        ?>
        
        <a href="index.php" class="back-link">← Back to Home</a>
    </div>
</body>
</html>
