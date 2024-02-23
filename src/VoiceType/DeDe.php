<?php

declare(strict_types=1);

namespace Waglpz\GoogleTTS\VoiceType;

enum DeDe: string implements VoiceTypeEnum
{
    case MALE_NEURAL2_B           = 'de-DE-Neural2-B';
    case MALE_NEURAL2_D           = 'de-DE-Neural2-D';
    case MALE_STANDARD_POLYGLOT_1 = 'de-DE-Polyglot-1';
    case MALE_STANDARD_B          = 'de-DE-Standard-B';
    case MALE_STANDARD_D          = 'de-DE-Standard-D';
    case MALE_STANDARD_E          = 'de-DE-Standard-E';
    case MALE_STUDIO_B            = 'de-DE-Studio-B';
    case MALE_WAVENET_B           = 'de-DE-Wavenet-B';
    case MALE_WAVENET_D           = 'de-DE-Wavenet-D';
    case MALE_WAVENET_E           = 'de-DE-Wavenet-E';

    case FEMALE_NEURAL2_A  = 'de-DE-Neural2-A';
    case FEMALE_NEURAL2_C  = 'de-DE-Neural2-C';
    case FEMALE_NEURAL2_F  = 'de-DE-Neural2-F';
    case FEMALE_STANDARD_A = 'de-DE-Standard-A';
    case FEMALE_STANDARD_C = 'de-DE-Standard-C';
    case FEMALE_STANDARD_F = 'de-DE-Standard-F';
    case FEMALE_STUDIO_C   = 'de-DE-Studio-C';
    case FEMALE_WAVENET_A  = 'de-DE-Wavenet-A';
    case FEMALE_WAVENET_C  = 'de-DE-Wavenet-C';
    case FEMALE_WAVENET_F  = 'de-DE-Wavenet-F';

    public function value(): string
    {
        return $this->value;
    }
}
