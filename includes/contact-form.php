<?php
/**
 * Contact Form
 * 
 * Render form markup
 * Create shortcode to display form
 * 
 * https://developer.wordpress.org/reference/functions/add_shortcode/
 * 
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//Create a simple contact email form using standard HTML and a few PHP requests

function cf_html_form_code() {
    echo "<div class='cfdiv'>"; 
        echo "<center><h2 class='cfclass'>Contact Us</h2></center>"; 

    echo '<form class="cfform" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">'; //className
        echo '<p>';
            echo 'Your First Name(required) <br/>';
            echo '<input class="cfinput" type="text" name="cf-fname" required pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-fname"] ) : '' ) . '" size="2" />'; //className
        echo '</p>';
        echo '<p>';
            echo 'Your Last Name(required) <br/>';
            echo '<input class="cfinput" type="text" name="cf-lname" required pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-lname"] ) : '' ) . '" size="2" />'; //className
        echo '</p>';
        //Append the code above to collect both:
        //       First Name using "cf-fname" for name and value
        //       Last Name using "cf-lname" for name and value
        echo '<p>';
            echo 'Email: <input class="cfinput" type="text" name="cf-email" required value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="2" />'; //className
        echo '</p>';

        echo '<p>';
            echo 'Subject: <input class="cfinput" type="text" name="cf-subject"required value="' . ( isset( $_POST["cf-subject"] ) ? esc_attr( $_POST["cf-subject"] ) : '' ) . '" size="2" />'; //className
        echo '</p>';
        //Duplicate the preceeding code and edit it to create inputs for:
        //       An input to collect "Your Email" use "cf-email" for name and value
        //       An input to collect "Subject" use "cf-subject" for name and value
        echo '<p>';
            echo 'Message: <textarea class="cfinput" rows="8" cols="12" name="cf-message" required>' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>'; //className
        echo '</p>';
            echo'<p><input class="cfinput" type="submit" name="cf-submitted" value="Send"/></p>'; //className
        echo '</form>';
    echo "</div>";
}
//Check and clean the email of any disturbing stuffola and then send it out
function cf_deliver_mail() {//if the submit button is clicked, send the email -- note that above the submit button is named "cf_submitted
  if ( isset( $_POST['cf-submitted'] ) ) { $subject = esc_attr( 'Message from WordPress' );// sanitize form values -- each line checks the input that carries that name from above 
        $fname = sanitize_text_field( $_POST["cf-fname"] );
        $lname = sanitize_text_field( $_POST["cf-lname"] );
        $subject = sanitize_text_field( $_POST["cf-subject"] );
        $email = sanitize_text_field( $_POST["cf-email"] );
        $message = sanitize_textarea_field( $_POST["cf-message"] );
         //Using $fname replacing the function "sanitize_email" in place of "santitize_text_field" create a sanitize statement for email
         //Using $fname as an example create a sanitize statement for subject
         $name = $fname . " " . $lname;
/* Build email content string */
         $email_content = "First Name: " . "$fname" . "\r\n";
         $email_content .= "Last Name: " . "$lname" . "\r\n";
         $email_content .= "Email: " . "$email" . "\r\n";
         $email_content .= "Subject: " . "$subject" . "\r\n";
         $email_content .= "Message: " ." $message" . "\r\n";//this creates a variable that will return "Firstname Lastname"//notice the insertion of a spacebar surrounded in quotes (in php a "." acts like a "+" sign)//the get_option() function retrieves the blog administrator's email address
        //as an alternate you could just set this variable $to = 'johndoe@highline.com' (or any email address in quotes)
        $to = get_option( 'admin_email' );
        
        $headers = "From: $name <$to>" . "\r\n"; //creates header variable for email and adds the name and email address to the variable
        //var_dump echoes user input to screen for debugging. Remove // to activate.
        //echo '<div><pre>';
        //var_dump( $email_content, $to, esc_attr( $headers ) );
        //echo '</pre></div>';
        // If everything is okay and an email has been processed for sending, display a success message for the customer
        if ( wp_mail( $to, $subject, $email_content, $headers ) ) 
        {
            echo '<div>';
            echo '<p>Thanks for Sending Your Email. We will get back to you soon.</p>';
            echo '</div>';
        } 
        else 
        { //If everything is not okay send this message to the customer
            echo '<div>';
            echo 'An unexpected error occurred';
            echo '</div>';
        }
    }
}//this function calls the deliver_mail and html_form_code
function cf_shortcode() {
    ob_start(); //This PHP function turns on auto buffering
    cf_deliver_mail(); //Calls the function
    cf_html_form_code(); // calls the function
    return ob_get_clean(); //Discards the buffer contents
}
//This function registers my shortcode with WordPress and calls the function above = cf_shortcode
add_shortcode( 'landscape_contact_form', 'cf_shortcode' );