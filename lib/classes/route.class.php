<?php

    class Route
    {
        //TRAP REQUESTS ARRAY:
        public static $request;
        private static $param;


        public static function matchURI($uri = null) {
			$uri = (!$uri) ? $_SERVER['PATH_INFO'] : $uri;
            $uri = (!$uri) ? '/' : rtrim($uri,"\/");
            if(!empty(self::$request)) {
                $count=count(self::$request);
                for($i=0; $i<$count; ++$i) {
                    foreach(self::$request[$i] as $k => $v) {
                        if (is_array($v) and $k !== 'param') {
                            self::$param = self::$request[$i]['param'];
                            $v['request'] = preg_replace_callback("/\<(?P<key>[0-9a-z_]+)\>/", 'Route::_replacer', str_replace(")",")?", $v['request'])); //print_r($v);
                            $rulleTemp = array_merge((array)self::$request[$i], (array)$v);
                            if(($t = self::_reportRulle($rulleTemp, $uri)))
                                return $t;
                        }
                    }
                }

            } else return array();
        }

        private static function _replacer($matches) {
            if(isset(self::$param[$matches['key']])) {
                return "(?P<".$matches['key'].">".self::$param[$matches['key']].")";
            } else return "(?P<".$matches['key'].">"."([^/]+)".")";
        }

        private static function _reportRulle($ini_array, $uri) {
            if(is_array($ini_array) and $uri) { //echo "#^".$ini_array['request']."$#"; echo $uri;
                if(preg_match("#^".$ini_array['request']."$#", $uri, $match)){ //print_r($match);
                    $r = array_merge((array)$ini_array, (array)$match);
                    foreach($r as $k => $v)
                        if((int)$k OR $k == 'param' OR $k == 'request')
                            unset($r[$k]);
                    return $r;
                }
            }
        }
        /** =================================================================== **/
    }