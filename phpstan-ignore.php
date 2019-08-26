<?php

declare(strict_types=1);

use Nette\Neon\Neon;

require __DIR__ . '/vendor/autoload.php';

$jsonPath = $argv[1];
$json = file_get_contents($jsonPath);
$report = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

$cwd = getcwd() . '/';
assert(is_string($cwd));

$ignores = [];

/* @noinspection ForeachSourceInspection */
foreach ($report['files'] as $path => $messages) {
    $path = str_replace($cwd, '', $path);
    foreach ($messages['messages'] as ['message' => $message, /*'line' => $line, */'ignorable' => $ignorable]) {
        if ($ignorable) {
            if (!isset($ignores[$path])) {
                $ignores[$path] = [];
            }
            $ignores[$path][] = $message;
        }
    }
}

$result = [];
foreach ($ignores as $path => $messages) {
    foreach ($messages as $message) {
        $result[] = [
            'path' => $path,
            'message' => '#' . preg_quote($message, '#') . '#',
        ];
    }
}

echo Neon::encode(['parameters' => ['ignoreErrors' => $result]], Neon::BLOCK);
