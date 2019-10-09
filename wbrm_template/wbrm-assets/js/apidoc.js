$( document ).ready(function() {


//================== SEARCH ==================================
function authresponse(response) {
    if(typeof response == 'string')
    {
        if(res=response.match(/Unauthorized/g) )
        return 'Unauthorized';
    }
}


function showHttpResponse(path, data, tthis ) {
    var jsondata = data.split('|')[0];
    var token =tthis.parents('blockquote').children('div.shell-wrap').children('form').children('input.token.form-control').val();
    $.ajax({
        url: path, 
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        method: 'POST', 
        data:  jsondata, 
        success: function(response) {
          
          
          console.log(response);
          
            if(authresponse(response) == 'Unauthorized') { 
               response = 'Unauthorized, Token time out or bad Token';
               tthis.parents().children('form.form').children('div.windowreturn').children('textarea.bodyreturn.shell-body').val(JSON.stringify(response, undefined, 2));
            }
            
            else 
            {    
                if(response.data != null) {
                    if(response.data.length >= 1) {
                        tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','600px');
                    }
                    if(response.data.length >= 10) {
                        tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','1200px');
                    }
                }else {
                    if(response.length >= 1) {
                        tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','600px');
                    }
                    if(response.length >= 10) {
                        tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','1200px');
                    }
                }
                
                tthis.parents().children('form.form').children('div.windowreturn').children('textarea.bodyreturn.shell-body').val(JSON.stringify(response, undefined, 2));
                
                
                var i = 2;
                tthis.parents().children('form.form').children('div.windowreturn').children('p.shell-top-bar.wbrm-text').click(function(){
                    if(i%2==0){
                        tthis.parents().children('form.form').children('div.windowreturn').children('textarea').hide();
                        tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','1200px');
                        tthis.parents().children('form.form').children('div.windowreturn').children('textarea').slideDown();
                        
                    }
                    else if(i%2!=0){ 
                         tthis.parents().children('form.form').children('div.windowreturn').children('textarea').hide();
                        tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','400px');
                        tthis.parents().children('form.form').children('div.windowreturn').children('textarea').slideDown();
                    }
                    i++;
                 });
                 
           
                 
            }                    
      
        }
    }); 
}






$('.sendquery2').click(function() {
    var jsonpost = $(this).parents('blockquote').children('div.shell-wrap').children('form').children('textarea').val();
    var token = $(this).parents('blockquote').children('div.shell-wrap').children('form').children('input.token.form-control').val();
    var isurltoken = $(this).parents('blockquote').children('div.shell-wrap').children('form').children('input.url_for_token').val();
    var route = $(this).parents('blockquote').children('div.shell-wrap').children('form').children('input.route').val();
    var data = jsonpost+'|'+token+'|'+ isurltoken+'|'+route;
    var tthis = $(this);
    //console.log(route);

    tthis.parents().children('form.form').children('div.windowreturn').children('textarea').slideDown();
    
    
    /////// TODO prepare Data & Header Request pour envoyer direct vers Control
    var str = route; 

    if( res=str.match(/gettoken/g) ) {
        
        var jsondata = data.split('|')[0]; 
        $.ajax({  
            url: "/apici/gettoken", 
            method: 'POST', 
            // On converti l'objet JSON en String pour l'envoyer.
            data:  jsondata, 
            success: function(response) {
                if(response.length>=426) {
                    tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','600px');
                }
                
                if(response.length>=1000) {
                    tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','1000px');
                }
                
                tthis.parents().children('form.form').children('div.windowreturn').children('textarea.bodyreturn.shell-body').val(JSON.stringify(response, undefined, 2));
                
                  
                    var i = 2;
                    tthis.parents().children('form.form').children('div.windowreturn').children('p.shell-top-bar.wbrm-text').click(function(){
                        if(i%2==0){
                            tthis.parents().children('form.form').children('div.windowreturn').children('textarea').hide();
                            tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','1200px');
                            tthis.parents().children('form.form').children('div.windowreturn').children('textarea').slideDown();
                            
                        }
                        else if(i%2!=0){ 
                             tthis.parents().children('form.form').children('div.windowreturn').children('textarea').hide();
                            tthis.parents().children('form.form').children('div.windowreturn').children('textarea').css('height','400px');
                            tthis.parents().children('form.form').children('div.windowreturn').children('textarea').slideDown();
                        }
                        i++;
                     });
            }
        }); 
    }

    else if( res=str.match(/annonce\/id/g) ){ 
        
        var jsondata = data.split('/')[1]; 
        jsondata = jsondata.split('|')[0];    
        var idhabit = jsondata;
        showHttpResponse('/apici/annonce/'+idhabit, data, tthis );
        
    }

    else if( res=str.match(/tel\/count/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/count", data, tthis ); //dev
       
    }
    
    
    else if( res=str.match(/annonces\/ville/g) ) { 
    console.log('<dg<g');
       showHttpResponse("/apici/annonces/ville", data, tthis ); //client
    }
    
    
    else if( res=str.match(/ville/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/ville", data, tthis ); //dev
    
    }
    
       
    else if( res=str.match(/annonces\/piece/g) ){ 
    
       showHttpResponse("/apici/annonces/piece", data, tthis ); //client
    
    }
    
    
    else if( res=str.match(/piece/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/piece", data, tthis ); //dev
    
    }
    
    
    else if( res=str.match(/annonces\/chambre/g) ){ 
    
       showHttpResponse("/apici/annonces/chambre", data, tthis ); //client
    
    }
    
    else if( res=str.match(/chambre/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/chambre", data, tthis ); //dev
    
    }
    
    
    else if( res=str.match(/annonces\/prix\/between/g) ){ 
    
       showHttpResponse("/apici/annonces/prix/between", data, tthis ); //client
    
    }
    
    else if( res=str.match(/prix\/between/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/prix/between", data, tthis ); //dev
    
    }
    
    else if( res=str.match(/annonces\/prix/g) ){ 
    
       showHttpResponse("/apici/annonces/prix", data, tthis ); //client
    
    }
    
    else if( res=str.match(/annonces\/type/g) ){ 
    
       showHttpResponse("/apici/annonces/type", data, tthis ); //client
    
    }
    
    else if( res=str.match(/type/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/type", data, tthis ); //dev
    
    }
    
    
    else if( res=str.match(/annonces\/transac/g) ){ 
    
       showHttpResponse("/apici/annonces/transac", data, tthis ); //client
    
    }
      
    else if( res=str.match(/transac/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/transac", data, tthis ); //dev
    
    }
    
    
    else if( res=str.match(/annonces\/surface\/between/g) ){ 
    
       showHttpResponse("/apici/annonces/surface/between", data, tthis ); //client
    
    }
    
    else if( res=str.match(/surface\/between/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/surface/between", data, tthis ); //dev
    
    }
    
    else if( res=str.match(/annonces\/surface/g) ){ 
     
       showHttpResponse("/apici/annonces/surface", data, tthis ); //client
    
    }
    
    else if( res=str.match(/surface/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/surface", data, tthis ); //dev
    
    }
    
    else if( res=str.match(/prix/g) ){ 
    
       showHttpResponse("/apici/annonces/tel/prix", data, tthis ); //dev
    
    }
    
    else if( res=str.match(/criteres/g) ){ 
      
       showHttpResponse("/apici/annonces/criteres", data, tthis ); //dev 
    
    }
    
    

    // ...
    
    else if( res=str.match(/annonces\/tel/g) ){ 
    
       showHttpResponse("/apici/annonces/tel", data, tthis ); //dev
    
    }
    
    else if( res=str.match(/annonces/g) ){ 
   
       showHttpResponse("/apici/annonces", data, tthis ); //client
    
    }
    
    else if( res=str.match(/agence/g) ) { 
      
       showHttpResponse("/apici/agence", data, tthis ); //client
    
    }
});
            

            
            

//================== SEARCH ==================================




    $("#search").keyup(function () {
                                      
        //Declare the custom selector 'containsIgnoreCase'.
          $.expr[':'].containsIgnoreCase = function(n,i,m){
              return $(n).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
          };                                                     
                                      
        //split the current value of #search
        var data = $(this).val().split(" ");
        
        //create a jquery object of the rows
        var jo = $("table").find("tr");

        if (data == "") {
            jo.show();
            return;
        } 
        //hide all the rows
        jo.hide();

        //Recusively filter the jquery object to get results.
        jo.filter(function (i, v) {
            
            var $t = $(this);
            
            for (var d = 0; d < data.length; ++d) {
                if ($t.is(":containsIgnoreCase('" + data[d] + "')")) {
                    return true;
                }
            }
            return false;
        })
        //show the rows that match.
        .show();
    }).focus(function () {
        this.value = "";
        $(this).css({
            "color": "black"
        });
        $(this).unbind('focus');
    }).css({
        "color": "#333"
    });  

});