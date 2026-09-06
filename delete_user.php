<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
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
            max-width: 600px;
            margin: 20px auto;
        }
        h1 { color: #333; margin-bottom: 20px; text-align: center; }
        .success { color: #28a745; padding: 15px; background: #d4edda; border-radius: 5px; margin: 20px 0; }
        .error { color: #dc3545; padding: 15px; background: #f8d7da; border-radius: 5px; margin: 20px 0; }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
            margin-top: 20px;
        }
        .btn:hover { background: #764ba2; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🗑️ Delete User</h1>
        
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
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = intval($_GET['id']);
                
                // First, get user details for confirmation
                $check_sql = "SELECT name, email FROM users WHERE id = $id";
                $check_result = $conn->query($check_sql);
                
                if ($check_result && $check_result->num_rows > 0) {
                    $user = $check_result->fetch_assoc();
                    
                    // Delete the user
                    $sql = "DELETE FROM users WHERE id = $id";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="success">';
                        echo '<h2>✅ User Deleted Successfully!</h2>';
                        echo '<p><strong>Deleted User:</strong> ' . htmlspecialchars($user['name']) . '</p>';
                        echo '<p><strong>Email:</strong> ' . htmlspecialchars($user['email']) . '</p>';
                        echo '<p><strong>User ID:</strong> ' . $id . '</p>';
                        echo '</div>';
                    } else {
                        echo '<div class="error">';
                        echo '<h2>❌ Error Deleting User!</h2>';
                        echo '<p>Error: ' . $conn->error . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="error">';
                    echo '<h2>⚠️ User Not Found!</h2>';
                    echo '<p>No user exists with ID: ' . $id . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<div class="error">';
                echo '<h2>⚠️ Invalid Request!</h2>';
                echo '<p>No user ID provided or invalid ID format.</p>';
                echo '</div>';
            }
            
            $conn->close();
        }
        ?>
        
        <a href="manage_users.php" class="btn">← Back to User Management</a>
    </div>
</body>
</html>
