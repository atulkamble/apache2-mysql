<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
            margin-right: 10px;
        }
        .btn:hover { background: #764ba2; }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .button-group {
            margin-top: 20px;
        }
        .user-id {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            color: #6c757d;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Edit User</h1>
        
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
                
                // Check if form is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $conn->real_escape_string($_POST['name']);
                    $email = $conn->real_escape_string($_POST['email']);
                    
                    if (!empty($name) && !empty($email)) {
                        $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = $id";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo '<div class="success">';
                            echo '<h2>✅ User Updated Successfully!</h2>';
                            echo '<p><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>';
                            echo '<p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>';
                            echo '</div>';
                        } else {
                            echo '<div class="error">';
                            echo '<h2>❌ Error Updating User!</h2>';
                            echo '<p>Error: ' . $conn->error . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="error">';
                        echo '<p>⚠️ Please fill in all fields!</p>';
                        echo '</div>';
                    }
                }
                
                // Fetch user data
                $sql = "SELECT * FROM users WHERE id = $id";
                $result = $conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    ?>
                    
                    <div class="user-id">
                        <strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?> | 
                        <strong>Created:</strong> <?php echo htmlspecialchars($user['created_at']); ?>
                    </div>
                    
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Full Name:</label>
                            <input type="text" id="name" name="name" required 
                                   value="<?php echo htmlspecialchars($user['name']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                        
                        <div class="button-group">
                            <button type="submit" class="btn">💾 Update User</button>
                            <a href="manage_users.php" class="btn btn-secondary">← Back to Management</a>
                        </div>
                    </form>
                    
                    <?php
                } else {
                    echo '<div class="error">';
                    echo '<h2>⚠️ User Not Found!</h2>';
                    echo '<p>No user exists with ID: ' . $id . '</p>';
                    echo '</div>';
                    echo '<a href="manage_users.php" class="btn">← Back to Management</a>';
                }
            } else {
                echo '<div class="error">';
                echo '<h2>⚠️ Invalid Request!</h2>';
                echo '<p>No user ID provided or invalid ID format.</p>';
                echo '</div>';
                echo '<a href="manage_users.php" class="btn">← Back to Management</a>';
            }
            
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
