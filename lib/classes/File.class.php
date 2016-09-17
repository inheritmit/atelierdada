<?php

    class File
    {

        protected static $_mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

                // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

                // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

                // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

                // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

                // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',


                // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        protected static $_templates = array();

        protected static $_allowed_types = array(
            'image' => array('image/jpeg', 'image/pjpeg' , 'image/png'),
            'file' => array('application/pdf', 'application/rtf', 'application/msword' , 'application/vnd.ms-powerpoint'),
        );

        /** Check image in provided location and display
         *
         * @param string $image_name : Image name to be checked
         * @param string $default_image_path : Default image path to be displayed if image is not available
         * @return string : Path of the image to be displayed
         */
        public static function checkImageLocation($image_name, $default_image_path = 'images/default-image-551.jpg') {
            if(!empty($image_name) && file_exists(UPLOAD_PATH.'content/'.$image_name)) {
                return UPLOAD_URL.'content/'.$image_name;
            } else {
                return $GLOBALS['theme_url'].$default_image_path;
            }
        }

        /** Get mime type of the file from filename
         *
         * @param string $filename : Name of the file
         * @return string : Returns mime type of the file if available,
         *                otherwise return blank string
         */
        public static function getMime($filename){

            // mode 0 = full check
            // mode 1 = extension check only

            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            return (isset(self::$_mime_types[$ext]) ? self::$_mime_types[$ext] : '');
        }

        /** Get all templates defined in provided directory
         *
         * @param string $dir : Directory to get all templates
         * @return void
         */
        public static function getPageTemplates($dir) {

            if ($handle = opendir($dir)) {
                /* This is the correct way to loop over the directory. */
                while (false !== ($file = readdir($handle))) {
                    if(in_array($file, array('.', '..'))) continue;

                    if(is_dir($dir.$file)) self::getPageTemplates($dir.$file.'/');

                    if(is_dir($dir.$file)) continue;

                    $template_data = implode( '', file( $dir.$file ));
                    preg_match( "|Template Name:(.*)|i", $template_data, $name );
                    preg_match( "|Description:(.*)|i", $template_data, $description );

                    if(!isset($name[1])) continue;

                    $name = $name[1];
                    $description = $description[1];

                    if (!empty($name)) {
                        self::$_templates[trim($name)] = basename($dir.$file);
                    }
                }

                closedir($handle);
            }
        }

        /** Get Template dropdown from directory. Set any template selected from provided default variable
         *
         * @param string $dir : Directory to get all templates
         * @param string $default : Template name to make selected
         * @return string : Returns html string of templates dropdown
         */
        public static function getTemplateDropDown($dir, $default = '') {

            self::getPageTemplates($dir);

            $html = '<select name="page_template" id="page_template" class="form-control"><option value="" selected> [ Select ] </option>';
            if(sizeof(self::$_templates) > 0) {
                foreach (self::$_templates as $name => $template) {
                    if ($default == $template)
                        $selected = " selected='selected'";
                    else
                        $selected = '';
                    $html .= '<option value="' . $template . '"'.$selected.'>'.$name.'</option>';
                }
            }
            $html .= '</select>';

            echo $html;
        }

        /** Check if provided file type is allowed for provided type
         *
         * @param string $file_type : Mime type of the file
         * @param string $type : Type of file to be check
         * @return bool : Returns true if allowed, otherwise returns false
         */
        public static function isAllowedType($file_type, $type = 'image') {
            return in_array($file_type, self::$_allowed_types[$type]);
        }
    }