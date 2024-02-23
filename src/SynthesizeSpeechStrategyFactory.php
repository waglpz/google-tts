<?php

declare(strict_types=1);

namespace Waglpz\GoogleTTS;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Waglpz\GoogleTTS\VoiceType\VoiceTypeEnum;

final class SynthesizeSpeechStrategyFactory
{
    /** @var array<AudioProfileId> $audioProfile */
    private readonly array $audioProfile;
    private SpeakingRate $speakingRate;

    public function __construct(
        private readonly LanguageCode $languageCode,
        private readonly VoiceTypeEnum $voiceType,
        private readonly Gender $speechGender,
        private readonly AudioEncoding $audioEncoding,
        AudioProfileId ...$audioProfile,
    ) {
        $this->speakingRate = SpeakingRate::X_1;

        if (\count($audioProfile) < 1) {
            throw new \InvalidArgumentException('Expected audio profile id from enum.');
        }

        $this->audioProfile = $audioProfile;
    }

    public function createStrategy(): SynthesizeSpeechStrategy
    {
        $audioProfileIds = \array_map(static fn ($id) => $id->value, $this->audioProfile);

        $audioConfig = (new AudioConfig())
            ->setEffectsProfileId($audioProfileIds)
            ->setSpeakingRate((float) $this->speakingRate->value)
            ->setAudioEncoding($this->audioEncoding->value);

        $voiceOptions = (new VoiceSelectionParams())
            ->setSsmlGender($this->speechGender->value)
            ->setName($this->voiceType->value())
            ->setLanguageCode($this->languageCode->value);

        return new SimpleSynthesizeSpeechStrategy($audioConfig, $voiceOptions);
    }

    public function withSpeakingRate(SpeakingRate $speakingRate): self
    {
        $self               = $this->copySelf();
        $self->speakingRate = $speakingRate;

        return $self;
    }

    public function withAudioEncoding(AudioEncoding $audioEncoding): self
    {
        $self               = $this->copySelf($audioEncoding);
        $self->speakingRate = $this->speakingRate;

        return $self;
    }

    public function withAudioProfile(AudioProfileId ...$audioProfileId): self
    {
        $self               = $this->copySelf(null, ...$audioProfileId);
        $self->speakingRate = $this->speakingRate;

        return $self;
    }

    private function copySelf(
        AudioEncoding|null $audioEncoding = null,
        AudioProfileId ...$audioProfile,
    ): self {
        return new self(
            $this->languageCode,
            $this->voiceType,
            $this->speechGender,
            $audioEncoding ?? $this->audioEncoding,
            ...(\count($audioProfile) > 0 ? $audioProfile : $this->audioProfile),
        );
    }
}
