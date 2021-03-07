<?php 

@session_start();
require_once("../../../includes/db.php");
if(!isset($_SESSION['seller_user_name'])){
	echo "<script>window.open('login','_self')</script>";	
}

$login_seller_user_name = $_SESSION['seller_user_name'];
$select_login_seller = $db->select("sellers",array("seller_user_name" => $login_seller_user_name));
$row_login_seller = $select_login_seller->fetch();
$login_seller_id = $row_login_seller->seller_id;

function removeJava($html){
	$attrs = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
  $dom = new DOMDocument;
  // @$dom->loadHTML($html);
  @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
  $nodes = $dom->getElementsByTagName('*');//just get all nodes, 
  foreach($nodes as $node){
    foreach ($attrs as $attr) { 
    	if ($node->hasAttribute($attr)){  $node->removeAttribute($attr);  } 
    }
  }
return strip_tags($dom->saveHTML(),"<div><img>");
}

$call_id = $input->post('call_id');
$message = removeJava($_POST['message']);

@$file = $_FILES["file"]["name"];
@$file_tmp = $_FILES["file"]["tmp_name"];

$allowed = array('jpeg','jpg','gif','png','tif','avi','mpeg','mpg','mov','rm','3gp','flv','mp4','zip','rar','mp3','wav','xlsx','cad','pdf','doc','docx','ppt','pptx','pps','ppsx','odt','xls','xlsx','m4a','txt');
	
$file_extension = pathinfo($file, PATHINFO_EXTENSION);

if(!in_array($file_extension,$allowed) & !empty($file)){
	
	echo "<script>alert('Your File Format Extension Is Not Supported.')</script>";
	
}else{

	if(!empty($file)){
		$file = pathinfo($file, PATHINFO_FILENAME);
		$file = $file."_".time().".$file_extension";
		move_uploaded_file($file_tmp, "../chat_files/$file");
	}else{ $file = ""; }

	$insert_message = $db->insert("video_call_messages",array("call_id" => $call_id,"sender_id" => $login_seller_id,"message" => $message,"file" => $file,"status"=>"unread"));

	if($insert_message){
		
	}

}

?>