<?php

    class String
    {
        protected static $_short_words = array('a','and','the','an','it','is','with','can','of','why','not','.','s');
        protected static $_symbols = array("'",":",'"','&','/','(',')','{','}','[',']',',','...');

        /** Strip punctuation marks from string provided
         * @param string $text: String from which punctuation marks to be striped
         *
         * @return void
         */
        public static function stripPunctuation( $text )
        {
            $urlbrackets    = '\[\]\(\)';
            $urlspacebefore = ':;\'_\*%@&?!' . $urlbrackets;
            $urlspaceafter  = '\.,:;\'\-_\*@&\/\\\\\?!#' . $urlbrackets;
            $urlall         = '\.,:;\'\-_\*%@&\/\\\\\?!#' . $urlbrackets;

            $specialquotes  = '\'"\*<>';

            $fullstop       = '\x{002E}\x{FE52}\x{FF0E}';
            $comma          = '\x{002C}\x{FE50}\x{FF0C}';
            $arabsep        = '\x{066B}\x{066C}';
            $numseparators  = $fullstop . $comma . $arabsep;

            $numbersign     = '\x{0023}\x{FE5F}\x{FF03}';
            $percent        = '\x{066A}\x{0025}\x{066A}\x{FE6A}\x{FF05}\x{2030}\x{2031}';
            $prime          = '\x{2032}\x{2033}\x{2034}\x{2057}';
            $nummodifiers   = $numbersign . $percent . $prime;

            return preg_replace(
                array(
                    // Remove separator, control, formatting, surrogate,
                    // open/close quotes.
                    '/[\p{Z}\p{Cc}\p{Cf}\p{Cs}\p{Pi}\p{Pf}]/u',
                    // Remove other punctuation except special cases
                    '/\p{Po}(?<![' . $specialquotes .
                    $numseparators . $urlall . $nummodifiers . '])/u',
                    // Remove non-URL open/close brackets, except URL brackets.
                    '/[\p{Ps}\p{Pe}](?<![' . $urlbrackets . '])/u',
                    // Remove special quotes, dashes, connectors, number
                    // separators, and URL characters followed by a space
                    '/[' . $specialquotes . $numseparators . $urlspaceafter .
                    '\p{Pd}\p{Pc}]+((?= )|$)/u',
                    // Remove special quotes, connectors, and URL characters
                    // preceded by a space
                    '/((?<= )|^)[' . $specialquotes . $urlspacebefore . '\p{Pc}]+/u',
                    // Remove dashes preceded by a space, but not followed by a number
                    '/((?<= )|^)\p{Pd}+(?![\p{N}\p{Sc}])/u',
                    // Remove consecutive spaces
                    '/ +/',
                ),
                ' ',
                $text );
        }

        /* takes the input, scrubs bad characters */
        public static function generateSEOString($input, $replace = '-', $remove_words = true)
        {
            $input = html_entity_decode( strtolower($input), ENT_NOQUOTES, "UTF-8" );

            //make it lowercase, remove punctuation, remove multiple/leading/ending spaces
            $return = trim(@ereg_replace(' +',' ', preg_replace('[^\pL\pN\pP]','', self::stripPunctuation($input))));

            //remove words, if not helpful to seo
            //i like my defaults list in removeShortWords(), so I wont pass that array
            if($remove_words) { $return = self::removeShortWords($return, $replace); }

            //convert the spaces to whatever the user wants
            //usually a dash or underscore..
            //...then return the value.
            return str_replace(' ',$replace, $return);
        }

        /* takes an input, scrubs unnecessary words */
        public static function removeShortWords($input, $replace, $unique_words = true)
        {
            //separate all words based on spaces
            $input_array = explode(' ',$input); //print_r($input_array);
            $input_array = array_splice($input_array, 0, 15);

            //create the return array
            $return = array();

            //loops through words, remove bad words, keep good ones
            foreach($input_array as $word)
            {
                //if it's a word we should add...
                if(!in_array($word, self::$_short_words) && ($unique_words ? !in_array($word,$return) : true))
                {
                    $return[] = str_replace(self::$_symbols, "", $word);
                }
            }

            //return good words separated by dashes
            return implode($replace,$return);
        }

        /** Update HTML output of the content by replacing template tags
         *
         * @param string $html : HTML content
         * @param array $data : Key Value pair to replace strings in content
         * @return string : Returns updated HTML content
         */
        public static function updateHTML($html, $data = array()) {
            preg_match_all("/{[^}]*}/", $html, $matches);
            if(sizeof($matches) > 0) {
                foreach($matches[0] as $match) {
                    $match = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $match);

                    if(isset($data[$match])) {
                        $html = str_replace("{".$match."}", $data[$match], $html);
                    }

                    if(defined(strtoupper($match))) {
                        $html = str_replace("{".$match."}", constant(strtoupper($match)), $html);
                    }
                }
            }

            return $html;
        }

        /** Generate random code for length of string provided
         *
         * @param int $length : Length of the string to be generated
         * @return string : Returns random code for the provided length
         */
        public static function generateCode($length = 8){
            $chars = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@#%$*';
            $count = mb_strlen($chars);
            for($i = 0, $result = ''; $i < $length; $i++) {
                $index = rand(0, $count - 1);
                $result .= mb_substr($chars, $index, 1);
            }
            return $result;
        }

        /** Generate hash of string using SHA1
         *
         * @param string $str : String to generate hash
         * @return string : returns SHA1 hash of the string with salt
         */
        public static function getHash($str) {
            return sha1(PASSWORD_HASH.$str);
        }

        /** Get number in words for provided number value
         * @param int $number: Number to get in words
         *
         * @return bool|null|string : Returns words output of numeric value provided on success,
         *                          otherwise returns false or null
         */
        public static function numberToWords($number) {

            $hyphen      = '-';
            $conjunction = ' and ';
            $separator   = ', ';
            $negative    = 'negative ';
            $decimal     = ' point ';
            $dictionary  = array(
                0                   => 'zero',
                1                   => 'one',
                2                   => 'two',
                3                   => 'three',
                4                   => 'four',
                5                   => 'five',
                6                   => 'six',
                7                   => 'seven',
                8                   => 'eight',
                9                   => 'nine',
                10                  => 'ten',
                11                  => 'eleven',
                12                  => 'twelve',
                13                  => 'thirteen',
                14                  => 'fourteen',
                15                  => 'fifteen',
                16                  => 'sixteen',
                17                  => 'seventeen',
                18                  => 'eighteen',
                19                  => 'nineteen',
                20                  => 'twenty',
                30                  => 'thirty',
                40                  => 'fourty',
                50                  => 'fifty',
                60                  => 'sixty',
                70                  => 'seventy',
                80                  => 'eighty',
                90                  => 'ninety',
                100                 => 'hundred',
                1000                => 'thousand',
                1000000             => 'million',
                1000000000          => 'billion',
                1000000000000       => 'trillion',
                1000000000000000    => 'quadrillion',
                1000000000000000000 => 'quintillion'
            );

            if (!is_numeric($number)) {
                return false;
            }

            if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                // overflow
                trigger_error(
                    'numberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                    E_USER_WARNING
                );
                return false;
            }

            if ($number < 0) {
                return $negative . numberToWords(abs($number));
            }

            $string = $fraction = null;

            if (strpos($number, '.') !== false) {
                list($number, $fraction) = explode('.', $number);
            }

            switch (true) {
                case $number < 21:
                    $string = ucwords($dictionary[$number]);
                    break;
                case $number < 100:
                    $tens   = ((int) ($number / 10)) * 10;
                    $units  = $number % 10;
                    $string = ucwords($dictionary[$tens]);
                    if ($units) {
                        $string .= $hyphen . ucwords($dictionary[$units]);
                    }
                    break;
                case $number < 1000:
                    $hundreds  = $number / 100;
                    $remainder = $number % 100;
                    $string = ucwords($dictionary[$hundreds]) . ' ' . ucwords($dictionary[100]);
                    if ($remainder) {
                        $string .= $conjunction . numberToWords($remainder);
                    }
                    break;
                default:
                    $baseUnit = pow(1000, floor(log($number, 1000)));
                    $numBaseUnits = (int) ($number / $baseUnit);
                    $remainder = $number % $baseUnit;
                    $string = numberToWords($numBaseUnits) . ' ' . ucwords($dictionary[$baseUnit]);
                    if ($remainder) {
                        $string .= $remainder < 100 ? $conjunction : $separator;
                        $string .= numberToWords($remainder);
                    }
                    break;
            }

            if (null !== $fraction && is_numeric($fraction)) {
                $string .= $conjunction;
                $string .= $fraction."/100";
            }

            return $string;
        }
    }