<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Map\Collection;

use Krystal\Stdlib\ArrayCollection;

/**
 * These languages officially supported by Google
 * Taken from original documentation: https://developers.google.com/maps/faq#languagesupport
 */
final class LanguageCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     */
    protected $collection = array(
        'af' => 'Afrikaans',
        'ja' => 'Japanese',
        'sq' => 'Albanian',
        'kn' => 'Kannada',
        'am' => 'Amharic',
        'kk' => 'Kazakh',
        'ar' => 'Arabic',
        'km' => 'Khmer',
        'hy' => 'Armenian',
        'ko' => 'Korean',
        'az' => 'Azerbaijani',
        'ky' => 'Kyrgyz',
        'eu' => 'Basque',
        'lo' => 'Lao',
        'be' => 'Belarusian',
        'lv' => 'Latvian',
        'bn' => 'Bengali',
        'lt' => 'Lithuanian',
        'bs' => 'Bosnian',
        'mk' => 'Macedonian',
        'bg' => 'Bulgarian',
        'ms' => 'Malay',
        'my' => 'Burmese',
        'ml' => 'Malayalam',
        'ca' => 'Catalan',
        'mr' => 'Marathi',
        'zh' => 'Chinese',
        'mn' => 'Mongolian',
        'zh-CN' => 'Chinese (Simplified)',
        'ne' => 'Nepali',
        'zh-HK' => 'Chinese (Hong Kong)',
        'no' => 'Norwegian',
        'zh-TW' => 'Chinese (Traditional)',
        'pl' => 'Polish',
        'hr' => 'Croatian',
        'pt' => 'Portuguese',
        'cs' => 'Czech',
        'pt-BR' => 'Portuguese (Brazil)',
        'da' => 'Danish',
        'pt-PT' => 'Portuguese (Portugal)',
        'nl' => 'Dutch',
        'pa' => 'Punjabi',
        'en' => 'English',
        'ro' => 'Romanian',
        'en-AU' => 'English (Australian)',
        'ru' => 'Russian',
        'en-GB' => 'English (Great Britain)',
        'sr' => 'Serbian',
        'et' => 'Estonian',
        'si' => 'Sinhalese',
        'fa' => 'Farsi',
        'sk' => 'Slovak',
        'fi' => 'Finnish',
        'sl' => 'Slovenian',
        'fil' => 'Filipino',
        'es' => 'Spanish',
        'fr' => 'French',
        'es-419' => 'Spanish (Latin America)',
        'fr-CA' => 'French (Canada)',
        'sw' => 'Swahili',
        'gl' => 'Galician',
        'sv' => 'Swedish',
        'ka' => 'Georgian',
        'ta' => 'Tamil',
        'de' => 'German',
        'te' => 'Telugu',
        'el' => 'Greek',
        'th' => 'Thai',
        'gu' => 'Gujarati',
        'tr' => 'Turkish',
        'iw' => 'Hebrew',
        'uk' => 'Ukrainian',
        'hi' => 'Hindi',
        'ur' => 'Urdu',
        'hu' => 'Hungarian',
        'uz' => 'Uzbek',
        'is' => 'Icelandic',
        'vi' => 'Vietnamese',
        'id' => 'Indonesian',
        'zu' => 'Zulu',
        'it' => 'Italian'
    );
}
