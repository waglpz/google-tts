<?php

declare(strict_types=1);

namespace Waglpz\GoogleTTS;

enum SpeakingRate: string
{
    case X_0_25 = '0.25';
    case X_0_5  = '0.5';
    case X_0_75 = '0.75';
    case X_1    = '1.0';
    case X_1_25 = '1.25';
    case X_1_5  = '1.5';
    case X_1_75 = '1.75';
    case X_2    = '2.0';
}
