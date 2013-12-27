<?php

class YouTube{
    
    
    /* 
	 * Retrieve the video ID from a YouTube video URL
	 * @param $ytURL The full YouTube URL from which the ID will be extracted
	 * @return $ytvID The YouTube video ID string
	 */
    
    

    
    
    static function UrlToVideoId($ytURL) {
			
	    if($ytURL) return false;
	    
		$ytvIDlen = 11;	// This is the length of YouTube's video IDs
 
		// The ID string starts after "v=", which is usually right after 
		// "youtube.com/watch?" in the URL
		$idStarts = strpos($ytURL, "?v=");
 
		// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my 
		// bases covered), it will be after an "&":
		if($idStarts === FALSE)
			$idStarts = strpos($ytURL, "&v=");
		// If still FALSE, URL doesn't have a vid ID
		if($idStarts === FALSE)
			Notify::adminError("YouTube video ID not found. Please double-check your URL.");
 
		// Offset the start location to match the beginning of the ID string
		$idStarts +=3;
 
		// Get the ID string and return it
		$ytvID = substr($ytURL, $idStarts, $ytvIDlen);
 
		return $ytvID;
 
	}
        
        
    
    static function display($video_id){
        
	//if it's a url I convert in uid
	if(strlen($video_id)>11)
	    $video_id=YouTube::UrlToVideoId($video_id);
	    
	    
	return
	'
	<object type="application/x-shockwave-flash"
	    class="youtube"
	    data="http://www.youtube.com/v/'.$video_id.'">
	    <param name="movie" value="http://www.youtube.com/v/q7559PoRTs0" />
	</object>
	';
        
    }
    
    
}