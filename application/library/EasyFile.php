<?php

class EasyFile{
    
    static function inDir($dir,$file_name){
        
      if(in_array($file_name,self::filesInDirectory($dir))) return true;
      
    }
    
    
    
    static function fileExists($file_path_or_url){
        /*determines if a file exists whether it's local or url*/
        
        if(file_exists($file_path_or_url)) return true;
        if(Validate::url($file_path_or_url)) return true;
        
        Notify::developer($file_path_or_url.' cannot be found and therefore cannot be processed');
    }
    

    static function filesInDirectory($dir,$files_to_open='php,css,jsp',$scan_subfolders=true,$only_file_name=1){
        
        /*
         returns a numeric array with all the paths of existing files in $dir
         and in every subdirectory of dir
        */
        

        //if $dir is not a directory I return false
        
        if(!is_dir($dir))
            die($dir.' is not a directory');
        
        //create array with file types to open
        $FilesToOpen=explode(',',$files_to_open);
        
        //open the directory
        $handler = opendir($dir);
        
        while ($file = readdir($handler)) :
        
            //if it's a directory I recall the same function
            if ($file !== '.' && $file !== '..' ):



                if ( !preg_match("/^_/",$file) && in_array(substr($file,-3,3),$FilesToOpen))
                        ($only_file_name) ?  $Files[]=$file :   $Files[]=$dir.$file;
              
               if(is_dir($dir.$file) && $scan_subfolders):
               
                    $SubResult=self::filesInDirectory($dir.$file.'/',$files_to_open,$scan_subfolders,$only_file_name);
                
                    if($SubResult)
                        $SubFiles[]=$SubResult;
                    
                endif;
                
            endif;
            
        endwhile;
        
         closedir($handler);
        
        
        
        //put the Subfiles array in File again
        
        if(!empty($SubFiles))
            foreach($SubFiles as $numeric_key=>$FilesArray)
                if(isset($FilesArray))
                    foreach($FilesArray as $file)
                        $Files[]=$file;


        
        if(isset($Files) && is_array($Files))    return $Files;       return false; 

        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    static function getBaseName($ItemInfo_uid_or_url,$size='',$n=''){
        /*
         

    New Base name format= LANG_ITEMURL_UID_SIZE_N
        */
        
        
        //if I don't have item info I try to get them
        $ItemInfo=(is_array($ItemInfo_uid_or_url)) ? $ItemInfo_uid_or_url : CrudoQuery::getItemInfo($ItemInfo_uid_or_url);
       //echo'heey'; print_r($ItemInfo);
        //if there still no info I try to get them from post (since probably it's for a new item)
        if(!$ItemInfo) $ItemInfo = $_POST;
        
        
        //if the resource is not good I tell developer and stop the function
        if (
           (!isset($ItemInfo['item_lang']) or !$ItemInfo['item_lang']) or
           (!isset($ItemInfo['item_url']) or !$ItemInfo['item_url']) or
           (!isset($ItemInfo['universal_id']) or !$ItemInfo['universal_id'])
            ):

        
            Notify::developer('Impossible to get basename for file '.var_export($ItemInfo_uid_or_url));
            return false;
        
        endif;
        
        
        
        //at this point we should be good to go
    
       
        $size=($size) ? '_'.$size : ''; //add size if specified (for images)
        $n=($n) ? '_'.$n : ''; //add number to support multiple files per item in future

        
        //return basename (current format LANG_ITEMURL_UID(_SIZE)(_N))
        return $ItemInfo['item_lang'].'_'.$ItemInfo['item_url'].'_'.$ItemInfo['universal_id'].$size.$n;

    }
    
    
    
    
    
    
    
    
    static function getExtension($file_name_path_or_resource){
        
        if(is_string($file_name_path_or_resource))
            return Strings::getLastPiece($file_name_path_or_resource,'.');
        
        ###Make function to support file resource
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
#ELIMINAZIONE FILES DA SISTEMARE UN PO
##############################################################################################################
static function deleteFiles($path){
$file=null;
	
	$operations=0;
	$successes=0;
	
		if(file_exists($path) && is_file($path)) {
		$operations++;
			
			if(unlink($path)){
			$successes++;
			}
			
		}elseif(is_dir($path)){
			$handle = opendir($path);
			while (false !== ($file = readdir($handle))) { 
				if(is_file($path.$file)){
				$operations++;
				
					if(unlink($path.$file)){
					$successes++;
					}
					
				}
			}
			$handle = closedir($handle);
			rmdir($path);
		}
		
		if($successes<$operations||!$successes){
		echo "impossibile eliminare ".$path.$file;
		return false;
		}else{
		
		//make function to update DB
			
		return true;
		}
		
}









//------- Private functions



public static function mimeToExtension($mime){


        $transo=array(
            "application/envoy"	=>"evy",
            "application/fractals"=>	"fif",
            "application/futuresplash"	=>"spl",
            "application/hta"	=>"hta",
            "application/internet-property-stream"	=>"acx",
            "application/mac-binhex40"	=>"hqx",
            "application/msword"	=>"doc",
            "application/msword"	=>"dot",
            "application/octet-stream"	=>"*",
            "application/octet-stream"	=>"bin",
            "application/octet-stream"	=>"class",
            "application/octet-stream"	=>"dms",
            "application/octet-stream"	=>"exe",
            "application/octet-stream"	=>"lha",
            "application/octet-stream"	=>"lzh",
            "application/oda"	=>"oda",
            "application/olescript"	=>"axs",
            "application/pdf"	=>"pdf",
            "application/pics-rules"	=>"prf",
            "application/pkcs10"	=>"p10",
            "application/pkix-crl"	=>"crl",
            "application/postscript"	=>"ai",
            "application/postscript"	=>"eps",
            "application/postscript"	=>"ps",
            "application/rtf"	=>"rtf",
            "application/set-payment-initiation"	=>"setpay",
            "application/set-registration-initiation"	=>"setreg",
            "application/vnd.ms-excel"	=>"xla",
            "application/vnd.ms-excel"	=>"xlc",
            "application/vnd.ms-excel"	=>"xlm",
            "application/vnd.ms-excel"	=>"xls",
            "application/vnd.ms-excel"	=>"xlt",
            "application/vnd.ms-excel"	=>"xlw",
            "application/vnd.ms-outlook"	=>"msg",
            "application/vnd.ms-pkicertstore"	=>"sst",
            "application/vnd.ms-pkiseccat"	=>"cat",
            "application/vnd.ms-pkistl"	=>"stl",
            "application/vnd.ms-powerpoint"	=>"pot",
            "application/vnd.ms-powerpoint"	=>"pps",
            "application/vnd.ms-powerpoint"	=>"ppt",
            "application/vnd.ms-project"	=>"mpp",
            "application/vnd.ms-works"	=>"wcm",
            "application/vnd.ms-works"	=>"wdb",
            "application/vnd.ms-works"	=>"wks",
            "application/vnd.ms-works"	=>"wps",
            "application/winhlp"	=>"hlp",
            "application/x-bcpio"	=>"bcpio",
            "application/x-cdf"	=>"cdf",
            "application/x-compress"	=>"z",
            "application/x-compressed"	=>"tgz",
            "application/x-cpio"	=>"cpio",
            "application/x-csh"	=>"csh",
            "application/x-director"	=>"dcr",
            "application/x-director"	=>"dir",
            "application/x-director"	=>"dxr",
            "application/x-dvi"	=>"dvi",
            "application/x-gtar"	=>"gtar",
            "application/x-gzip"	=>"gz",
            "application/x-hdf"	=>"hdf",
            "application/x-internet-signup"	=>"ins",
            "application/x-internet-signup"	=>"isp",
            "application/x-iphone"	=>"iii",
            "application/x-javascript"	=>"js",
            "application/x-latex"	=>"latex",
            "application/x-msaccess"	=>"mdb",
            "application/x-mscardfile"	=>"crd",
            "application/x-msclip"	=>"clp",
            "application/x-msdownload"	=>"dll",
            "application/x-msmediaview"	=>"m13",
            "application/x-msmediaview"	=>"m14",
            "application/x-msmediaview"	=>"mvb",
            "application/x-msmetafile"	=>"wmf",
            "application/x-msmoney"	=>"mny",
            "application/x-mspublisher"	=>"pub",
            "application/x-msschedule"	=>"scd",
            "application/x-msterminal"	=>"trm",
            "application/x-mswrite"	=>"wri",
            "application/x-netcdf"	=>"cdf",
            "application/x-netcdf"	=>"nc",
            "application/x-perfmon"	=>"pma",
            "application/x-perfmon"	=>"pmc",
            "application/x-perfmon"	=>"pml",
            "application/x-perfmon"	=>"pmr",
            "application/x-perfmon"	=>"pmw",
            "application/x-pkcs12"	=>"p12",
            "application/x-pkcs12"	=>"pfx",
            "application/x-pkcs7-certificates"	=>"p7b",
            "application/x-pkcs7-certificates"	=>"spc",
            "application/x-pkcs7-certreqresp"	=>"p7r",
            "application/x-pkcs7-mime"	=>"p7c",
            "application/x-pkcs7-mime"	=>"p7m",
            "application/x-pkcs7-signature"	=>"p7s",
            "application/x-sh"	=>"sh",
            "application/x-shar"	=>"shar",
            "application/x-shockwave-flash"	=>"swf",
            "application/x-stuffit"	=>"sit",
            "application/x-sv4cpio"	=>"sv4cpio",
            "application/x-sv4crc"	=>"sv4crc",
            "application/x-tar"	=>"tar",
            "application/x-tcl"	=>"tcl",
            "application/x-tex"	=>"tex",
            "application/x-texinfo"	=>"texi",
            "application/x-texinfo"	=>"texinfo",
            "application/x-troff"	=>"roff",
            "application/x-troff"	=>"t",
            "application/x-troff"	=>"tr",
            "application/x-troff-man"	=>"man",
            "application/x-troff-me"	=>"me",
            "application/x-troff-ms"	=>"ms",
            "application/x-ustar"	=>"ustar",
            "application/x-wais-source"	=>"src",
            "application/x-x509-ca-cert"	=>"cer",
            "application/x-x509-ca-cert"	=>"crt",
            "application/x-x509-ca-cert"	=>"der",
            "application/ynd.ms-pkipko"	=>"pko",
            "application/zip"	=>"zip",
            "octet/stream"	=>"zip",
            "audio/basic"	=>"au",
            "audio/basic"	=>"snd",
            "audio/mid"	=>"mid",
            "audio/mid"	=>"rmi",
            "audio/mpeg"	=>"mp3",
            "audio/x-aiff"	=>"aif",
            "audio/x-aiff"	=>"aifc",
            "audio/x-aiff"	=>"aiff",
            "audio/x-mpegurl"	=>"m3u",
            "audio/x-pn-realaudio"	=>"ra",
            "audio/x-pn-realaudio"	=>"ram",
            "audio/x-wav"	=>"wav",
            "image/bmp"	=>"bmp",
            "image/cis-cod"	=>"cod",
            "image/gif"	=>"gif",
            "image/ief"	=>"ief",
            "image/jpeg"	=>"jpe",
            "image/jpeg"	=>"jpeg",
            "image/jpeg"	=>"jpg",
            "image/pipeg"	=>"jfif",
            "image/svg+xml"	=>"svg",
            "image/tiff"	=>"tif",
            "image/tiff"	=>"tiff",
            "image/x-cmu-raster"	=>"ras",
            "image/x-cmx"	=>"cmx",
            "image/x-icon"	=>"ico",
            "image/x-portable-anymap"	=>"pnm",
            "image/x-portable-bitmap"	=>"pbm",
            "image/x-portable-graymap"	=>"pgm",
            "image/x-portable-pixmap"	=>"ppm",
            "image/x-rgb"	=>"rgb",
            "image/x-xbitmap"	=>"xbm",
            "image/x-xpixmap"	=>"xpm",
            "image/x-xwindowdump"	=>"xwd",
            "message/rfc822"	=>"mht",
            "message/rfc822"	=>"mhtml",
            "message/rfc822"	=>"nws",
            "text/css"	=>"css",
            "text/h323"	=>"323",
            "text/html"	=>"htm",
            "text/html"	=>"html",
            "text/html"	=>"stm",
            "text/iuls"	=>"uls",
            "text/plain"	=>"bas",
            "text/plain"	=>"c",
            "text/plain"	=>"h",
            "text/plain"	=>"txt",
            "text/richtext"	=>"rtx",
            "text/scriptlet"	=>"sct",
            "text/tab-separated-values"	=>"tsv",
            "text/webviewhtml"	=>"htt",
            "text/x-component"	=>"htc",
            "text/x-setext"	=>"etx",
            "text/x-vcard"	=>"vcf",
            "video/mpeg"	=>"mp2",
            "video/mpeg"	=>"mpa",
            "video/mpeg"	=>"mpe",
            "video/mpeg"	=>"mpeg",
            "video/mpeg"	=>"mpg",
            "video/mpeg"	=>"mpv2",
            "video/quicktime"	=>"mov",
            "video/quicktime"	=>"qt",
            "video/x-la-asf"	=>"lsf",
            "video/x-la-asf"	=>"lsx",
            "video/x-ms-asf"	=>"asf",
            "video/x-ms-asf"	=>"asr",
            "video/x-ms-asf"	=>"asx",
            "video/x-msvideo"	=>"avi",
            "video/x-sgi-movie"	=>"movie",
            "x-world/x-vrml"	=>"flr",
            "x-world/x-vrml"	=>"vrml",
            "x-world/x-vrml"	=>"wrl",
            "x-world/x-vrml"	=>"wrz",
            "x-world/x-vrml"	=>"xaf",
            "x-world/x-vrml"	=>"xof",
            "video/mp4"			=>"mp4"
        );
        
        if (	strtr(	$mime, $transo	)	)
            return strtr($mime, $transo);
                else
            return false;

}
    
    
    
    
}