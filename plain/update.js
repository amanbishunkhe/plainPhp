(function($){
    init = {
        update : function(){      
            const update_user_btn = document.querySelector('#user_update');
            async function user_update(e){
                e.preventDefault();
                console.log('tes');

                const updateForm = document.querySelector('#updateForm');
                const update_user_id = document.querySelector('#update_user_id').value.trim();
                const user_name = document.querySelector('#user_name').value.trim();
                const user_email = document.querySelector('#user_email').value.trim();
               
                //client side name validation
                if( !user_name || user_name.length < 3 ){
                    alert( "Name cannot be empty or less than 3 character" );
                    return;
                }
                if( user_email ){
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if( !emailPattern.test(user_email) ){
                        alert( "Enter a valid email" );
                    }
                }

                const updatedata = new URLSearchParams();
                updatedata.append('user_name',user_name);
                updatedata.append( 'user_email',user_email );
                updatedata.append( 'user_id',update_user_id );

                console.log( updatedata );

                try{
                    const response = await fetch( 'update_handler.php',{
                        method : "POST",
                        headers: {
                            'Content-type' : 'application/x-www-form-urlencoded'
                        },
                        body : updatedata.toString(),
                    } );

                    const result = await response.text();
                    window.location.href = 'display.php';

                }catch( error ){

                }

            }
            update_user_btn.addEventListener('click',user_update);
        }
    }

    $(function(){
        init.update();
    });

})(jQuery);