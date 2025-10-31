<?php
require_once 'config/connection.php';

$database = new Database();
$db = $database->getConnection();
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';

if ($status_filter == 'all') 
{
    $query = "SELECT * FROM tasks ORDER BY id DESC";
    $stmt = $db->prepare($query);
} 
else 
{
    $query = "SELECT * FROM tasks WHERE status = :status ORDER BY id DESC";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':status', $status_filter);
}

$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менеджер задач</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>📋 Менеджер задач</h1>
        
        <!-- Фильтры -->
        <div class="filters">
            <a href="?status=all" class="filter-btn <?= $status_filter == 'all' ? 'active' : '' ?>">Все</a>
            <a href="?status=new" class="filter-btn <?= $status_filter == 'new' ? 'active' : '' ?>">Новые</a>
            <a href="?status=in_progress" class="filter-btn <?= $status_filter == 'in_progress' ? 'active' : '' ?>">В работе</a>
            <a href="?status=done" class="filter-btn <?= $status_filter == 'done' ? 'active' : '' ?>">Выполненные</a>
        </div>
        
        <!-- Кнопка добавления -->
        <button class="add-btn" onclick="openModal()">+ Добавить задачу</button>
        
        <!-- Таблица задач -->
        <table class="tasks-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Сотрудник</th>
                    <th>Задача</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($tasks) > 0): ?>
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['id']) ?></td>
                        <td><?= htmlspecialchars($task['employee_name']) ?></td>
                        <td><?= htmlspecialchars($task['task_name']) ?></td>
                        <td>
                            <span class="status-badge status-<?= $task['status'] ?>">
                                <?= $task['status'] ?>
                            </span>
                        </td>
                        <td><?= date('d.m.Y H:i', strtotime($task['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-tasks">Задачи не найдены</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Модальное окно -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Добавить задачу</h2>
            <form method="POST" action="task.php">
                <div class="form-group">
                    <label>Имя сотрудника:</label>
                    <input type="text" name="employee_name" required>
                </div>
                <div class="form-group">
                    <label>Название задачи:</label>
                    <textarea name="task_name" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Добавить</button>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>