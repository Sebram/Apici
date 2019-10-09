  $( document ).ready(function() {




//================== SCROLLING FUNCTION==================================

    $(window).scroll( function() {
        var scrolled_val = $(document).scrollTop().valueOf();

    });
            


 //==================== STYLES CHANGES ================================
            $('p').addClass('wbrm-text'); 
            $('ul li').addClass('wbrm-text'); 
            $('a').addClass('wbrm-text');
            $('h2').addClass('wbrm-title');
            $('h1').addClass('wbrm-title');
            $('.box-text p').css('color', '#333333'); 
            $('.box-text strong').css('color', '#333333'); 
            $('strong').addClass('lead').css('font-weight', '400'); 
            

            var x=0;
            $('#button-theme').click(function(){
                if(x==0){
                    $('body').css('background-color','#ffffff');
                    $('h2').css('color','#333333');
                    $('p').css('color','#666666');
                    $('ul li').css('color','#666666');
                    $('strong').css('color','#666666');
                    $('.box-text p').css('color', '#333333'); 
                    $('.box-text strong').css('color', '#333333'); 
                    $('#satprem').removeClass('overlay1'); 
                    $('#satprem').css('background-color','#DDD');
                    $('#developper').css('background-color','#DDD');
                    $('.subtitle').css('color','FF4220').css('font-weight','bold');
                }
                 if(x==1){
                    $('body').css('background-color','#222222');
                    $('h2').css('color','666666');
                    $('p').css('color','#666666');
                    $('ul li').css('color','#666666');
                    $('strong').css('color','666666');
                    $('.box-text p').css('color', '#333333'); 
                    $('.box-text strong').css('color', '#333333'); 
                    $('.subtitle').css('color','#FF4220').css('font-weight','bold');
                    $('blockquote p').css('color','grey');
                }
                if(x==2){
                    $('body').css('background-color','#444444');
                    $('h2').css('color','white');
                    $('p').css('color','#ddd');
                    $('ul li').css('color','#ddd');
                    $('strong').css('color','white');
                    $('.box-text p').css('color', '#333333'); 
                    $('.box-text strong').css('color', '#333333');
                    $('#satprem').css('background-color','#333333');
                    $('#developper').css('background-color','#333333'); 
                    $('.subtitle').css('color','#FF4220').css('font-weight','bold');
                    
                }
                if(x==3){
                    x=x-4;
                }
                x++;
            });
        
           



        
//  ===========================SORTING FUNCTION ===========================
            function displayAll(clikId, className){
                $(clikId).click(function(){
                    $(className).fadeIn('slow');
                });
            }

            
            function sortDisplay(clickId, className, groupClass){
                   $(clickId).click(function(){
                        $(className).fadeIn('slow');
                        $('div'+groupClass+':not('+className+')').fadeOut("slow");
                   }) ;
            }


            // ------------   REALISATION 

            displayAll("a#real-sort-all",".real");

            sortDisplay("a#real-sort-sites", ".real-sites", ".real");
            sortDisplay("a#real-sort-apps", ".real-applications", ".real");
            sortDisplay("a#real-sort-illust", ".real-illustrations", ".real");
            sortDisplay("a#real-sort-compo", ".real-compositions", ".real");
            sortDisplay("a#real-sort-video", ".real-videos", ".real");
            
             
             // ------------   SAVOIR FAIRE

             displayAll("a#sf-sort-all",".sfaire");
             sortDisplay("a#sf-sort-langage", ".sf-langages", ".sfaire");
             sortDisplay("a#sf-sort-langage", ".sf-langages", ".sfaire");
             sortDisplay("a#sf-sort-framework", ".sf-frameworks", ".sfaire");
             sortDisplay("a#sf-sort-server", ".sf-servers", ".sfaire");
             sortDisplay("a#sf-sort-librairie", ".sf-librairies", ".sfaire");

             // ============================
          

             var x =  $(L).css('cursor','pointer');
            for(var i = 0; i<= x; i++){
                var L = $( "div.list-savoirfaire .list-savoirfaire" + i );
                $(L).css('cursor','pointer');
            }
        
            
           

//  =========================== SORTING ARTICLE WITH AJAX===================================
            // tri et affichage des articles selon appels ajax quand on clique sur les kbd(bouton)
            var m = 0;
            $('.post-article-kbd').click(function(){
                $('#articleDisplayOnload').fadeOut('slow');
                $('#articleDisplayOnload').css('display','none');
                var p = m ;
                m++;
                if(p<m){ $('#articleDisplay').css('display','none');
                setTimeout(function(){
                    $('#articleDisplay').fadeIn(1000);
                }, 100); 
                 }
            });
            
          
            $('#articles-from-rubrique p').css('font-size', '14px');
            $('#articles-from-rubrique ul li').css('font-size', '14px');
            $('#articles-from-rubrique h2').css('font-size', '14px');
            $('#articles-from-rubrique h2 strong').css('display', 'none');
            $('#articles-from-rubrique h2 strong').css('font-size', '14px');

              
            
            // pour eviter les doublons dans la liste de kbd(bouton) page articles
            var kbd = $('.post-article-kbd').length;
            var T = [""];
             T[1]=$('.post-article-kbd')[1];
            for(var n=1;n<kbd;n++){
                 T.push($('.post-article-kbd')[n]);
                if(T[n].id == T[n-1].id){
                    $(T[n]).css('display','none');
                }     
            }



//  ========== SORTING DOCUMENTATION===================================
            var A =  $(".doc-window");
            var D =  $(".doc-window")[0];
            var S =  $(".doc-window")[1];
            $("a#doc-sort-dys").click(function(){
                $(D).fadeIn("slow");
                $(S).fadeOut("slow");
            });
            $("a#doc-sort-satprem").click(function(){
                $(S).fadeIn("slow");
                $(D).fadeOut("slow");
            });
            $("a#doc-sort-all").click(function(){
                $(A).fadeIn("slow");
            });
            




// ================= UP AND DOWN BUTTON SCROLL MOVING ========================================
       
        if($("#devweb1").length){
            $('html, body').animate({
                scrollTop: $("#devweb1").offset().top
            }, 2500);
        }
            


            $('#to-down-icon').click(function(){
                 $('html, body').animate({
                    scrollTop: $("#labocreatif").offset().top
                }, 1000);
            }); 
            $('#to-up-icon').click(function(){
                 $('html, body').animate({
                    scrollTop: $("#prlx").offset().top
                }, 1000);
            });



// ================= CONTACT TEXTAREA ANIMATE ========================================
            $('#exampleInputTexte1').focus(function() 
            { 
               $(this).animate({'height': '185px'}, 'speed' );//Expand the textarea on clicking on it 
               return false; 
             }); 
    
            

            
});