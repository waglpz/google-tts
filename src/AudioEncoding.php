<?php

declare(strict_types=1);

namespace Waglpz\GoogleTTS;

use Google\Cloud\TextToSpeech\V1\AudioEncoding as BaseAudioEncoding;

enum AudioEncoding: int
{
    case LINEAR16 = BaseAudioEncoding::LINEAR16;
    case MP3      = BaseAudioEncoding::MP3;
    case OGG_OPUS = BaseAudioEncoding::OGG_OPUS;
}
