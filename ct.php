  <html>
        <body>
            <form action="" method="post">
                <?php
                    # Get the reCAPTCHA library
                    require_once('recaptchalib.php');

                    # These are /not/ real keys - you must replace them with your *own* keys
                    # obtained from http://recaptcha.net/api/getkey
                    define('PUBLIC_KEY',  '6Le5BboSAAAAAPp8Q9bXZ3_WJ7Bfilob1Sxpv0w5');
         define('PRIVATE_KEY', '6Le5BboSAAAAAFllotofRSUAXyHy2jB1Q2Ljwut6');

                    # Did the user fail the captcha test?
                    $error = null;

                    # This is where we process the user's response. We don't
                    # do this when the form is initially displayed - only
                    # when the user submits it.
                    if ($_POST["recaptcha_response_field"]) {
                        $response = recaptcha_check_answer( 
                            PRIVATE_KEY, $_SERVER['REMOTE_ADDR'],
                            $_POST['recaptcha_challenge_field'],
                            $_POST['recaptcha_response_field']
                        );

                        if ( $response->is_valid ) {
                            # The user passed the reCAPTCHA test: form submission should continue
                            # Your other form validation logic should go here.
                        
                            # For example
                            # ... validate user input ...
                            # ... store form data in a database ...
                            # ... redirect to 'thank you' page
                        
                        }
                        else {
                            # The user failed the reCAPTCHA test so we need
                            # to fill in the error message and re-try the
                            # form submission
                            $error = $response->error;
                        }
                    }
                
                    # Display the reCAPTCHA challenge. The first time
                    # through $error will be null. 

                    echo recaptcha_get_html( PUBLIC_KEY, $error );
                ?>
                <br />
                <!-- example form fields - your own fields go here -->
                Username: <input type="text" name="username" value="" /><br />
                Email address: <input type="text" name="email"    value="" /><br />
                <input type="submit" value="submit" />
            </form>
        </body>
    </html>