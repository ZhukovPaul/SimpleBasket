
class Basket {

    constructor(){

        if(! Basket._instance) 
            Basket._instance = this;

        return Basket._instance;
    }

    setParams( params ){
        //this.count              = 0 ;
        this.ajaxPath           =   params.AJAX_URL || "/api/index.php";
        this.getCountCommand    =   params.GET_COUNT_COMMAND || "GetBasketCountCommand";
        
        this.REQUEST_OBJECT     =   new SendRequest();

        if( params.counterId  ){
            this.counterDomObject = $( "#"+params.counterId );
        } 

        // Set common count
        this.refreshCount();
    }

    async refreshCount(){
        
        let sendData,
            response;

        sendData = {
            action  : this.getCountCommand 
        };

        // Call method for ajax query
        response = await this.REQUEST_OBJECT.sendPostRequest(this.ajaxPath , sendData );

        if( response.ERROR )
            alertify.error( response.ERROR );
        else 
            this.count = response.SUCCSESS;
             
        if(this.counterDomObject != undefined)
            this.counterDomObject.text( this.count ) ; 
    }


 }