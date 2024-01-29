<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>You have requested to reset your password</h1>
    <hr>
    <p>
        We cannot simply send you your old password. A unique link to reset your password has been generated for you. To reset your password, click the following link and follow the instructions.
    </p>

    <h1><a href="http://127.0.0.1:3000/api/user/reset/<?php echo e($token); ?>">Click Here to Reset Your Password</a></h1>
</body>
</html><?php /**PATH C:\Users\seoha\OneDrive\Desktop\coffeebackend\lets_coffee_backend\resources\views/reset.blade.php ENDPATH**/ ?>