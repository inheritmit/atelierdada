<?php

    class Date
    {
        /** Get timestamp from XL date provided
         * @param int $date: XL date
         *
         * @return int: Returns timestamp on success for provided XL date
         */
        public static function xlDateToDate($date){
            $php_date = $date-25569; //to offset to Unix epoch
            return strtotime("+$php_date days", mktime(0,0,0,1,1,1970));
        }

        /** Get time ago sting from date provided
         * @param int $timestamp: Time stamp of the date
         *
         * @return string: Returns time ago string for the date
         */
        public static function timeAgo($timestamp) {
            $stf = 0;
            $cur_time = time();
            $diff = $cur_time - $timestamp;
            $phrase = array('second', 'minute', 'hour', 'day');
            $length = array(1, 60, 3600, 86400);

            for($i = (sizeof($length)-1); ($i >= 0) && (($no = $diff/$length[$i]) <= 1); $i--);

            if($i < 0) $i=0;
            $time = $cur_time  - ($diff%$length[$i]);

            if(floor($no) == 1 && $phrase[$i] == 'day') {
                $value = 'on Yesterday';
            } else if(floor($no) > 1 && floor($no) < 8 && $phrase[$i] == 'day') {
                $value = 'on '.date('l', $timestamp);
            } else if(floor($no) >= 8 && $phrase[$i] == 'day') {
                $value = 'on '.date('F j', $timestamp);
            } else {
                $no = floor($no);
                if($no <> 1)
                    $phrase[$i] .= 's';

                $value = sprintf("%d %s%p", $no, $phrase[$i], (($no <> 1) ? 's' : '')).' ago';
            }

            if(($stf == 1) && ($i >= 1) && (($cur_tm-$time) > 0)) $value .= time_ago($time);

            return $value;
        }

        /** Format/check provided date into MySQL date
         * @param date $date : Date to be formatted
         * @param string $format : Current format of the date
         * @param string $type : Type of function wanted
         *                     get: provides date in MySQL format
         *                     check: validates the provided date
         * @return date : Returns date in MySQL format on success
         * @throws exception of invalid date
         */
        public static function mysqlDate($date, $format = 'YYYY-MM-DD', $type = 'get') {
            $format = strtoupper($format);
            switch($format)
            {
                case 'YYYY/MM/DD':
                case 'YYYY-MM-DD':
                case 'YYYY.MM.DD':
                    $y = substr( $date, 0, 4 );
                    $m = substr( $date, 5, 2 );
                    $d = substr( $date, 8, 2 );
                    break;

                case 'YYYY/DD/MM':
                case 'YYYY-DD-MM':
                case 'YYYY.DD.MM':
                    $y = substr( $date, 0, 4 );
                    $m = substr( $date, 8, 2 );
                    $d = substr( $date, 5, 2 );
                    break;

                case 'DD-MM-YYYY':
                case 'DD/MM/YYYY':
                case 'DD.MM.YYYY':
                    $y = substr( $date, 6, 4 );
                    $m = substr( $date, 3, 2 );
                    $d = substr( $date, 0, 2 );
                    break;

                case 'MM-DD-YYYY':
                case 'MM/DD/YYYY':
                case 'MM.DD.YYYY':
                    $y = substr( $date, 6, 4 );
                    $m = substr( $date, 0, 2 );
                    $d = substr( $date, 3, 2 );
                    break;

                case 'YYYYMMDD':
                    $y = substr( $date, 0, 4 );
                    $m = substr( $date, 4, 2 );
                    $d = substr( $date, 6, 2 );
                    break;

                case 'YYYYDDMM':
                    $y = substr( $date, 0, 4 );
                    $d = substr( $date, 4, 2 );
                    $m = substr( $date, 6, 2 );
                    break;
                case 'DDMMYYYY':
                    $y = substr( $date, 0, 2 );
                    $d = substr( $date, 2, 2 );
                    $m = substr( $date, 4, 4 );
                    break;

                default:
                    throw new Exception( "Invalid Date Format" );
            }

            if($type == 'get') {
                return $y."-".$m."-".$d;
            } else {
                return checkdate($m, $d, $y);
            }
        }
    }