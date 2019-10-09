$( document ).ready(function() {
            
// ==================== HEADER H1 SLIDER ======================//
   /* $( ".jumbotron" ).slideDown( 2200, function() { });
    var count = 1;
    function transition() {     
        if(count == 1) {
            $('#bigtitle').html('<span style="color:#eee;"> API </span>').fadeIn(250);
             count = 2;
        } 
        else if(count == 2) {
            $('#bigtitle').html('<span style="color:#eee;"> + Consortium </span>').fadeIn(250);
             count = 3;
        } 
        
        else if(count == 3) {
            $('#bigtitle').html(' = APICI ').fadeIn(250);
             count = 1;
        }
    }
    
    setInterval(function(){  
        $('#bigtitle').fadeOut(250);  
            transition();
            setTimeout(function(){ 
                $('#bigtitle').fadeOut(250);
            }, 2400);
        }, 2600);
*/

//============== SOUS-MENU ===================================================//

        var i = 0;

        $('#dropdown-documentation').click(function(){
           $('.documentation').slideDown(300, function() { });
            $('#ul-doc ul').mouseleave(function(){
                $('.documentation').slideUp(400, function() { });
            });
        });


        $('#dropdown-satprem').click(function(){
             $('.satprem').slideDown(300, function() { });
            $('#ul-satprem ul').mouseleave(function(){
                $('.satprem').slideUp(400, function() { });
            });
            
        });

        $('#dropdown-doyourslide').click(function(){
             $('.doyourslide').slideDown(300, function() { });
            $('#ul-dys ul').mouseleave(function(){
                $('.doyourslide').slideUp(400, function() { });
            });
            
        });



       
//========================== DEVICE RESPONSIVE MENU =============================//    
        var k=0;
        $('#hamburger').click(function(){  // NAVIGATION BUTTON
            if(k%2==0){
                $('#hamburger-accordion').slideDown(300, function() { });
            }
            if(k%2!=0){
                $('#hamburger-accordion').slideUp(400, function() { });
            }
            k++;
        });

       // ======== SOUS MENU  
        $('#h3-menu5').click(function(){
            $('.list5').slideDown(300, function() { });                
        }); 
        $('#h3-menu5').mouseleave(function(){
                $('.list5').slideUp(300, function() { });                
        }); 

        $('#h3-menu6').click(function(){
            $('.list6').slideDown(300, function() { });                
        }); 
        $('#h3-menu6').mouseleave(function(){
                $('.list6').slideUp(300, function() { });                
        }); 

        $('#h3-menu7').click(function(){
            $('.list7').slideDown(300, function() { });                
        }); 
        $('#h3-menu7').mouseleave(function(){
            $('.list7').slideUp(300, function() { });                
        }); 

       
       

//======================= MENU HEADER MOVING TO TOP AND OTHER ANIMATIONS ON SCROLL ==========================================//

    $(window).scroll( function() 
    {
        var scrolled_val = $(document).scrollTop().valueOf();
        
        //$('#scrollvalue').html(scrolled_val/100);
        // menu scrolling
         if(scrolled_val < 200){
            $('#logo-kbd').removeClass('menu_logo_scrollBottom');
            $('kbd').css('background-color','#00B1F0').css('color','#fff');
            
            $('#menu').removeClass('headmenu-when-scrollBottom');
            $('#menu').addClass('headmenu-when-scrollTop');
        }

        if(scrolled_val > 200){
            $('#menu').addClass('headmenu-when-scrollBottom');
            if(!!$('headmenu-when-scrollBottom'))$('#menu').removeClass('headmenu-when-scrollTop');
        }

        if(scrolled_val <= 489){
            $('#scrollvalue').css('display','none');
            $('#to-up-icon').fadeOut("slow");
        }

        if(scrolled_val > 489){
            $('#scrollvalue').css('display','block');
        }

        if(scrolled_val < 201){
            $('#logo-kbd').css('height','100px').css('padding-top','32px').css('border-right', '1px solid white');
            $('kbd').css('background-color','#00B1F0').css('color','#fff');
            $('#menulinks').css('margin-top','-72px');
            $('#menulinks a').css('color','#00B1F0');
            $('#hamburger-accordion').css('margin-top','100px');
            $('#hamburger').css('margin-top','0px');
        }

        if(scrolled_val > 201){
            $('#menu').css('padding-top','0px')
            $('#logo-kbd').css('height','50px').css('padding-top','12px').css('border-right', '1px solid silver');
            $('#scrollvalue').css('margin-top','-36px');
            $('#menulinks').css('margin-top','-48px');
            $('#menulinks a').css('color','#777777'); 
            $('#hamburger-accordion').css('margin-top','51px');
            $('#hamburger').css('margin-top','25px');
        }

        if(scrolled_val > 2500){
            $('#bandeau2').addClass('bandeau-keyframe');
        }

        if(scrolled_val > 490 && scrolled_val < 1000){
            $('#scrollvalue').html('<div style="min-width:80px;><a href="#">'+scrolled_val/50+ '</a>%</div> <div style="margin-left:80px;margin-top:-27px">de CSS3</div>');
        }

        if(scrolled_val > 1001 && scrolled_val < 1500){
            $('#scrollvalue').html('<div style="min-width:80px;><a href="#">'+scrolled_val/50+ '</a>%</div> <div style="margin-left:80px;margin-top:-27px">de BOOTSTRAP</div>');
            $('#to-up-icon').slideDown(1000, function(){});
        }

        if(scrolled_val > 1501 && scrolled_val < 2000){
            $('#scrollvalue').html('<div style="min-width:80px;><a href="#">'+scrolled_val/50+ '</a>%</div> <div style="margin-left:80px;margin-top:-27px">de HTML5</div>');
        }

        if(scrolled_val > 2001 && scrolled_val < 2500){
            $('#scrollvalue').html('<div style="min-width:80px;><a href="#">'+scrolled_val/50+ '</a>%</div> <div style="margin-left:80px;margin-top:-27px"> de JAVASCRIPT</div>');
        }

        if(scrolled_val > 2501 && scrolled_val < 3000){
            $('#scrollvalue').html('<div style="min-width:80px;><a href="#">'+scrolled_val/50+ '</a>%</div> <div style="margin-left:80px;margin-top:-27px">de IONIC & CORDOVA </div>');

        }

        if(scrolled_val > 3001 && scrolled_val < 3200){
            $('#scrollvalue').html('<div style="min-width:80px;><a href="#">'+scrolled_val/50+ '</a>%</div> <div style="margin-left:80px;margin-top:-27px"> de CAFÉ</div>');
        }

        if(scrolled_val > 3201 && scrolled_val < 3500){
            $('#scrollvalue').html('<div style="min-width:80px;><a href="#">'+scrolled_val/50+ '</a>%</div> <div style="margin-left:80px;margin-top:-27px">de JQUERY</div>');
        }

        if(scrolled_val > 3501 && scrolled_val < 4000){
            $('#scrollvalue').html('<div style="min-width:80px;><a href="#">'+scrolled_val/50+ '</a>%</div> <div style="margin-left:80px;margin-top:-27px">de PHP5</div>');
        }
        
        if(scrolled_val > 4000){
            $('#scrollvalue').html('<div style="min-width:80px;><a href="#">'+((scrolled_val/50)+8)+ '</a>%</div> <div style="margin-left:80px;margin-top:-27px">  &nbsp;de SYMFONY</div>');
        }
        
    });




    
           
});