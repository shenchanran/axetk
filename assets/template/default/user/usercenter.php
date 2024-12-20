<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AXE题库</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-container {
            display: flex;
            margin-top: 20px;
        }
        .sidebar {
            width: 20%;
        }
        .content {
            width: 80%;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand">AXE题库</span>
            <button class="btn btn-danger" id="logoutButton">退出</button>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <ul class="list-group">
                <li class="list-group-item" data-target="user-center">用户中心</li>
                <li class="list-group-item" data-target="online-search">在线查题</li>
                <li class="list-group-item" data-target="recharge">题库充值</li>
                <li class="list-group-item" data-target="order-records">订单记录</li>
                <li class="list-group-item" data-target="search-history">查题记录</li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="content">
            <div id="user-center" class="content-section active">
                <h3>用户中心</h3>
                <ul class="list-group">
                    <li class="list-group-item">剩余次数: <span id="remaining-count">100</span></li>
                    <li class="list-group-item">成功次数: <span id="success-count">50</span></li>
                    <li class="list-group-item">Token: <span id="token">abcdef123456</span></li>
                    <li class="list-group-item">查询次数: <span id="query-count">200</span></li>
                    <li class="list-group-item">失败次数: <span id="failure-count">10</span></li>
                    <li class="list-group-item">上次活跃时间: <span id="last-active">2024-12-20 10:00:00</span></li>
                </ul>
            </div>
            <div id="online-search" class="content-section">
                <h3>在线查题</h3>
                <div class="mb-3">
                    <label for="question-input" class="form-label">输入题目:</label>
                    <input type="text" id="question-input" class="form-control" placeholder="请输入题目">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary me-2" onclick="searchQuestion('单选题')">单选题</button>
                    <button class="btn btn-primary me-2" onclick="searchQuestion('多选题')">多选题</button>
                    <button class="btn btn-primary me-2" onclick="searchQuestion('判断题')">判断题</button>
                    <button class="btn btn-primary" onclick="searchQuestion('填空题')">填空题</button>
                </div>
                <div id="search-results">
                    <h5>查到的题目与答案:</h5>
                    <p id="question-output">暂无数据</p>
                </div>
            </div>
            <div id="recharge" class="content-section">
                <h3>题库充值</h3>
                <ul class="list-group">
                    <li class="list-group-item">
                        <div>套餐名称: 基础套餐</div>
                        <div>价格: ¥10</div>
                        <div>实际到账: 50次</div>
                        <button class="btn btn-success me-2">微信支付</button>
                        <button class="btn btn-primary">支付宝支付</button>
                    </li>
                    <li class="list-group-item">
                        <div>套餐名称: 标准套餐</div>
                        <div>价格: ¥30</div>
                        <div>实际到账: 200次</div>
                        <button class="btn btn-success me-2">微信支付</button>
                        <button class="btn btn-primary">支付宝支付</button>
                    </li>
                    <li class="list-group-item">
                        <div>套餐名称: 高级套餐</div>
                        <div>价格: ¥50</div>
                        <div>实际到账: 400次</div>
                        <button class="btn btn-success me-2">微信支付</button>
                        <button class="btn btn-primary">支付宝支付</button>
                    </li>
                </ul>
            </div>
            <div id="order-records" class="content-section">
                <h3>订单记录</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>订单号</th>
                            <th>订单金额</th>
                            <th>充值数量</th>
                            <th>充值前数量</th>
                            <th>订单日期</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>123456</td>
                            <td>¥30</td>
                            <td>200</td>
                            <td>50</td>
                            <td>2024-12-20</td>
                        </tr>
                        <tr>
                            <td>654321</td>
                            <td>¥50</td>
                            <td>400</td>
                            <td>250</td>
                            <td>2024-12-19</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-secondary me-2">上一页</button>
                    <button class="btn btn-secondary me-2">1</button>
                    <button class="btn btn-secondary me-2">2</button>
                    <button class="btn btn-secondary">下一页</button>
                </div>
            </div>
            <div id="search-history" class="content-section">
                <h3>查题记录</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>查询的题目</th>
                            <th>查询到的答案</th>
                            <th>查询匹配率</th>
                            <th>查询日期</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>题目示例1</td>
                            <td>答案示例1</td>
                            <td>90%</td>
                            <td>2024-12-20</td>
                        </tr>
                        <tr>
                            <td>题目示例2</td>
                            <td>答案示例2</td>
                            <td>85%</td>
                            <td>2024-12-19</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-secondary me-2">上一页</button>
                    <button class="btn btn-secondary me-2">1</button>
                    <button class="btn btn-secondary me-2">2</button>
                    <button class="btn btn-secondary">下一页</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar navigation logic
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.addEventListener('click', () => {
                // Remove active class from all content sections
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });
                // Add active class to the targeted content section
                const targetId = item.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');
            });
        });

        // Logout button functionality
        document.getElementById('logoutButton').addEventListener('click', () => {
            alert('您已退出登录。');
        });

        // Search question functionality
        function searchQuestion(type) {
            const questionInput = document.getElementById('question-input').value;
            if (!questionInput) {
                alert('请输入题目！');
                return;
            }
            document.getElementById('question-output').textContent = `题型: ${type}, 输入题目: ${questionInput}`;
        }
    </script>
</body>
</html>
