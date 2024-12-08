// script.js

(function($){  

    fire = {
        form_events: function(){
            const form = document.getElementById('userForm');     
            async function formsubmit(event){
                event.preventDefault();

                // Get form data
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();

                // Client-side validation
                if (!name) {
                    alert("Name field cannot be empty.");
                    return;
                }

                if (name.length < 3) {
                    alert("Name must be at least 3 characters long.");
                    return;
                }

                // Simple email validation using regex
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    alert("Please enter a valid email address.");
                    return;
                }

                // Prepare form data for POST request
                const formData = new URLSearchParams();
                formData.append('name', name);
                formData.append('email', email);

                console.log( formData,'form' );

                // Send data to the server using Fetch API (POST method)
                try {
                    const response = await fetch('insert.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: formData.toString(),
                    });

                    const result = await response.text();
                    alert(result);

                    // Redirect to display.php after successful insertion
                    window.location.href = 'display.php';
                } catch (error) {
                    console.error('Error:', error);
                    alert('Failed to add user.');
                }


            }
            const userSubmit = document.querySelector('#userSubmit');
            userSubmit.addEventListener('click', formsubmit);
        }
    }

    $(function(){
        fire.form_events();
    });

})(jQuery);