<?php

declare(strict_types=1);

use Dice\Dice;
use Waglpz\GoogleTTS\AudioEncoding;
use Waglpz\GoogleTTS\AudioProfileId;
use Waglpz\GoogleTTS\Gender;
use Waglpz\GoogleTTS\LanguageCode;
use Waglpz\GoogleTTS\SynthesizeSpeechStrategy;
use Waglpz\GoogleTTS\SynthesizeSpeechStrategyFactory;
use Waglpz\GoogleTTS\VoiceType\DeDe;

return [
    '*'                             => [
        'substitutions' => [SynthesizeSpeechStrategy::class => '$DefaultSynthesizeTTSStrategy'],
    ],
    '$DefaultSynthesizeTTSStrategy' => [
        'shared'          => true,
        'instanceOf'      => SynthesizeSpeechStrategyFactory::class,
        'constructParams' => [
            LanguageCode::DE_DE,
            DeDe::FEMALE_STUDIO_C,
            Gender::FEMALE,
            AudioEncoding::MP3,
            AudioProfileId::HEADPHONE_CLASS_DEVICE,
        ],
        'call'            => [['createStrategy', [], Dice::CHAIN_CALL]],
    ],
];
