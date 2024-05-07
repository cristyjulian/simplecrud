
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .bg-image {
            background-image: url('../OUTPUT/css/bg.jpeg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            height: 100%;
        }

        .centered-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            background-color: blue; 
            color: white;
            font-size: 16px;
            padding: 12px 24px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="bg-image">
        <button class="centered-btn" onclick="location.href='#';">Get Started</button>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

