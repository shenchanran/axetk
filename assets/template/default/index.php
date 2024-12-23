<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>题目查询系统</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">题目查询系统</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">首页</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/?sp=login">登录</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1>欢迎来到题目查询系统</h1>
            <p class="lead">快速查找您需要的题目信息！</p>
        </div>
    </header>

    <!-- Search Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">题目查询</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form id="searchForm">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="请输入题目关键字" aria-label="题目关键字">
                            <button class="btn btn-primary" type="submit">查询</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="searchResults" class="mt-4">
                <!-- 查询结果显示区 -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light text-center py-3">
        <p>&copy; 2024 题目查询系统. 版权所有.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript for search -->
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const keyword = document.getElementById('searchInput').value;
            const resultsDiv = document.getElementById('searchResults');
            
            if (keyword) {
                resultsDiv.innerHTML = `<div class="alert alert-info">正在查询“${keyword}”相关内容...</div>`;
                // 模拟查询
                setTimeout(() => {
                    resultsDiv.innerHTML = `
                        <h4>查询结果</h4>
                        <ul class="list-group">
                            <li class="list-group-item">题目1: ${keyword} 示例1</li>
                            <li class="list-group-item">题目2: ${keyword} 示例2</li>
                            <li class="list-group-item">题目3: ${keyword} 示例3</li>
                        </ul>
                    `;
                }, 1000);
            } else {
                resultsDiv.innerHTML = `<div class="alert alert-warning">请输入查询关键字！</div>`;
            }
        });
    </script>
</body>
</html>
