<?php 

require_once("core/Helpers.php");


class Upload {

	const MAX_SIZE ="150000"; 

	const TARGET = "/home/ali/partage_photos";
     
    private static $file_name; 
    
    private static $file_full_name;

    private static $file_type; 
     
    private static $file_size; 
     
    private static $file_tmp; 
     
    private static $file_errors; 
     
    private static $directory; 


    private static $allowed_types=array(
                        
								        "image"       => array("image/jpg",              
								                               "image/jpeg", 
								                               "image/png", 
								                               "image/gif"),
								                                
								        "multipart"   => array("multipart/x-gzip", 
								                               "multipart/x-zip"), 
								        
								        "text"        => array("text/plain", 
								                               "text/rtf", 
								                               "text/richtext", 
								                               "text/xml"),

								        "video"       => array("video/*"),
								        
								        "audio"       => array("audio/*"),


								        "application" => array("application/arj", 
								                               "application/excel", 
								                               "application/gnutar", 
								                               "application/mspowerpoint", 
								                               "application/msword", 
								                               "application/octet-stream", 
								                               "application/onenote", 
								                               "application/pdf", 
								                               "application/plain", 
								                               "application/postscript", 
								                               "application/powerpoint", 
								                               "application/rar", 
								                               "application/rtf", 
								                               "application/vnd.ms-excel", 
								                               "application/vnd.ms-excel.addin.macroEnabled.12", 
								                               "application/vnd.ms-excel.sheet.binary.macroEnabled.12", 
								                               "application/vnd.ms-excel.sheet.macroEnabled.12", 
								                               "application/vnd.ms-excel.template.macroEnabled.12", 
								                               "application/vnd.ms-office", 
								                               "application/vnd.ms-officetheme", 
								                               "application/vnd.ms-powerpoint", 
								                               "application/vnd.ms-powerpoint.addin.macroEnabled.12", 
								                               "application/vnd.ms-powerpoint.presentation.macroEnabled.12", 
								                               "application/vnd.ms-powerpoint.slide.macroEnabled.12", 
								                               "application/vnd.ms-powerpoint.slideshow.macroEnabled.12", 
								                               "application/vnd.ms-powerpoint.template.macroEnabled.12", 
								                               "application/vnd.ms-word", 
								                               "application/vnd.ms-word.document.macroEnabled.12", 
								                               "application/vnd.ms-word.template.macroEnabled.12", 
								                               "application/vnd.oasis.opendocument.chart", 
								                               "application/vnd.oasis.opendocument.database", 
								                               "application/vnd.oasis.opendocument.formula", 
								                               "application/vnd.oasis.opendocument.graphics", 
								                               "application/vnd.oasis.opendocument.graphics-template", 
								                               "application/vnd.oasis.opendocument.image", 
								                               "application/vnd.oasis.opendocument.presentation", 
								                               "application/vnd.oasis.opendocument.presentation-template", 
								                               "application/vnd.oasis.opendocument.spreadsheet", 
								                               "application/vnd.oasis.opendocument.spreadsheet-template", 
								                               "application/vnd.oasis.opendocument.text", 
								                               "application/vnd.oasis.opendocument.text-master", 
								                               "application/vnd.oasis.opendocument.text-template", 
								                               "application/vnd.oasis.opendocument.text-web", 
								                               "application/vnd.openofficeorg.extension", 
								                               "application/vnd.openxmlformats-officedocument.presentationml.presentation", 
								                               "application/vnd.openxmlformats-officedocument.presentationml.slide", 
								                               "application/vnd.openxmlformats-officedocument.presentationml.slideshow", 
								                               "application/vnd.openxmlformats-officedocument.presentationml.template", 
								                               "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", 
								                               "application/vnd.openxmlformats-officedocument.spreadsheetml.template", 
								                               "application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
								                               "application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
								                               "application/vnd.openxmlformats-officedocument.wordprocessingml.template", 
								                               "application/vocaltec-media-file", 
								                               "application/wordperfect", 
								                               "application/x-bittorrent", 
								                               "application/x-bzip", 
								                               "application/x-bzip2", 
								                               "application/x-compressed", 
								                               "application/x-excel", 
								                               "application/x-gzip", 
								                               "application/x-latex", 
								                               "application/x-midi", 
								                               "application/xml", 
								                               "application/x-msexcel", 
								                               "application/x-rar-compressed", 
								                               "application/x-rtf", 
								                               "application/x-shockwave-flash", 
								                               "application/x-sit", 
								                               "application/x-stuffit", 
								                               "application/x-troff-msvideo", 
								                               "application/x-zip", 
								                               "application/x-zip-compressed", 
								                               "application/zip", ),

								        );


    private static function generate_name($file) 
    {
    	$allowed = false;
    	$error = "";
        if(is_uploaded_file($file['tmp_name'])) 
        { 
	    	self::$file_tmp = $file['tmp_name'];
	    	$radical = Helpers::RandomString();
	    	$type =  explode('.', $file['name'])[1];
	        self::$file_name = $radical.'.'.$type; 
	        self::$file_full_name = self::TARGET . self::$directory.'/'.self::$file_name;
    	} else $error = "File is not uploaded properly please try again";

        return array('allowed' => $allowed, 'name' => self::$file_name, 'error' => $error ); 
    } 

    private static function is_allowed_type($filetype,string $category) 
    { 
         
    	$allowed = false;
    	$error = "";
        if(in_array($filetype , self::$allowed_types[$category])) 
        { 
        	$allowed = true;
            self::$file_type = $filetype; 
        } 
        else $error = 'File Type Is Not An Allowed Type Please Only Upload Files that are Allowed Types'; 
        
        return array('allowed' => $allowed, 'type' => self::$file_type, 'error' => $error ); 
    } 
     
    private static function is_allowed_size($filesize) 
    { 

    	$allowed = false;
    	$error = "";

        if($filesize < self::MAX_SIZE) 
        { 
            self::$file_size = $filesize; 
        } 
         
        elseif($filesize > self::MAX_SIZE ) 
        { 
            $error = 'Error file size is to large'; 
        } 
         
        return array('allowed' => $allowed, 'size' => self::$file_size, 'error' => $error );  
    } 


     
    private static function upload_dir($destination) 
    { 
    	$allowed = false;
    	$error = "";

        if($destination == 'photos' && file_exists('photos')) 
        { 
            self::$directory = '/photos'; 
        } 
         
        elseif($destination != 'photos' && file_exists($destination)) 
        { 
            self::$directory = $destination; 
        } 
         
        elseif($destination !='defualt' && !file_exists($destination)) 
        { 
            $error = 'Fatal Upload Error Directory Does not Exsist'; 
        } 
         
        return array('allowed' => $allowed, 'directory' => self::$directory, 'error' => $error );  
         
    } 
     

	public static function check_upload($errors)
	{
		
		$failed = false;
		$error = '';

		if ($errors)
		{
			$failed = true;
			switch ($errors)
			{

		    case UPLOAD_ERR_INI_SIZE:
	           	$error = "Le fichier depasse la limite autorisee par le serveur (fichier php.ini).";
	           	break;
	        case UPLOAD_ERR_FORM_SIZE:
	           	$error = "Le fichier depasse la limite autorisee dans le formulaire HTML.";
	           	break;
	        case UPLOAD_ERR_PARTIAL:
	           	$error = "L'envoi du fichier a ete interrompu pendant le transfert.";
	          	break;
	        case UPLOAD_ERR_NO_FILE:
	           	$error = "Le fichier que vous avez envoye a une taille nulle.";
	         	break;
		 	case UPLOAD_ERR_NO_TMP_DIR:
		 		$error = "Pas de repertoire temporaire defini.";
		 		break;
		 	case UPLOAD_ERR_CANT_WRITE:
		 		$error = "Ecriture du fichier impossible.";
		 	default:
				$error = "Erreur inconnue.";
			}
		}

		return  array( 'failed' => $failed, 'error' => $error );
	}


	 public static function upload_file($file) {

	 	$errors = self::check_upload($file['error']);

	 	if ($errors['failed'] == false)
	 	{

	 		$allowed_type = self::is_allowed_type($file['type'],"image");

	 		$allowed_size = self::is_allowed_size($file['size']);

	 		$upload_dir = self::upload_dir('photos');

	 		$file_name = self::generate_name($file);

	 		if ($allowed_type['allowed'] == false) 
	 		{
	 			$errors['failed'] = true;
	 			$errors['error']  = $allowed_type['error'];
	 		}			 
			if ($allowed_size['allowed'] == false) 
			{
				$errors['failed'] = true;
				$errors['error'] = $allowed_size['error'];
			}
			if ($upload_dir['allowed'] == false) 
			{
				$errors['failed'] = true;
				$errors['error'] = $upload_dir['error'];
			}
			if($file_name['allowed'] == false) 
			{
				$errors['failed'] = true;
				$errors['error'] = $upload_dir['error'];
			}

			if ($errors != null)
			{
				 move_uploaded_file(self::$file_tmp ,self::$file_full_name); 
				 return true;
			}

			else return $errors;   

	 	
	 	} else return $errors;

	 }


	 public static function get_file_name()
	 {
	 	return self::$file_name;
	 }

	 public static function get_target_name()
	 {
	 	return self::$directory.'/'.self::$file_name;
	 }
	

}

?>