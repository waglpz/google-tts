<?php

declare(strict_types=1);

namespace Waglpz\GoogleTTS;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechRequest;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

final class SimpleSynthesizeSpeechStrategy implements SynthesizeSpeechStrategy
{
    public function __construct(
        private readonly AudioConfig $audioConfig = new AudioConfig(),
        private readonly VoiceSelectionParams $voiceOptions = new VoiceSelectionParams(),
        private readonly SynthesizeSpeechRequest $speechRequest = new SynthesizeSpeechRequest(),
    ) {
    }

    public function setSynthesisInput(SynthesisInput $input): SynthesizeSpeechRequest
    {
        return $this->speechRequest
            ->setInput($input)
            ->setVoice($this->voiceOptions)
            ->setAudioConfig($this->audioConfig);
    }

    public function extensionForFile(): string
    {
        $audioEncoding = $this->audioConfig->getAudioEncoding();

        return match ($audioEncoding) {
            AudioEncoding::MP3->value => 'mp3',
            AudioEncoding::OGG_OPUS->value => 'ogg',
            AudioEncoding::LINEAR16->value => 'wav',
            default => 'unknown',
        };
    }
}
