<?php

declare(strict_types=1);

namespace Waglpz\GoogleTTS;

use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;

enum Gender: int
{
    case GENDER_UNSPECIFIED = SsmlVoiceGender::SSML_VOICE_GENDER_UNSPECIFIED;
    case MALE               = SsmlVoiceGender::MALE;
    case FEMALE             = SsmlVoiceGender::FEMALE;
    case GENDER_NEUTRAL     = SsmlVoiceGender::NEUTRAL;
}
