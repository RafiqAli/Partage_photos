<?php 

require_once("core/Helpers.php");


class Upload {

	const MAX_SIZE ="10000000"; 

	const TARGET = "/home/ali/partage_photos/";

	const LOCAL_TARGET = "public/ressources/users/";

	const MAX_NAME_SIZE = 255;
     
    private static $user_file_name;
     
    private static $file_name; 
    
    private static $file_full_name;

    private static $file_type; 
     
    private static $file_size; 
     
    private static $file_tmp; 
     
    private static $file_errors; 
     
    private static $directory; 

    private static $errors =  array('failed' => false, 'error' => "" );


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



	public static function pre_check_upload($file_error)
	{
		$failed = false;
		$error = '';
		if ($file_error)
		{
			$failed = true;
			switch ($errors)
			{
		    case UPLOAD_ERR_INI_SIZE:   $error = "File exeeds the limit allowed by the server (file php.ini).";
	        case UPLOAD_ERR_FORM_SIZE:  $error = "File exeeds the limit allowed by HTML form.";
	        case UPLOAD_ERR_PARTIAL:    $error = "The transfert of file has been disconnected.";
	        case UPLOAD_ERR_NO_FILE:    $error = "File size is null.";
		 	case UPLOAD_ERR_NO_TMP_DIR: $error = "No temporary directory has been set.";
		 	case UPLOAD_ERR_CANT_WRITE: $error = "Can't write on file.";
		 	default: $error = "Unknown error.";
			}
		}

		return  array( 'failed' => $failed, 'error' => $error );
	}

    private static function generate_name($file) 
    {

	    	self::$file_tmp = $file['tmp_name'];
	    	$radical = Helpers::RandomString();
	    	$type =  explode('/', $file['type'])[1];
	        self::$file_name = $radical.'.'.$type; 
	        self::$file_full_name = self::TARGET . self::$directory.'/'.self::$file_name;

	        echo "full name " . self::$file_full_name . "<br>";
    
    } 

    private static function is_allowed_type($filetype,string $category) 
    { 
         
    	$failed = false;
    	$error = "";
        if(in_array($filetype , self::$allowed_types[$category])) 
        { 
        	
            self::$file_type = $filetype; 
        } 
        else
        {
        	$failed = true;
        	$error = 'File type is not an allowed type please only upload files that are allowed types : '. implode(",",$allowed_types['image']); 
        }

        return array('failed' => $failed, 'type' => self::$file_type, 'error' => $error ); 
    } 
     
    private static function is_allowed_size($filesize) 
    { 
    	$failed = false;
    	$error = "";

        if($filesize < self::MAX_SIZE) self::$file_size = $filesize;
        else
        {	
        	 $failed = true;
        	 $error  = 'Error file size is too large'; 
       	}
        return array('failed' => $failed, 'size' => self::$file_size, 'error' => $error );  
    } 


     
    private static function upload_dir($destination) 
    { 

    	$failed = false;
    	$error = "";

    	if(file_exists(self::LOCAL_TARGET.$destination))
    	{
    		self::$directory = self::LOCAL_TARGET . $destination;

    	}
		else
		{

			if (mkdir(self::LOCAL_TARGET . $destination))
	        { 
	        	self::$directory = self::LOCAL_TARGET.$destination.'/';
	        }
	        else
	        {
	        	$failed = true; 
	         	$error  = 'Could not create directory for file storage'; 
	        }
		}

        return array('failed' => $failed, 'directory' => self::$directory, 'error' => $error );          
    } 
   

	 public static function format_user_file_name($file)
	 {
	 	$name   = "";
	 	$failed = false;
	 	$error  = "";

	 	if(isset($file['name']) && $file['name'] != null)
	 	{

	 		if(strlen($file['name']) < self::MAX_NAME_SIZE)
	 		{

	 			$name = addslashes($file['name']);
	 			$name = htmlspecialchars($name);
	 			self::$user_file_name = $name;

	 		} 
	 		else 
	 		{
	 			$failed = true;
	 			$error  = "file exeeds name bounds : 255 characters.";
	 		}

	 	} 
	 	else
	 	{
	 		$failed = true;
	 		$error  = "file name is not set or null";
	 	}

	 	return array('failed' => $failed, 'name' => $name, 'error' => $error);
	 }


	 public static function upload_file($file,$owner) {

	 	$pre_check_upload = self::pre_check_upload($file['error']);

	 	if ($pre_check_upload['failed'] == false)
	 	{
	 		
	 		$upload_dir = self::upload_dir($owner);

	 		$allowed_size = self::is_allowed_size($file['size']);

	 		$user_file_name = self::format_user_file_name($file);

		 	$allowed_type = self::is_allowed_type($file['type'],'image');

		 	var_dump($allowed_type);

	 		if ($user_file_name['failed'] == true) 
	 		{
	 			self::$errors['failed'] = $user_file_name['failed'];
	 			self::$errors['error']  = $user_file_name['error'];
	 		}	 		

	 		if ($allowed_type['failed'] == true) 
	 		{
	 			self::$errors['failed'] = $allowed_type['failed'];
	 			self::$errors['error']  = $allowed_type['error'];
	 		}			 
			if ($allowed_size['failed'] == true) 
			{
				self::$errors['failed'] = $allowed_size['failed'];
				self::$errors['error']  = $allowed_size['error'];
			}
			if ($upload_dir['failed'] == true) 
			{
				self::$errors['failed'] = $upload_dir['failed'];
				self::$errors['error']  = $upload_dir['error'];
			}

			if (self::$errors['failed'] == false)
			{

				 self::generate_name($file);
				 move_uploaded_file(self::$file_tmp ,self::$file_full_name); 
				 
				 return self::$errors;
			
			} else return self::$errors;   
	 	
	 	} else
	 	  {
	 	  	 self::$errors['failed'] = pre_check_upload['error'];
	 	  	 self::$errors['error'] = pre_check_upload['error'];
	 	  	 return self::$errors;
	 	  }
	 }


	 public static function get_user_file_name() {

	 	return self::$user_file_name;
	 }

	 public static function get_generated_file_name()
	 {
	 	return self::$file_name;
	 }

	 public static function get_target_name()
	 {
	 	return self::$directory.'/'.self::$file_name;
	 }

	

}

?>