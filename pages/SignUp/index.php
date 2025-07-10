<?php
require_once __DIR__ . '/../../handlers/signUp.handler.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="/assets/css/forms.css">
</head>
<body>
    <div class="form-container">
        <h1>Sign Up</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message">
                Account created successfully! <a href="/pages/Login">Click here to login</a>
            </div>
        <?php else: ?>
            <form method="POST" action="">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="firstname" placeholder="First Name" value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="middlename" placeholder="Middle Name" value="<?php echo htmlspecialchars($_POST['middlename'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="lastname" placeholder="Last Name" value="<?php echo htmlspecialchars($_POST['lastname'] ?? ''); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="role" placeholder="Role (Rank in Company)" value="<?php echo htmlspecialchars($_POST['role'] ?? ''); ?>">
                    </div>
                </div>
                
                <button type="submit">Register</button>
            </form>
        <?php endif; ?>
        
        <div class="back-link">
            <a href="/pages/Login">Back to Login</a>
        </div>
    </div>
</body>
</html>
