<!DOCTYPE html>
<html>
<head>
    <title>收集到的用户信息</title>
    <style>
        .separator {
            border: none;
            border-top: 2px solid red;
            margin: 15px 0;
        }
        .entry {
            margin-bottom: 15px;
            border: 1px solid #ccc; /* 可选：添加边框以更清晰区分条目 */
            padding: 10px;
            display: flex; /* 使用 flexbox 布局 */
            align-items: center; /* 垂直居中对齐 */
            justify-content: space-between; /* 内容和按钮之间留出空间 */
        }
        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            margin-left: 10px; /* 按钮与内容之间留出一些间距 */
        }
    </style>
</head>
<body>
    <h1>收集到的用户信息</h1>
    <?php
    $filename = 'user_data.txt';
    $separator = "---NEXT_ENTRY---\n";

    // 处理删除请求
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
        $indexToDelete = intval($_POST['delete_index']); // 获取要删除的条目索引
        $content = file_get_contents($filename);
        $entries = explode($separator, $content);
        $newContent = '';
        $deletedCount = 0;

        foreach ($entries as $index => $entry) {
            if ($index !== $indexToDelete) {
                $newContent .= trim($entry) . $separator;
            } else {
                $deletedCount++;
            }
        }

        // 移除末尾可能多余的分隔符
        $newContent = rtrim($newContent, $separator);

        if (file_put_contents($filename, $newContent, LOCK_EX) !== false) {
            if ($deletedCount > 0) {
                echo '<p style="color: green;">信息已删除。</p>';
            }
        } else {
            echo '<p style="color: red;">删除信息失败，请检查文件权限。</p>';
        }
    }

    // 显示所有信息
    if (file_exists($filename)) {
        $content = file_get_contents($filename);
        $entries = explode($separator, $content);

        if (!empty($entries)) {
            foreach ($entries as $index => $entry) {
                $trimmed_entry = trim($entry);
                if (!empty($trimmed_entry)) {
                    echo "<div class='entry'>";
                    echo "<div>"; // 用于包裹显示的信息
                    $lines = explode("\n", $trimmed_entry);
                    foreach ($lines as $line) {
                        echo "<p>" . htmlspecialchars(trim($line)) . "</p>";
                    }
                    echo "</div>";
                    // 添加删除按钮，使用表单提交要删除的索引
                    echo '<form method="post" style="display: inline;">';
                    echo '<input type="hidden" name="delete_index" value="' . $index . '">';
                    echo '<button type="submit" class="delete-button" onclick="return confirm(\'确定要删除这条信息吗？\')">删除</button>';
                    echo '</form>';
                    echo "</div>";
                    echo "<hr class='separator'>";
                }
            }
        } else {
            echo "<p>目前还没有收集到任何提交内容。</p>";
        }
    } else {
        echo "<p>数据文件不存在。</p>";
    }
    ?>
</body>
</html>