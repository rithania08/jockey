<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Frontend extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('frontend_model');
        $this->load->model('email_model');
		
		$this->global['tis'] = $this;
		
		$this->global['pageTitle'] = "Homepage";
		
		$this->global['loading'] = 0;
    }
    
    public function index()
    {
        $this->global['pageTitle'] = "Homepage";
        
        $this->loadPage("index", $this->global);
    }
	
	function slugify($text)
	{
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, '-');
		$text = preg_replace('~-+~', '-', $text);
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}
	
	function send_mail()
	{
		$data['result'] = 0;
		if(isset($_POST['Subject']))
		{		
			if($_POST['Extra'] == '')
			{
			    $info['subject'] = $_POST['Subject'];
				$error = 0;
				
				$from = "no-reply@jockey.com";
				$to = "talkto@jockey.com";
				$cc = "bdm@jockey.com";
				
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				$headers .= "From: " . $from . "\r\n" .
				"CC: " . $cc;
				
				$subject = $_POST['Subject'];
				
				$msg = '
				<html xmlns="http://www.w3.org/1999/xhtml">
					<table width="100%" cellpadding="12" cellspacing="0" border="0"><tbody><tr><td><div style="overflow: hidden;"><font size="-1"><font color="#550055"><p style="background:#00aae7;padding:10px 15px;font-weight:bold;font-size:16px;overflow:hidden;width:300px;text-align:center;color:#fff;border-radius:10px 10px 0px 0px;margin:0px">' . $subject . '</p></font><table cellpadding="0" cellspacing="0" border="0" style="width:330px;overflow:hidden;border-bottom:1px solid #797979;border-right:1px solid #797979;border-left:1px solid #797979">
					<tbody>';
				
				foreach($_POST as $key => $value)
				{
					if($this->check_text($value) == FALSE)
					{
						$error = 1;
					}
					if($key != 'Subject' && $key != 'Extra')
					{
						if($key != 'Services')
						{
						    $info['other_details'] .= $key . "=" . $val . " and ";
							$msg .= '<tr>
								<td width="119" style="text-align:left;padding:10px 10px;border-bottom:1px solid #797979">' . $key . '</td>
								<td width="36" style="border-bottom:1px solid #797979">:</td>
								<td width="175" style="border-bottom:1px solid #797979">' . $value . '</td>
							</tr>';
						}
						else
						{
							$arval = "";
							foreach($_POST[$key] as $val)
							{
								$arval .= $val . ", ";
							}
							$info['other_details'] .= $key . "=" . $arval . " and ";
							$msg .= '<tr>
								<td width="119" style="text-align:left;padding:10px 10px;border-bottom:1px solid #797979">' . $key . '</td>
								<td width="36" style="border-bottom:1px solid #797979">:</td>
								<td width="175" style="border-bottom:1px solid #797979">' . $arval . '</td>
							</tr>';
						}
					}
				}
				
				$msg .= '</tbody></table>
					</font></div></td></tr></tbody></table>
				</html>';
				
				if($error == 0)
				{ 
				    $this->frontend_model->insert("tbl_contact", $info);
					mail($to,$subject,$msg,$headers);
					$data['result'] = 1;
					$data['msg'] = "Thanks for contacting us. Our representative will reach you soon.";
				}
			}
		}
		
		echo json_encode($data);
	}
	function check_text($text)
	{
		$bad_words = array(
			'sex',
			's e x',
			'porn',
			'p o r n',
			'blonde',
			'b l o n d e',
			'dildo',
			'd i l d o',
			'boob',
			'b o o b',
			'nipple',
			'n i p p l e',
			'xnxx',
			'x n x x',
			'xxx',
			'x x x',
			'fuck',
			'f u c k',
			'suck',
			's u c k',
			'nude',
			'n u d e',
			'horny',
			'h o r n y',
			'adult',
			'a d u l t',
			'pussy',
			'p u s s y',
			'ass',
			'a s s'
		);
			
		if($this->strposa(strtolower($text), $bad_words, 0) == TRUE) 
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}

	function strposa($haystack, $needles=array(), $offset=0) {
		$chr = array();
		foreach($needles as $needle) {
			$res = strpos($haystack, $needle, $offset);
			if ($res !== false) $chr[$needle] = $res;
		}
		if(empty($chr)) 
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

?>