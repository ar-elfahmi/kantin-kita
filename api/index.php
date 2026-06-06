<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
$publicIndex = $projectRoot . '/public/index.php';

if (! file_exists($publicIndex)) {
    http_response_code(500);
    echo 'Laravel public/index.php tidak ditemukan.';
    exit;
}

$_SERVER['SCRIPT_FILENAME'] = $publicIndex;
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

chdir($projectRoot);

require $publicIndex;
