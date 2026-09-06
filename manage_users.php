<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
            max-width: 1200px;
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
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s;
            margin-right: 5px;
            border: none;
            cursor: pointer;
        }
        .btn:hover { background: #764ba2; }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #218838;
        }
        .action-buttons {
            margin-bottom: 20px;
        }
        .stats {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .stat-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
        }
        .stat-number {
            font-size: 2em;
            color: #667eea;
            font-weight: bold;
        }
        .stat-label {
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
    <script>
        function confirmDelete(id, name) {
            if (confirm('Are you sure you want to delete user "' + name + '"?')) {
                window.location.href = 'delete_user.php?id=' + id;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>👥 Manage Users</h1>
        
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
            // Get statistics
            $count_sql = "SELECT COUNT(*) as total FROM users";
            $count_result = $conn->query($count_sql);
            $total_users = 0;
            if ($count_result && $row = $count_result->fetch_assoc()) {
                $total_users = $row['total'];
            }
            
            echo '<div class="stats">';
            echo '<div class="stat-item">';
            echo '<div class="stat-number">' . $total_users . '</div>';
            echo '<div class="stat-label">Total Users</div>';
            echo '</div>';
            echo '<div class="stat-item">';
            echo '<div class="stat-number">' . date('Y-m-d') . '</div>';
            echo '<div class="stat-label">Current Date</div>';
            echo '</div>';
            echo '<div class="stat-item">';
            echo '<div class="stat-number">✓</div>';
            echo '<div class="stat-label">Database Online</div>';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="action-buttons">';
            echo '<a href="add_user.php" class="btn btn-success">➕ Add New User</a>';
            echo '<a href="index.php" class="btn">← Back to Home</a>';
            echo '<a href="db_test.php" class="btn">🔍 Database Test</a>';
            echo '</div>';
            
            // Display users
            $sql = "SELECT * FROM users ORDER BY id DESC";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                echo '<h2>All Users:</h2>';
                echo '<table>';
                echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th><th>Actions</th></tr>';
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["id"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["created_at"]) . '</td>';
                    echo '<td>';
                    echo '<a href="edit_user.php?id=' . $row["id"] . '" class="btn">✏️ Edit</a>';
                    echo '<button onclick="confirmDelete(' . $row["id"] . ', \'' . htmlspecialchars($row["name"], ENT_QUOTES) . '\')" class="btn btn-danger">🗑️ Delete</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<div class="error">';
                echo '<p>⚠️ No users found in the database.</p>';
                echo '</div>';
            }
            
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
