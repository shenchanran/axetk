<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录与注册</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 400px;
            margin: auto;
        }

        .form-toggle {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">系统登录</a>
        </div>
    </nav>

    <!-- Login/Register Section -->
    <div class="container py-5">
        <div class="text-center mb-4">
            <h1 id="formTitle">登录</h1>
            <p>切换到 <span id="toggleText" class="text-primary form-toggle">注册</span></p>
        </div>

        <!-- Login/Register Form -->
        <div class="form-container">
            <form id="loginForm">
                <div id="loginFields">
                    <div class="mb-3">
                        <label for="username" class="form-label">邮箱地址/用户名</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="请输入邮箱或用户名">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">密码</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="请输入密码">
                    </div>
                </div>
                <div id="registerFields" class="d-none">
                    <div class="mb-3">
                        <label for="registerName" class="form-label">用户名</label>
                        <input type="text" class="form-control" id="registerName" name="registerName" placeholder="请输入用户名">
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">邮箱地址</label>
                        <input type="email" class="form-control" id="registerEmail" name="registerEmail" placeholder="请输入邮箱">
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">密码</label>
                        <input type="password" class="form-control" id="registerPassword" name="registerPassword" placeholder="请输入密码">
                    </div>
                    <div class="mb-3">
                        <label for="rePassword" class="form-label">重复密码</label>
                        <input type="password" class="form-control" id="rePassword" name="rePassword" placeholder="请重复输入密码">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="registerPassword" class="form-label">验证码</label>
                    <input type="text" id="captcha" name="captcha" class="form-control" placeholder="请输入验证码" required>
                    <img id="captcha-img" alt="验证码" class="captcha-img">
                </div>
                <button type="submit" class="btn btn-primary w-100" id="formButton">登录</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-3">
        <p>&copy; 2024 系统登录与注册页面. 版权所有.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript -->
    <script>
        const $ = (a) => {
            return document.querySelector(a)
        };

        function captcha() {
            $('#captcha').value = '';
            $('#captcha-img').setAttribute('src', 'api.php?captcha-time=' + Math.round(new Date() / 1000));
        }
        captcha();
        const formTitle = $('#formTitle');
        const formButton = $('#formButton');
        const toggleText = $('#toggleText');
        const loginFields = $('#loginFields');
        const registerFields = $('#registerFields');

        // Toggle form view between login and register
        toggleText.addEventListener('click', () => {
            if (formTitle.innerText === '登录') {
                formTitle.innerText = '注册';
                formButton.innerText = '注册';
                toggleText.innerText = '登录';
                loginFields.classList.add('d-none');
                registerFields.classList.remove('d-none');
            } else {
                formTitle.innerText = '登录';
                formButton.innerText = '登录';
                toggleText.innerText = '注册';
                registerFields.classList.add('d-none');
                loginFields.classList.remove('d-none');
            }
        });
        $('#captcha-img').addEventListener('click', captcha);
        // Handle form submission (for demonstration purposes)
        $('#loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (formTitle.innerText === '登录') {
                const username = $('#username').value;
                const password = $('#password').value;
                const captchacode = $('#captcha').value;
                if (!username) {
                    alert('请输入用户名');
                    return;
                } else if (!password) {
                    alert('请输入密码');
                    return;
                } else if (!captchacode) {
                    alert('请输入验证码');
                    return;
                }
                data = {
                    act: 'login',
                    username,
                    password,
                    captchacode,
                }
                fetch('api.php', {
                        method: 'POST', // 请求方法
                        headers: {
                            'Content-Type': 'application/json' // 设置请求头，说明请求体是 JSON 格式
                        },
                        body: JSON.stringify(data) // 将 JavaScript 对象转换为 JSON 字符串作为请求体
                    })
                    .then(response => {
                        if (!response.ok) { // 如果响应状态码不是 2xx
                            alert('登陆失败，请重试')
                            throw new Error('请求失败，状态码: ' + response.status);
                        }
                        return response.json(); // 解析响应体为 JSON
                    })
                    .then(data => {
                        if (data.code != 1) {
                            alert(data.msg);
                            captcha()
                            return;
                        }
                        window.location.href = '/user?sp=usercenter';
                    })
                    .catch(error => {
                        console.error('发生错误:', error); // 捕获并处理任何错误
                        alert('登陆失败，请重试')
                    });
            } else {
                const username = $('#registerName').value;
                const email = $('#registerEmail').value;
                const password = $('#registerPassword').value;
                const repassword = $('#rePassword').value;
                const captchacode = $('#captcha').value;
                if (!username) {
                    alert('请输入用户名');
                    return;
                }else if(!email){
                    alert('请输入邮箱');
                    return;
                } else if (!password) {
                    alert('请输入密码');
                    return;
                } else if (password!==repassword) {
                    alert('两次输入的密码不一致');
                    return;
                } else if (!captchacode) {
                    alert('请输入验证码');
                    return;
                }
                data = {
                    act: 'reg',
                    email,
                    username,
                    password,
                    captchacode,
                }
                fetch('api.php', {
                        method: 'POST', // 请求方法
                        headers: {
                            'Content-Type': 'application/json' // 设置请求头，说明请求体是 JSON 格式
                        },
                        body: JSON.stringify(data) // 将 JavaScript 对象转换为 JSON 字符串作为请求体
                    })
                    .then(response => {
                        if (!response.ok) { // 如果响应状态码不是 2xx
                            alert('注册失败，请重试')
                            throw new Error('请求失败，状态码: ' + response.status);
                        }
                        return response.json(); // 解析响应体为 JSON
                    })
                    .then(data => {
                        if (data.code != 1) {
                            alert(data.msg);
                            captcha()
                            return;
                        }
                        window.location.href = '/user?sp=usercenter';
                    })
                    .catch(error => {
                        console.error('发生错误:', error); // 捕获并处理任何错误
                        alert('注册失败，请重试')
                    });
            }
        });
    </script>
</body>

</html>