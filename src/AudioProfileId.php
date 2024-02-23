<?php

declare(strict_types=1);

namespace Waglpz\GoogleTTS;

enum AudioProfileId: string
{
    case HANDSET_CLASS_DEVICE                  = 'handset-class-device';
    case HEADPHONE_CLASS_DEVICE                = 'headphone-class-device';
    case LARGE_AUTOMOTIVE_CLASS_DEVICE         = 'large-automotive-class-device';
    case LARGE_HOME_ENTERTAINMENT_CLASS_DEVICE = 'large-home-entertainment-class-device';
    case MEDIUM_BLUETOOTH_SPEAKER_CLASS_DEVICE = 'medium-bluetooth-speaker-class-device';
    case SMALL_BLUETOOTH_SPEAKER_CLASS_DEVICE  = 'small-bluetooth-speaker-class-device';
    case TELEPHONY_CLASS_APPLICATION           = 'telephony-class-application';
    case WEARABLE_CLASS_DEVICE                 = 'wearable-class-device';
}
