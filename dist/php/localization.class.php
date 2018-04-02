<?php

class Localization
{
    /**
     * The language directory.
     *
     * @var string
     */
    private $language_dir;

    /**
     * The fallback locale.
     *
     * @var string
     */
    private $fallback_locale;

    /**
     * The language get parameter.
     *
     * @var string
     */
    private $language_param;

    /**
     * The array of loaded locales.
     *
     * @var array
     */
    private $loaded = [];

    /*
     * Language database, based on Wikipedia.
     * Source: https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     */
    private static $iso_639 = array(
        array('Abkhazian', 'аҧсуа бызшәа, аҧсшәа', 'ab', 'abk', 'abk', 'abk'),
        array('Afar', 'Afaraf', 'aa', 'aar', 'aar', 'aar'),
        array('Afrikaans', 'Afrikaans', 'af', 'afr', 'afr', 'afr'),
        array('Akan', 'Akan', 'ak', 'aka', 'aka', 'aka + 2'),
        array('Albanian', 'Shqip', 'sq', 'sqi', 'alb', 'sqi + 4'),
        array('Amharic', 'አማርኛ', 'am', 'amh', 'amh', 'amh'),
        array('Arabic', 'العربية', 'ar', 'ara', 'ara', 'ara + 30'),
        array('Aragonese', 'aragonés', 'an', 'arg', 'arg', 'arg'),
        array('Armenian', 'Հայերեն', 'hy', 'hye', 'arm', 'hye'),
        array('Assamese', 'অসমীয়া', 'as', 'asm', 'asm', 'asm'),
        array('Avaric', 'авар мацӀ, магӀарул мацӀ', 'av', 'ava', 'ava', 'ava'),
        array('Avestan', 'avesta', 'ae', 'ave', 'ave', 'ave'),
        array('Aymara', 'aymar aru', 'ay', 'aym', 'aym', 'aym + 2'),
        array('Azerbaijani', 'azərbaycan dili', 'az', 'aze', 'aze', 'aze + 2'),
        array('Bambara', 'bamanankan', 'bm', 'bam', 'bam', 'bam'),
        array('Bashkir', 'башҡорт теле', 'ba', 'bak', 'bak', 'bak'),
        array('Basque', 'euskara, euskera', 'eu', 'eus', 'baq', 'eus'),
        array('Belarusian', 'беларуская мова', 'be', 'bel', 'bel', 'bel'),
        array('Bengali', 'বাংলা', 'bn', 'ben', 'ben', 'ben'),
        array('Bihari languages', 'भोजपुरी', 'bh', 'bih', 'bih', ''),
        array('Bislama', 'Bislama', 'bi', 'bis', 'bis', 'bis'),
        array('Bosnian', 'bosanski jezik', 'bs', 'bos', 'bos', 'bos'),
        array('Breton', 'brezhoneg', 'br', 'bre', 'bre', 'bre'),
        array('Bulgarian', 'български език', 'bg', 'bul', 'bul', 'bul'),
        array('Burmese', 'ဗမာစာ', 'my', 'mya', 'bur', 'mya'),
        array('Catalan, Valencian', 'català, valencià', 'ca', 'cat', 'cat', 'cat'),
        array('Chamorro', 'Chamoru', 'ch', 'cha', 'cha', 'cha'),
        array('Chechen', 'нохчийн мотт', 'ce', 'che', 'che', 'che'),
        array('Chichewa, Chewa, Nyanja', 'chiCheŵa, chinyanja', 'ny', 'nya', 'nya', 'nya'),
        array('Chinese', '中文 (Zhōngwén), 汉语, 漢語', 'zh', 'zho', 'chi', 'zho + 13'),
        array('Chuvash', 'чӑваш чӗлхи', 'cv', 'chv', 'chv', 'chv'),
        array('Cornish', 'Kernewek', 'kw', 'cor', 'cor', 'cor'),
        array('Corsican', 'corsu, lingua corsa', 'co', 'cos', 'cos', 'cos'),
        array('Cree', 'ᓀᐦᐃᔭᐍᐏᐣ', 'cr', 'cre', 'cre', 'cre + 6'),
        array('Croatian', 'hrvatski jezik', 'hr', 'hrv', 'hrv', 'hrv'),
        array('Czech', 'čeština, český jazyk', 'cs', 'ces', 'cze', 'ces'),
        array('Danish', 'dansk', 'da', 'dan', 'dan', 'dan'),
        array('Divehi, Dhivehi, Maldivian', 'ދިވެހި', 'dv', 'div', 'div', 'div'),
        array('Dutch, Flemish', 'Nederlands, Vlaams', 'nl', 'nld', 'dut', 'nld'),
        array('Dzongkha', 'རྫོང་ཁ', 'dz', 'dzo', 'dzo', 'dzo'),
        array('English', 'English', 'en', 'eng', 'eng', 'eng'),
        array('Esperanto', 'Esperanto', 'eo', 'epo', 'epo', 'epo'),
        array('Estonian', 'eesti, eesti keel', 'et', 'est', 'est', 'est + 2'),
        array('Ewe', 'Eʋegbe', 'ee', 'ewe', 'ewe', 'ewe'),
        array('Faroese', 'føroyskt', 'fo', 'fao', 'fao', 'fao'),
        array('Fijian', 'vosa Vakaviti', 'fj', 'fij', 'fij', 'fij'),
        array('Finnish', 'suomi, suomen kieli', 'fi', 'fin', 'fin', 'fin'),
        array('French', 'français, langue française', 'fr', 'fra', 'fre', 'fra'),
        array('Fulah', 'Fulfulde, Pulaar, Pular', 'ff', 'ful', 'ful', 'ful + 9'),
        array('Galician', 'Galego', 'gl', 'glg', 'glg', 'glg'),
        array('Georgian', 'ქართული', 'ka', 'kat', 'geo', 'kat'),
        array('German', 'Deutsch', 'de', 'deu', 'ger', 'deu'),
        array('Greek (modern)', 'ελληνικά', 'el', 'ell', 'gre', 'ell'),
        array('Guaraní', 'Avañe\'ẽ', 'gn', 'grn', 'grn', 'grn + 5'),
        array('Gujarati', 'ગુજરાતી', 'gu', 'guj', 'guj', 'guj'),
        array('Haitian, Haitian Creole', 'Kreyòl ayisyen', 'ht', 'hat', 'hat', 'hat'),
        array('Hausa', '(Hausa) هَوُسَ', 'ha', 'hau', 'hau', 'hau'),
        array('Hebrew (modern)', 'עברית', 'he', 'heb', 'heb', 'heb'),
        array('Herero', 'Otjiherero', 'hz', 'her', 'her', 'her'),
        array('Hindi', 'हिन्दी, हिंदी', 'hi', 'hin', 'hin', 'hin'),
        array('Hiri Motu', 'Hiri Motu', 'ho', 'hmo', 'hmo', 'hmo'),
        array('Hungarian', 'magyar', 'hu', 'hun', 'hun', 'hun'),
        array('Interlingua', 'Interlingua', 'ia', 'ina', 'ina', 'ina'),
        array('Indonesian', 'Bahasa Indonesia', 'id', 'ind', 'ind', 'ind'),
        array('Interlingue', 'Interlingue', 'ie', 'ile', 'ile', 'ile'),
        array('Irish', 'Gaeilge', 'ga', 'gle', 'gle', 'gle'),
        array('Igbo', 'Asụsụ Igbo', 'ig', 'ibo', 'ibo', 'ibo'),
        array('Inupiaq', 'Iñupiaq, Iñupiatun', 'ik', 'ipk', 'ipk', 'ipk + 2'),
        array('Ido', 'Ido', 'io', 'ido', 'ido', 'ido'),
        array('Icelandic', 'Íslenska', 'is', 'isl', 'ice', 'isl'),
        array('Italian', 'Italiano', 'it', 'ita', 'ita', 'ita'),
        array('Inuktitut', 'ᐃᓄᒃᑎᑐᑦ', 'iu', 'iku', 'iku', 'iku + 2'),
        array('Japanese', '日本語 (にほんご)', 'ja', 'jpn', 'jpn', 'jpn'),
        array('Javanese', 'ꦧꦱꦗꦮ, Basa Jawa', 'jv', 'jav', 'jav', 'jav'),
        array('Kalaallisut, Greenlandic', 'kalaallisut, kalaallit oqaasii', 'kl', 'kal', 'kal', 'kal'),
        array('Kannada', 'ಕನ್ನಡ', 'kn', 'kan', 'kan', 'kan'),
        array('Kanuri', 'Kanuri', 'kr', 'kau', 'kau', 'kau + 3'),
        array('Kashmiri', 'कश्मीरी, كشميري‎', 'ks', 'kas', 'kas', 'kas'),
        array('Kazakh', 'қазақ тілі', 'kk', 'kaz', 'kaz', 'kaz'),
        array('Central Khmer', 'ខ្មែរ, ខេមរភាសា, ភាសាខ្មែរ', 'km', 'khm', 'khm', 'khm'),
        array('Kikuyu, Gikuyu', 'Gĩkũyũ', 'ki', 'kik', 'kik', 'kik'),
        array('Kinyarwanda', 'Ikinyarwanda', 'rw', 'kin', 'kin', 'kin'),
        array('Kirghiz, Kyrgyz', 'Кыргызча, Кыргыз тили', 'ky', 'kir', 'kir', 'kir'),
        array('Komi', 'коми кыв', 'kv', 'kom', 'kom', 'kom + 2'),
        array('Kongo', 'Kikongo', 'kg', 'kon', 'kon', 'kon + 3'),
        array('Korean', '한국어', 'ko', 'kor', 'kor', 'kor'),
        array('Kurdish', 'Kurdî, كوردی‎', 'ku', 'kur', 'kur', 'kur + 3'),
        array('Kuanyama, Kwanyama', 'Kuanyama', 'kj', 'kua', 'kua', 'kua'),
        array('Latin', 'latine, lingua latina', 'la', 'lat', 'lat', 'lat'),
        array('Luxembourgish, Letzeburgesch', 'Lëtzebuergesch', 'lb', 'ltz', 'ltz', 'ltz'),
        array('Ganda', 'Luganda', 'lg', 'lug', 'lug', 'lug'),
        array('Limburgan, Limburger, Limburgish', 'Limburgs', 'li', 'lim', 'lim', 'lim'),
        array('Lingala', 'Lingála', 'ln', 'lin', 'lin', 'lin'),
        array('Lao', 'ພາສາລາວ', 'lo', 'lao', 'lao', 'lao'),
        array('Lithuanian', 'lietuvių kalba', 'lt', 'lit', 'lit', 'lit'),
        array('Luba-Katanga', 'Kiluba', 'lu', 'lub', 'lub', 'lub'),
        array('Latvian', 'Latviešu Valoda', 'lv', 'lav', 'lav', 'lav + 2'),
        array('Manx', 'Gaelg, Gailck', 'gv', 'glv', 'glv', 'glv'),
        array('Macedonian', 'македонски јазик', 'mk', 'mkd', 'mac', 'mkd'),
        array('Malagasy', 'fiteny malagasy', 'mg', 'mlg', 'mlg', 'mlg + 10'),
        array('Malay', 'Bahasa Melayu, بهاس ملايو‎', 'ms', 'msa', 'may', 'msa + 13'),
        array('Malayalam', 'മലയാളം', 'ml', 'mal', 'mal', 'mal'),
        array('Maltese', 'Malti', 'mt', 'mlt', 'mlt', 'mlt'),
        array('Maori', 'te reo Māori', 'mi', 'mri', 'mao', 'mri'),
        array('Marathi', 'मराठी', 'mr', 'mar', 'mar', 'mar'),
        array('Marshallese', 'Kajin M̧ajeļ', 'mh', 'mah', 'mah', 'mah'),
        array('Mongolian', 'Монгол хэл', 'mn', 'mon', 'mon', 'mon + 2'),
        array('Nauru', 'Dorerin Naoero', 'na', 'nau', 'nau', 'nau'),
        array('Navajo, Navaho', 'Diné bizaad', 'nv', 'nav', 'nav', 'nav'),
        array('North Ndebele', 'isiNdebele', 'nd', 'nde', 'nde', 'nde'),
        array('Nepali', 'नेपाली', 'ne', 'nep', 'nep', 'nep'),
        array('Ndonga', 'Owambo', 'ng', 'ndo', 'ndo', 'ndo'),
        array('Norwegian Bokmål', 'Norsk Bokmål', 'nb', 'nob', 'nob', 'nob'),
        array('Norwegian Nynorsk', 'Norsk Nynorsk', 'nn', 'nno', 'nno', 'nno'),
        array('Norwegian', 'Norsk', 'no', 'nor', 'nor', 'nor + 2'),
        array('Sichuan Yi, Nuosu', 'ꆈꌠ꒿ Nuosuhxop', 'ii', 'iii', 'iii', 'iii'),
        array('South Ndebele', 'isiNdebele', 'nr', 'nbl', 'nbl', 'nbl'),
        array('Occitan', 'occitan, lenga d\'òc', 'oc', 'oci', 'oci', 'oci'),
        array('Ojibwa', 'ᐊᓂᔑᓈᐯᒧᐎᓐ', 'oj', 'oji', 'oji', 'oji + 7'),
        array('Church Slavic, Church Slavonic, Old Church Slavonic, Old Slavonic, Old Bulgarian', 'ѩзыкъ словѣньскъ', 'cu', 'chu', 'chu', 'chu'),
        array('Oromo', 'Afaan Oromoo', 'om', 'orm', 'orm', 'orm + 4'),
        array('Oriya', 'ଓଡ଼ିଆ', 'or', 'ori', 'ori', 'ori'),
        array('Ossetian, Ossetic', 'ирон æвзаг', 'os', 'oss', 'oss', 'oss'),
        array('Panjabi, Punjabi', 'ਪੰਜਾਬੀ', 'pa', 'pan', 'pan', 'pan'),
        array('Pali', 'पाऴि', 'pi', 'pli', 'pli', 'pli'),
        array('Persian', 'فارسی', 'fa', 'fas', 'per', 'fas + 2'),
        array('Polish', 'język polski, Polszczyzna', 'pl', 'pol', 'pol', 'pol'),
        array('Pashto, Pushto', 'پښتو', 'ps', 'pus', 'pus', 'pus + 3'),
        array('Portuguese', 'Português', 'pt', 'por', 'por', 'por'),
        array('Quechua', 'Runa Simi, Kichwa', 'qu', 'que', 'que', 'que + 44'),
        array('Romansh', 'Rumantsch Grischun', 'rm', 'roh', 'roh', 'roh'),
        array('Rundi', 'Ikirundi', 'rn', 'run', 'run', 'run'),
        array('Romanian, Moldavian, Moldovan', 'Română', 'ro', 'ron', 'rum', 'ron'),
        array('Russian', 'Русский', 'ru', 'rus', 'rus', 'rus'),
        array('Sanskrit', 'संस्कृतम्', 'sa', 'san', 'san', 'san'),
        array('Sardinian', 'sardu', 'sc', 'srd', 'srd', 'srd + 4'),
        array('Sindhi', 'सिन्धी, سنڌي، سندھی‎', 'sd', 'snd', 'snd', 'snd'),
        array('Northern Sami', 'Davvisámegiella', 'se', 'sme', 'sme', 'sme'),
        array('Samoan', 'gagana fa\'a Samoa', 'sm', 'smo', 'smo', 'smo'),
        array('Sango', 'yângâ tî sängö', 'sg', 'sag', 'sag', 'sag'),
        array('Serbian', 'српски језик', 'sr', 'srp', 'srp', 'srp'),
        array('Gaelic, Scottish Gaelic', 'Gàidhlig', 'gd', 'gla', 'gla', 'gla'),
        array('Shona', 'chiShona', 'sn', 'sna', 'sna', 'sna'),
        array('Sinhala, Sinhalese', 'සිංහල', 'si', 'sin', 'sin', 'sin'),
        array('Slovak', 'Slovenčina, Slovenský Jazyk', 'sk', 'slk', 'slo', 'slk'),
        array('Slovenian', 'Slovenski Jezik, Slovenščina', 'sl', 'slv', 'slv', 'slv'),
        array('Somali', 'Soomaaliga, af Soomaali', 'so', 'som', 'som', 'som'),
        array('Southern Sotho', 'Sesotho', 'st', 'sot', 'sot', 'sot'),
        array('Spanish, Castilian', 'Español', 'es', 'spa', 'spa', 'spa'),
        array('Sundanese', 'Basa Sunda', 'su', 'sun', 'sun', 'sun'),
        array('Swahili', 'Kiswahili', 'sw', 'swa', 'swa', 'swa + 2'),
        array('Swati', 'SiSwati', 'ss', 'ssw', 'ssw', 'ssw'),
        array('Swedish', 'Svenska', 'sv', 'swe', 'swe', 'swe'),
        array('Tamil', 'தமிழ்', 'ta', 'tam', 'tam', 'tam'),
        array('Telugu', 'తెలుగు', 'te', 'tel', 'tel', 'tel'),
        array('Tajik', 'тоҷикӣ, toçikī, تاجیکی‎', 'tg', 'tgk', 'tgk', 'tgk'),
        array('Thai', 'ไทย', 'th', 'tha', 'tha', 'tha'),
        array('Tigrinya', 'ትግርኛ', 'ti', 'tir', 'tir', 'tir'),
        array('Tibetan', 'བོད་ཡིག', 'bo', 'bod', 'tib', 'bod'),
        array('Turkmen', 'Türkmen, Түркмен', 'tk', 'tuk', 'tuk', 'tuk'),
        array('Tagalog', 'Wikang Tagalog', 'tl', 'tgl', 'tgl', 'tgl'),
        array('Tswana', 'Setswana', 'tn', 'tsn', 'tsn', 'tsn'),
        array('Tonga (Tonga Islands)', 'Faka Tonga', 'to', 'ton', 'ton', 'ton'),
        array('Turkish', 'Türkçe', 'tr', 'tur', 'tur', 'tur'),
        array('Tsonga', 'Xitsonga', 'ts', 'tso', 'tso', 'tso'),
        array('Tatar', 'татар теле, tatar tele', 'tt', 'tat', 'tat', 'tat'),
        array('Twi', 'Twi', 'tw', 'twi', 'twi', 'twi'),
        array('Tahitian', 'Reo Tahiti', 'ty', 'tah', 'tah', 'tah'),
        array('Uighur, Uyghur', 'ئۇيغۇرچە‎, Uyghurche', 'ug', 'uig', 'uig', 'uig'),
        array('Ukrainian', 'Українська', 'uk', 'ukr', 'ukr', 'ukr'),
        array('Urdu', 'اردو', 'ur', 'urd', 'urd', 'urd'),
        array('Uzbek', 'Oʻzbek, Ўзбек, أۇزبېك‎', 'uz', 'uzb', 'uzb', 'uzb + 2'),
        array('Venda', 'Tshivenḓa', 've', 'ven', 'ven', 'ven'),
        array('Vietnamese', 'Tiếng Việt', 'vi', 'vie', 'vie', 'vie'),
        array('Volapük', 'Volapük', 'vo', 'vol', 'vol', 'vol'),
        array('Walloon', 'Walon', 'wa', 'wln', 'wln', 'wln'),
        array('Welsh', 'Cymraeg', 'cy', 'cym', 'wel', 'cym'),
        array('Wolof', 'Wollof', 'wo', 'wol', 'wol', 'wol'),
        array('Western Frisian', 'Frysk', 'fy', 'fry', 'fry', 'fry'),
        array('Xhosa', 'isiXhosa', 'xh', 'xho', 'xho', 'xho'),
        array('Yiddish', 'ייִדיש', 'yi', 'yid', 'yid', 'yid + 2'),
        array('Yoruba', 'Yorùbá', 'yo', 'yor', 'yor', 'yor'),
        array('Zhuang, Chuang', 'Saɯ cueŋƅ, Saw cuengh', 'za', 'zha', 'zha', 'zha + 16'),
        array('Zulu', 'isiZulu', 'zu', 'zul', 'zul', 'zul'),
    );

    public function __construct(string $language_dir = '', string $fallback_locale = '', string $language_param = '')
    {
        $this->language_dir = $language_dir ?: 'languages';
        $this->fallback_locale = $fallback_locale ?: 'en';
        $this->language_param = $language_param ?: 'lang';
    }

    /**
     * Get language directory.
     * 
     * @return string
     */
    private function getLanguageDir() : string
    {
        return dirname(__FILE__) . '/' . trim($this->language_dir, '/') . '/';
    }

    /**
     * Get all locales.
     * 
     * @return array
     */
    public function getAllLocales() : array
    {
        $files = glob($this->getLanguageDir() . '*.json');

        if (empty($files)) {
            $locales[] = $this->fallback_locale;
        } else {
            foreach ($files as &$file) {
                $locales[] = basename($file, '.json');
            }
        }

        return $locales;
    }

    /**
     * Get the detected locale.
     *
     * @return string
     */
    public function getDetectedLocale() : string
    {
        return strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)) ?: '';
    }

    /**
     * Get the preferred locale.
     * 
     * @return string
     */
    public function getPreferredLocale() : string
    {
        return filter_input(INPUT_GET, $this->language_param, FILTER_SANITIZE_SPECIAL_CHARS) ?: '';
    }

    /**
     * Get the locale being used.
     *
     * @return string
     */
    public function getLocale() : string
    {
        $locale = $this->getPreferredLocale() ?: $this->getDetectedLocale();

        return $this->isSupportedLocale($locale) ? $locale : $this->fallback_locale;
    }

    /**
     * Check if locale is supported.
     *
     * @param string $locale
     * @return boolean
     */
    public function isSupportedLocale(string $locale = '') : bool
    {
        $locales = $this->getAllLocales();

        return in_array($locale, $locales) ?? false;
    }

    /**
     * Get the proper native language name.
     *
     * @param string $locale
     * @return string
     */
    public function getLocaleNative(string $locale) : string
    {
        $locale = strtolower($locale);

        foreach (self::$iso_639 as $locales) {
            if ($locales[2] == $locale) {
                $native = explode(',', $locales[1]);
                $native = ucfirst(trim($native[0]));
                break;
            }
        }

        return $native;
    }

    /**
     * Translate the given message.
     *
     * @param string $key
     * @param string $locale
     * @return string
     */
    public function translate(string $key, string $locale = '') : string
    {
        $locale = $locale ?: $this->getLocale();

        $this->load($locale);

        $line = $this->loaded[$locale][$key] ?? '';

        if (! empty($line)) {
            return $line;
        }

        return $key;
    }

    /**
     * Load a specified locale file.
     *
     * @param string $locale
     * @return void
     */
    public function load(string $locale) : void
    {
        if ($this->isLoaded($locale)) {
            return;
        }

        $file = file_get_contents($this->getLanguageDir() . $locale .'.json');

        $lines = json_decode($file, true);

        $this->loaded[$locale] = $lines;
    }

    /**
     * Determine if the given locale has been loaded.
     *
     * @param  string  $locale
     * @return bool
     */
    public function isLoaded(string $locale) : bool
    {
        return isset($this->loaded[$locale]);
    }

    /**
     * Build new query string for URL.
     *
     * @param string $locale
     * @return string
     */
    public function buildQueryString(string $locale) : string
    {
        $query = array_merge($_GET, [ $this->language_param => $locale]);
        return '?' . http_build_query($query);
    }

}