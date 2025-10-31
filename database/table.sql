CREATE DATABASE IF NOT EXISTS task_base
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE task_base;

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(255) NOT NULL,
    task_name TEXT NOT NULL,
    status ENUM('new', 'in_progress', 'done') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tasks (employee_name, task_name, status) VALUES 
('Михаил Кондратенко', 'Разработать главную страницу сайта', 'new'),
('Юрий Стратийчук', 'Написать API для пользователей', 'in_progress'),
('Данил Бакалкин', 'Исправить ошибки в модуле оплаты', 'done'),
('Григорий Пишун', 'Создать мобильную версию приложения', 'new'),
('Дмитрий Войнов', 'Оптимизировать базу данных', 'in_progress');


SELECT 'Таблица tasks создана!' as status;
SELECT COUNT(*) as total_tasks FROM tasks;