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
                        <label for="loginEmail" class="form-label">邮箱地址</label>
                        <input type="email" class="form-control" id="loginEmail" placeholder="请输入邮箱">
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">密码</label>
                        <input type="password" class="form-control" id="loginPassword" placeholder="请输入密码">
                    </div>
                </div>
                <div id="registerFields" class="d-none">
                    <div class="mb-3">
                        <label for="registerName" class="form-label">用户名</label>
                        <input type="text" class="form-control" id="registerName" placeholder="请输入用户名">
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">邮箱地址</label>
                        <input type="email" class="form-control" id="registerEmail" placeholder="请输入邮箱">
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">密码</label>
                        <input type="password" class="form-control" id="registerPassword" placeholder="请输入密码">
                    </div>
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
        const formTitle = document.getElementById('formTitle');
        const formButton = document.getElementById('formButton');
        const toggleText = document.getElementById('toggleText');
        const loginFields = document.getElementById('loginFields');
        const registerFields = document.getElementById('registerFields');

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

        // Handle form submission (for demonstration purposes)
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            if (formTitle.innerText === '登录') {
                alert('登录成功！');
            } else {
                alert('注册成功！');
            }
        });
    </script>
</body>
</html>
