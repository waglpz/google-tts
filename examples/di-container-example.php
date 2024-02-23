<?php

use Waglpz\GoogleTTS\TextToSpeech;
use function Waglpz\DiContainer\container;

require_once __DIR__ . '/../vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=/app/var/service_account.secret.json');
const PROJECT_CONFIG_DIRECTORY = __DIR__ . '/../config';

$container = container();

/** @phpstan-var TextToSpeech $tts */
$tts = $container->get(TextToSpeech::class);

$text = <<<TEXT
Hallo Welt!

Und Tschüs ;)
TEXT;

try {
    $convertResult = $tts->convert($text);
    $fileExtension = $tts->extensionForFile();
    $json = $tts->convert($text)->serializeToJsonString();
    \file_put_contents(
        __DIR__ . '/../var/soundfile.' . $fileExtension,
        \base64_decode(\json_decode($json)->audioContent)
    );
} catch (\Throwable $exception) {
    print $exception->getMessage();
    print \PHP_EOL;
    print $exception->getTraceAsString();
}
