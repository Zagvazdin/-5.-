<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Geekbrains\Application1\Application;

class Application {
    private $users = []; // Хранилище пользователей

    public function run() {
        // Получаем текущий URL
        $requestUri = $_SERVER['REQUEST_URI'];
        
        try {
            // Обработка маршрутов
            switch (true) {
                case $requestUri === '/':
                    $this->home();
                    break;
                case $requestUri === '/user':
                    $this->user();
                    break;
                case preg_match('/^\/user\/save\/?$/', $requestUri):
                    $this->saveUser();
                    break;
                case $requestUri === '/about':
                    $this->about();
                    break;
                default:
                    throw new Exception("Страница не найдена", 404);
            }
        } catch (Exception $e) {
            // Если произошла ошибка, отображаем страницу ошибки
            $this->renderErrorPage();
        }
    }

    private function home() {
        echo "<h1>Главная страница</h1>";
        echo "<p>Добро пожаловать на наш сайт!</p>";
    }

    private function user() {
        echo "<h1>Пользователи</h1>";
        echo "<p>Здесь будет список пользователей:</p>";
        foreach ($this->users as $user) {
            echo "<p>Имя: {$user['name']}, Дата рождения: {$user['birthday']}</p>";
        }
    }

    private function saveUser() {
        // Получаем параметры из GET-запроса
        $name = $_GET['name'] ?? null;
        $birthday = $_GET['birthday'] ?? null;

        if ($name && $birthday) {
            // Сохраняем пользователя в хранилище
            $this->users[] = [
                'name' => htmlspecialchars($name),
                'birthday' => htmlspecialchars($birthday)
            ];
            echo "Пользователь '{$name}' успешно сохранен!";
        } else {
            echo "Ошибка: Необходимы параметры 'name' и 'birthday'.";
        }
    }

    private function about() {
        echo "<h1>О нас</h1>";
        echo "<p>Информация о нашей компании.</p>";
    }

    private function renderErrorPage() {
        header("HTTP/1.0 404 Not Found");
        echo $this->render('views/error_page_function.html.twig', ['current_year' => date('Y')]);
        exit;
    }

    private function render($template, $data) {
        extract($data);
        include $template;
    }
}

$app = new Application();
echo $app->run();
