<?php

if (! function_exists('view')) {
    function view(string $view, array $data = [], string $parentLayout = 'layout'): string
    {
        $file = __DIR__ . '/../Views/' . $view . '.php';
        if (! file_exists($file)) {
            throw new \InvalidArgumentException("View \"{$view}\" não encontrada em: {$file}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        include $file;
        $innerContent = ob_get_clean();

        if ($view === $parentLayout) {
            return $innerContent;
        }

        $data['content'] = $innerContent;

        $data['title'] = $data['title'] ?? $_ENV['APP_NAME'];

        return view($parentLayout, $data, $parentLayout);
    }
}

if (! function_exists('dd')) {
    function dd(...$vars): void
    {
        foreach ($vars as $var) {
            echo '<pre style="text-align: left; background: #f8f9fa; padding: 10px; border: 1px solid #ddd;">';
            var_dump($var);
            echo '</pre>';
        }
        die();
    }
}

if (! function_exists('redirect')) {
    function redirect(string $route): void
    {
        header("Location: $route");
        die();
    }
}
