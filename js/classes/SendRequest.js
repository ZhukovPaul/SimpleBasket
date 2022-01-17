
  class SendRequest{

    constructor(){

        if( !SendRequest._instance)
            SendRequest._instance = this;

        return SendRequest._instance;
    }

    async sendPostRequest(ajaxPath, sendData  )
    {
        let fetchData,
            response;

        fetchData = {
            method  :   "POST",
            body    :   JSON.stringify( sendData ),
            headers :   new Headers()
        }
    
        response = await  fetch(ajaxPath, fetchData )
        .then( data => data.json() ).then( data => {
            return data;
        });
        
        return  response;

    }


}

 