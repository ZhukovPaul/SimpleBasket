
class ProductItem{
     
    constructor( id, params ){

        // Product's id
        this.id                     =   id;
        
        // Classes for buttons
        this.addBtnClass            =   params.ADD_BTN_CLASS || "ToBasket";
        this.removeBtnClass         =   params.REMOVE_BTN_CLASS || "RemoveFromBasket";
        this.cntInputClass          =   params.CNT_INPUT_CLASS || "Count";
        this.idPrefix               =   params.PREFIX || "";

        // Invoked ajax methods
        this.addCommand             =    params.ADD_COMMAND ||"AddToBasketCommand";
        this.removeCommand          =    params.REMOVE_COMMAND ||"RemoveFromBasketCommand";

        // Path to controller
        this.ajaxPath               =   params.AJAX_URL;

        //Other params
        this.useBasket              =   (params.USE_BASKET == "N") ? false : true;
        this.prefix                 =   (params.USE_CLASS == "Y") ? "." : "#";
       
        // Objects
        this.REQUEST_OBJECT         =   new SendRequest();
        
        this.textInBasket           =   params.IN_BASKET;
        this.textToBasket           =   params.TO_BASKET;
        this.textProductWasAdded    =   params.PRODUCT_WAS_ADDED;
        this.textProductWasRemoved  =   params.PRODUCT_WAS_REMOVED;
        
        // Not necessary :
        if(params.BASKET_PARAMS) 
            this.basketParams  =   JSON.parse( params.BASKET_PARAMS ) || {};

        if(this.useBasket)
            this.initBasket();        

        // Always necessary

        this.initEvents();
    }

    // Get Basket object 
    initBasket(){
        this.BASKET_OBJECT = new Basket();
        if( typeof this.basketParams == "object")
            this.BASKET_OBJECT.setParams( this.basketParams );
    }

    refreshBasket(){
        if(this.useBasket)
            this.BASKET_OBJECT.refreshCount();
    }

    // Initiation all events
    initEvents (){
        this.initAddEvent();
        this.initRemoveEvent();
    }
    
    getCount(){
        let id = this.prefix + this.idPrefix + this.id + this.cntInputClass ;
        if( $(id) == undefined)
            return 1;

        return $(id).val();
    }

    // Initialization addendum action
    initAddEvent(){
        
       /*if( typeof $._data( $( this.prefix + this.idPrefix + this.id +  this.addBtnClass )[0], 'events') == "object" )
           $( this.prefix + this.idPrefix + this.id +  this.addBtnClass ).off();*/
    
        $( "body" ).on( "click", this.prefix + this.idPrefix + this.id +  this.addBtnClass,  ( t )=>{ 
			 
            t.preventDefault();

            this.add2Basket( this.id ,  this.getCount() );
           
            $( this.prefix + this.idPrefix + this.id +  this.addBtnClass ).hide();
            $( this.prefix + this.idPrefix + this.id +  this.removeBtnClass ).show();
       
        });
 
        return false;
    }
    // Initialization remove action
    initRemoveEvent(){

       /*if( typeof $._data( $(  this.prefix + this.idPrefix + this.id +  this.removeBtnClass )[0], 'events') == "object" )
            $( this.prefix + this.idPrefix + this.id +  this.addBtnClass ).off();
        */
        $( "body" ).on( "click" ,this.prefix + this.idPrefix + this.id +  this.removeBtnClass ,  ( t )=>{ 
            
            t.preventDefault()

            this.removeFromBasket( this.id  );
            $( this.prefix + this.idPrefix + this.id +  this.removeBtnClass ).hide();
            $( this.prefix + this.idPrefix + this.id +  this.addBtnClass ).show();             
       
        });
        return false;
    }

    // Addendum product into basket by "id" with "count" number
    async add2Basket( element_id , element_count ){
        
        let sendData,
            response;
        
        if(!element_id) return;
        element_count = (element_count > 0 ) ? element_count : 1;
               
        sendData = {
            id      : element_id, 
            count   : element_count, 
            action  : this.addCommand 
        };

        response = await this.REQUEST_OBJECT.sendPostRequest( this.ajaxPath , sendData );
        this.resultAnswer( response , this.textProductWasAdded );
        this.refreshBasket();
    }

    // Remove product from basket by id
    async removeFromBasket( element_id ){
        let sendData,
            response;

        sendData = {
            id      : element_id, 
            action  : this.removeCommand 
        };

        response = await this.REQUEST_OBJECT.sendPostRequest( this.ajaxPath , sendData );
        this.resultAnswer( response , this.textProductWasRemoved );
        this.refreshBasket();
    }
    
    // Some actions by events
    resultAnswer( data , text ){
        
        if( data.ERROR )
            alertify.error( data.ERROR );
        else
            alertify.success( text );
    }


}

 