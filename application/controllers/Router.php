<?

class Router{
    
    
    public function __construct(){
        
        //take security measures
        new Security_C();

        //start a new user
        new User_C(SHORT_IP);
        
        //interpret URL and define supervars
        new Request_C();
        
        ###to modify now it's just for avoiding piracy until I activate the login process
      // if(AREA=='Admin') die('Area amministrativa al momento disabilitata');
        
        //define and start main page controller
        $page_controller_name=$this->_definePageController();
        $Main_C=new $page_controller_name();
       // echo $page_controller_name;
    }
    
    

    
    
    
    //------------- PRIVATE FUNCTIONS ------------//
    
    
    protected function _definePageController(){

        //admin
        if (AREA=='Admin') return 'Admin_C';
        
        //look for specific controller
        $topic=Strings::underScoreToUcFirst(PAGE_TOPIC);
        $C_Name=$topic.'_C';
        if(file_exists(DOC_ROOT.'/application/controllers/'.$C_Name.'.php'))
            return $C_Name;
        
        
        //look for main topic controller
        $topic=Strings::underScoreToUcFirst(MAIN_TOPIC);
        $C_Name=$topic.'_C';
        if(file_exists(DOC_ROOT.'/application/controllers/'.$C_Name.'.php'))
            return $C_Name;
        
        
        //default
        return 'Default_C';
    }
    

}