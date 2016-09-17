<?php 
	include_once('phpmailer/class.phpmailer.php');
	
	class emailer extends PHPMailer  { 
		
		var $_template_dir = 'templates/';
		var $mail;
		
		function sendMail($template, $data = array()) {
			$this->mail = new PHPMailer();
			if(sizeof($data) > 0) {
				$updated = $this->updateTemplate($template, $data); //_e($updated); exit;
			}
			
			// Set basic parameters to send email
			$this->mail->IsSMTP();
			$this->mail->SMTPDebug = 1;
			$this->mail->SMTPAuth = true;
			$this->mail->Host = MAIL_HOST;
			$this->mail->Port = MAIL_PORT;
			$this->mail->Username = MAIL_FROM;
			$this->mail->Password = MAIL_PASSWORD;
			$this->mail->Debugoutput = 'html';

			$this->mail->SetFrom(MAIL_FROM, MAIL_NAME);

			if(isset($data['email']) && !empty($data['email'])) {
				$to_array = explode(",", $data['email']);

				foreach($to_array as $to_email) {
					$this->mail->AddAddress($to_email);
				}
			}
			
			$h2t = new html2text($updated);
			$alt_msg = $h2t->get_text();

			$this->mail->AltBody = $alt_msg;
			$this->mail->Subject = $data['subject'];
			$this->mail->MsgHTML($updated);

			if($this->mail->Send()) {
				return true;
			} else {
				return false;
			}
		}
		
		function updateTemplate($template, $data) {

			include_once('classes/class.html2text.php');
			$html = file_get_contents(SITE_PATH.'lib/templates/'.$template);

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
	}
?>