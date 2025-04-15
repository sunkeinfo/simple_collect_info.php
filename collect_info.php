<!DOCTYPE html>
<html>
<head>
    <title>收集用户信息</title>
    <style>
        #message-container {
            margin-top: 10px;
            font-weight: bold;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>请填写您的信息</h1>
    <form id="info-form" method="post" action="process_info.php">
        <div>
            <label for="username">用户名:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <br>
        <div>
            <label for="phone">电话号码:</label>
            <input type="tel" id="phone" name="phone"  required>
        </div>
        <br>
        <div>
            <label for="address">地址:</label>
            <textarea id="address" name="address" rows="5" cols="50" required></textarea>
        </div>
        <br>
        <button type="submit">提交信息</button>
    </form>

    <div id="message-container">
        <?php
        if (isset($_GET['status']) && isset($_GET['message'])) {
            $status = $_GET['status'];
            $message = urldecode($_GET['message']);
            echo '<p class="' . htmlspecialchars($status) . '">' . htmlspecialchars($message) . '</p>';
        }
        ?>
    </div>
</body>
</html>