(function($){
    init = {
        image_edit: ()=> {
            const edit_picture = document.querySelector('#edit_picture');
            function update_picture(e){
                e.preventDefault();
                const image_update_upload = document.querySelector('#image_update_upload');
                if( image_update_upload.classList.contains('hidden') ){
                    image_update_upload.classList.remove('hidden');
                }else{
                    image_update_upload.classList.add('hidden');
                }
            }
            edit_picture.addEventListener('click',update_picture);
        },

        update : function(){      
            const update_user_btn = document.querySelector('#user_update');
            async function user_update(e){
                e.preventDefault();

                const updateForm = document.querySelector('#updateForm');
                const update_user_id = document.querySelector('#update_user_id').value.trim();
                const user_name = document.querySelector('#user_name').value.trim();
                const user_email = document.querySelector('#user_email').value.trim();
                
                //console.log( updateForm,'all edited form values' );
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

                const updatedDatas = new FormData( updateForm );
                console.log( updatedDatas, 'test' );

                try{
                    const response = await fetch( 'update_handler.php',{
                        method : "POST",
                      /*   headers: {
                            'Content-type' : 'application/x-www-form-urlencoded'
                        }, */
                        body : updatedDatas,
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
        init.image_edit();
        init.update();
    });

})(jQuery);