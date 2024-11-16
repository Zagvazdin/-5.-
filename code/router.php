// router.php

function renderErrorPage() {
    header("HTTP/1.0 404 Not Found");
    exit;
}

// Пример маршрутизации
if (!$controller) {
    renderErrorPage();
}
