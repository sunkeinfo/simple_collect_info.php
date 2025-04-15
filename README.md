以下分别介绍一下这三个 PHP 文件的功能：

1. collect_info.php

功能： 这个文件主要用于公开收集用户信息。它向用户展示一个 HTML 表单，包含以下字段：
用户名 (username): 供用户输入他们的名字。这是一个必填字段。
电话号码 (phone): 供用户输入他们的电话号码，并提供了一个格式提示 (123-456-7890) 和简单的格式验证。这也是一个必填字段。
地址 (address): 供用户输入他们的地址，提供了一个多行文本输入框，并设置为必填。
用户交互： 用户通过在浏览器中访问这个页面，看到包含上述字段的表单。他们可以在这些字段中输入自己的信息。
数据提交： 当用户填写完表单并点击“提交信息”按钮后，表单数据将通过 HTTP POST 方法发送到 process_info.php 文件进行处理。
显示结果（不使用 JavaScript 版本）： 在不使用 JavaScript 的版本中，这个页面还会检查 URL 中是否包含 status 和 message 参数。如果存在，它会显示来自 process_info.php 的提交结果消息（成功或失败）。

2. process_info.php

功能： 这个文件主要用于接收并处理从 collect_info.php 页面提交的用户信息，并将这些信息保存起来。
数据接收： 当 collect_info.php 的表单被提交时，这个文件会接收通过 $_POST 超全局数组传递过来的用户名、电话号码和地址。
数据格式化： 它将接收到的用户信息格式化成一个易于阅读的字符串，每条信息占一行，并在最后添加一个预定义的分隔符 (---NEXT_ENTRY---\n)，用于在后续读取时区分不同的提交。
数据存储： 它使用 file_put_contents() 函数将格式化后的数据追加到名为 user_data.txt 的文本文件中。FILE_APPEND 标志确保每次提交的信息都添加到文件末尾，而不会覆盖之前的内容。LOCK_EX 用于获取独占锁，防止并发写入导致数据损坏。
结果反馈：
不使用 JavaScript 版本： 在成功将数据写入文件后，它会使用 header('Location: ...') 将用户重定向回 collect_info.php 页面，并在 URL 中附带 status（success 或 error) 和 message 参数，告知用户提交是否成功。
使用 JavaScript 版本： 它会将包含状态 (status) 和消息 (message) 的数组编码为 JSON 字符串并输出，供 JavaScript 在 collect_info.php 中处理。

3. show_results.php

功能： 这个文件用于显示所有已经收集到的用户信息。它从 user_data.txt 文件中读取数据，并将其展示在网页上。
数据读取： 它使用 file_get_contents() 函数读取 user_data.txt 文件的全部内容。
数据分割： 它使用在 process_info.php 中定义的相同分隔符 (---NEXT_ENTRY---\n)，通过 explode() 函数将读取到的文件内容分割成一个包含每次提交的完整信息的数组。
数据显示： 它遍历这个数组，将每个提交的信息以段落 (<p>) 的形式显示在网页上。为了防止潜在的跨站脚本攻击 (XSS)，它会对读取到的每一行信息使用 htmlspecialchars() 进行 HTML 实体编码。
分隔显示： 它在每个完整的提交内容之间插入一条红色的水平线 (<hr class='separator'>)，以区分不同的提交记录。
删除功能： 它还包含一个删除按钮，允许用户删除特定的已保存信息条目。删除功能通过 HTML 表单提交（不使用 JavaScript 版本）或 JavaScript 的 AJAX 请求（如果之前有 JavaScript 版本）将要删除的条目的索引或内容发送回 show_results.php 进行处理，然后更新 user_data.txt 文件。
无数据提示： 如果 user_data.txt 文件不存在或内容为空，它会显示相应的提示信息。
总而言之，这三个文件构成了一个简单的信息收集和展示流程：用户在 collect_info.php 填写信息，信息通过 process_info.php 保存到 user_data.txt 文件中，最后 show_results.php 从该文件中读取并展示所有已收集到的信息，并提供删除功能。
