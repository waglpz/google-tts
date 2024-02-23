<?php

require_once __DIR__ . '/../vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=/app/var/service_account.secret.json');

use Google\ApiCore\ApiException;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\Client\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechRequest;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

const AUDIO_PROFILE = [
    //'handset-class-device'   => 'handset-class-device',
    'headphone-class-device' => 'headphone-class-device',
    //    'large-automotive-class-device'         => 'large-automotive-class-device',
    //    'large-home-entertainment-class-device' => 'large-home-entertainment-class-device',
    //    'medium-bluetooth-speaker-class-device' => 'medium-bluetooth-speaker-class-device',
    //    'small-bluetooth-speaker-class-device'  => 'small-bluetooth-speaker-class-device',
    //    'telephony-class-application'           => 'telephony-class-application',
    //'wearable-class-device'  => 'wearable-class-device',
];

const VOICE_GENDER = [
//    'GENDER_UNSPECIFIED' => SsmlVoiceGender::SSML_VOICE_GENDER_UNSPECIFIED,
//'MALE'   => SsmlVoiceGender::MALE,
'FEMALE' => SsmlVoiceGender::FEMALE,
//    'GENDER_NEUTRAL'     => SsmlVoiceGender::NEUTRAL,

];

/**
 * https://cloud.google.com/text-to-speech/docs/voice-types#studio_voices_preview
 *
 * "Studio" premium voice. This voice type is designed specifically for use with long-form texts
 *          such as narration and news reading.
 *
 * "Neural2" allows anyone to use Custom Voice technology without training their own custom voice.
 *
 * "WaveNet" use the same technology used to produce speech for Google Assistant, Google Search, and Google Translate.
 *           WaveNet technology provides more than just a series of synthetic voices:
 *           it represents a new way of creating synthetic speech.
 *
 * "Standard"
 */
const VOICE = [
//    'MALE'   => [
//        'Neural2'  => [
//            'de-DE-Neural2-B',
//            'de-DE-Neural2-D',
//        ],
//        'Standard' => [
//            'de-DE-Polyglot-1',
//            'de-DE-Standard-B',
//            'de-DE-Standard-D',
//            'de-DE-Standard-E',
//        ],
//        'Studio'   => [
//            'de-DE-Studio-B',
//        ],
//        'WaveNet'  => [
//            'de-DE-Wavenet-B',
//            'de-DE-Wavenet-D',
//            'de-DE-Wavenet-E',
//        ],
//    ],
    'FEMALE' => [
//        'Neural2'  => [
//            'de-DE-Neural2-A',
//            'de-DE-Neural2-C',
//            'de-DE-Neural2-F',
//        ],
        'Standard' => [
            'de-DE-Standard-A',
            'de-DE-Standard-C',
            'de-DE-Standard-F',
        ],
//        'Studio'   => [
//            'de-DE-Studio-C',
//        ],
//        'WaveNet'  => [
//            'de-DE-Wavenet-A',
//            'de-DE-Wavenet-C',
//            'de-DE-Wavenet-F',
//        ],
    ],
];

/**
 * Synthesizes speech synchronously: receive results after all text input
 * has been processed.
 *
 * @param string $voiceLanguageCode The language (and potentially also the region) of the voice
 *                                         expressed as a [BCP-47](https://www.rfc-editor.org/rfc/bcp/bcp47.txt)
 *                                         language tag, e.g. "en-US". This should not include a script tag (e.g. use
 *                                         "cmn-cn" rather than "cmn-Hant-cn"), because the script will be inferred
 *                                         from the input provided in the SynthesisInput.  The TTS service
 *                                         will use this parameter to help choose an appropriate voice.  Note that
 *                                         the TTS service may choose a voice with a slightly different language code
 *                                         than the one selected; it may substitute a different region
 *                                         (e.g. using en-US rather than en-CA if there isn't a Canadian voice
 *                                         available), or even a different language, e.g. using "nb" (Norwegian
 *                                         Bokmal) instead of "no" (Norwegian)".
 * @param int $audioConfigAudioEncoding The format of the audio byte stream.
 */
function synthesize_speech_sample(string $voiceLanguageCode, int $audioConfigAudioEncoding): void
{
    $textToSpeechClient = new TextToSpeechClient();
    $input              = new SynthesisInput();

    $txt = 'Sehr geehrte Kunden,

unser Vorlieferant, die Fernwasserversorgung Elbaue-Ostharz GmbH, muss Reparaturarbeiten am Netz durchführen.  Zur Sicherstellung der Trinkwasserversorgung wird das Trinkwasser in diesen Zeitraum aus dem Bereich Ostharz eingespeist. ';
    $input->setText($txt);


    // Call the API and handle any network failures.
    try {
        foreach (AUDIO_PROFILE as $audioProfileName => $profile) {
            $audioConfig = (new AudioConfig())
                ->setEffectsProfileId([$profile])
                ->setAudioEncoding($audioConfigAudioEncoding)
            ;

            $voiceOptions = (new VoiceSelectionParams())->setLanguageCode($voiceLanguageCode);

            foreach (VOICE_GENDER as $voiceGenderName => $ssmlGender) {
                $voiceOptions->setSsmlGender($ssmlGender);

                if (! isset(VOICE[$voiceGenderName])) {
                    continue;
                }

                foreach (VOICE[$voiceGenderName] as $voiceType => $voiceNames) {
                    foreach ($voiceNames as $voiceName) {
                        $voiceOptions->setName($voiceName);
                        $request  = (new SynthesizeSpeechRequest())
                            ->setInput($input)
                            ->setVoice($voiceOptions)
                            ->setAudioConfig($audioConfig)
                        ;
                        $response = $textToSpeechClient->synthesizeSpeech($request);
                        // OUTPUT JSON EXAMPLE
                        // {"audioOutput": "xxx-BASE64CodedString-xxx...=="}
                        $filename = \sprintf('%s-%s-%s.json', $voiceType, $audioProfileName, $voiceGenderName);
                        file_put_contents(__DIR__ . '/../var/' . $filename, $response->serializeToJsonString());
                    }
                }
            }
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $voiceLanguageCode        = 'de-DE';
    $audioConfigAudioEncoding = AudioEncoding::LINEAR16;

    synthesize_speech_sample($voiceLanguageCode, $audioConfigAudioEncoding);
}

callSample();

/*
 * bash command to decrypt
 * cat soundfile.json | jq -r .audioContent | base64 -d > soundfile.wav
 */


/**
 * ein sound file
 * -> __construct('google API access)
 *  -> gender(female  | male)
 *      -> format (mp3|wav)
 *          -> deviceCass(headphone  | headset)
 *              ->pitch(int): VoicesClass
 *                  ->voice(standard | neural)
 *                  ->(de-DE-Standard-A | de-DE-Standard-C)
 *  ->audioAsStream()
 *  ->audioAsFile(filename)
 *  ->audioAsString()
 */
