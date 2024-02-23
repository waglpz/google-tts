<?php

declare(strict_types=1);

namespace Waglpz\GoogleTTS;

use Google\ApiCore\ApiException;
use Google\Cloud\TextToSpeech\V1\Client\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechResponse;

final class TextToSpeech
{
    public function __construct(
        private readonly SynthesizeSpeechStrategy $strategy,
        private readonly SynthesisInput $input = new SynthesisInput(),
        private readonly TextToSpeechClient $client = new TextToSpeechClient(),
    ) {
    }

    /** @throws ApiException */
    public function convert(string $text): SynthesizeSpeechResponse
    {
        $this->input->setText($text);
        $request = $this->strategy->setSynthesisInput($this->input);

        return $this->client->synthesizeSpeech($request);
    }

    public function extensionForFile(): string
    {
        return $this->strategy->extensionForFile();
    }
}
