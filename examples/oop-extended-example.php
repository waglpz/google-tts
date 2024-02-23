<?php

/**
 * Google Text-to-Speech Konvertierung
 * Dieser PHP-Code nutzt Google's Text-to-Speech-Service um Text in gesprochene Sprache zu konvertieren.
 *
 * Abhängigkeiten
 * Der Code benutzt verschiedene Klassen aus dem Waglpz\GoogleTTS Namespace,
 * wie zum Beispiel AudioEncoding, AudioProfileId, Gender, LanguageCode,
 * SynthesizeSpeechStrategyFactory, TextToSpeech
 * und DeDe (eine spezielle Klasse für die deutsche Sprache).
 */

use Waglpz\GoogleTTS\AudioEncoding;
use Waglpz\GoogleTTS\AudioProfileId;
use Waglpz\GoogleTTS\Gender;
use Waglpz\GoogleTTS\LanguageCode;
use Waglpz\GoogleTTS\SpeakingRate;
use Waglpz\GoogleTTS\SynthesizeSpeechStrategyFactory;
use Waglpz\GoogleTTS\TextToSpeech;
use Waglpz\GoogleTTS\VoiceType\DeDe;

/**
 * Benutzung
 *
 * Hier wird zunächst das Composer Autoload-Skript eingebunden,
 * um alle Installierten Abhängigkeiten zu laden.
 * Danach wird die Umgebungsvariable GOOGLE_APPLICATION_CREDENTIALS definiert,
 * die auf den Pfad zur JSON-Datei des Service-Account-Schlüssels zeigt.
 */
require_once __DIR__ . '/../vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=/app/var/service_account.secret.json');

/**
 * Ein Strategy-Factory-Objekt wird erstellt, um die Konfiguration für die Text-zu-Sprache-Konvertierung
 * anzugeben. Hier wird Deutsch als Sprache, eine weibliche Stimme,
 * MP3 als Audio-Encoding und ein Kopfhörergerät als Audio-Profil gewählt.
 */
$strategyFactory = (new SynthesizeSpeechStrategyFactory(
    LanguageCode::DE_DE,
    DeDe::FEMALE_STUDIO_C,
    Gender::FEMALE,
    AudioEncoding::MP3,
    AudioProfileId::HEADPHONE_CLASS_DEVICE

));

$slowAsWaveWearable = $strategyFactory->withSpeakingRate(SpeakingRate::X_1)
                                      ->withAudioEncoding(AudioEncoding::LINEAR16)
                                      ->withAudioProfile(AudioProfileId::WEARABLE_CLASS_DEVICE)
;

$strategy = $slowAsWaveWearable->createStrategy();

/**
 * Ein Objekt der TextToSpeech Klasse wird erstellt
 * und die zuvor erstellte Strategie wird dem Objekt zugewiesen
 */
$tts = new TextToSpeech($strategy);

/**
 * Der zu konvertierende Text wird definiert.
 */
$text = <<<TEXT
Hallo Welt!

Ich bin ein langsames WAV Sound für Smarte Uhr Geräte und das ist ein guter Test!.
TEXT;

/**
 * Der Text wird in gesprochene Sprache konvertiert
 * und das Ergebnis wird in einer JSON formatierten Zeichenkette gespeichert.
 * Wenn während der Ausführung eine Ausnahme auftritt,
 * werden die Fehlermeldung und die Ausnahmespur ausgegeben.
 */
try {
    $json = $tts->convert($text)->serializeToJsonString();
    \file_put_contents(
        __DIR__ . '/../var/soundfile.' . $strategy->extensionForFile(),
        \base64_decode(\json_decode($json)->audioContent)
    );
} catch (\Throwable $exception) {
    print $exception->getMessage();
    print \PHP_EOL;
    print $exception->getTraceAsString();
}
