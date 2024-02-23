<?php

declare(strict_types=1);

namespace Waglpz\GoogleTTS;

use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechRequest;

interface SynthesizeSpeechStrategy
{
    public function setSynthesisInput(SynthesisInput $input): SynthesizeSpeechRequest;

    public function extensionForFile(): string;
}
