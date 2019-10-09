           window.sr = ScrollReveal();
            var fromLeftAnim = {
              origin: 'left',
              reset       : true,
              duration    : 500,
              distance : '150px',
              //easing   : 'ease-in-out',
              //rotate   : { z: 10 },
              scale    : 0, 
              mobile      : true,
            };
            sr.reveal('.from-left-anim', fromLeftAnim);

            var fromLeftAnimSlow = {
              origin: 'left',
              reset       : true,
              duration    : 1500,
              distance : '700px',
              easing   : 'ease-in-out',
              //rotate   : { z: 10 },
              scale    : 0.1, 
              mobile      : true,
            };
            sr.reveal('.from-left-anim-slow', fromLeftAnimSlow);
            
            var fromLeftAnim2x = {
              origin: 'left',
              reset       : true,
              delay       : 100,
              duration    : 600,
              distance : '200px',
              //easing   : 'ease-in-out',
              //rotate   : { z: 10 },
              scale    : 0, 
              mobile      : true,
            };
            sr.reveal('.from-left-anim2x', fromLeftAnim2x);



            var fromRightAnim = {
              origin: 'right',
              reset       : true,
              duration    : 1000,
              delay    : 100,
              distance : '1050px',
              //easing   : 'ease-in-out',
              //rotate   : { z: 10 },
              //scale    : 0.1, 
              mobile      : true,
            };
            sr.reveal('.from-right-anim', fromRightAnim);

            var fromRightAnim2 = {
              origin: 'right',
              reset       : true,
              duration    : 500,
              delay    : 200,
              distance : '250px',
              //easing   : 'ease-in-out',
              //rotate   : { z: 10 },
              scale    : 0.1, 
              mobile      : true,
            };
            sr.reveal('.from-right-anim2', fromRightAnim2);
            
             var fromRightAnim3 = {
              origin: 'right',
              reset       : true,
              duration    : 500,
              delay    : 300,
              distance : '250px',
              //easing   : 'ease-in-out',
              //rotate   : { z: 10 },
              scale    : 0.1, 
              mobile      : true,
            };
            sr.reveal('.from-right-anim3', fromRightAnim3);


            var fromLeftAnimNoReset = {
              origin: 'left',
              reset       : false,
              duration    : 500,
              distance : '150px',
              //easing   : 'ease-in-out',
              //rotate   : { z: 10 },
              scale    : 0, 
              mobile      : true,
            };
            sr.reveal('.from-left-anim-noreset', fromLeftAnimNoReset);

            var fromRightAnimNoReset = {
              origin: 'right',
              reset       : false,
              duration    : 500,
              distance : '150px',
              //easing   : 'ease-in-out',
              //rotate   : { z: 10 },
              scale    : 0, 
              mobile      : true,
            };
            sr.reveal('.from-right-anim-noreset', fromRightAnimNoReset);