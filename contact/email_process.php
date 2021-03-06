<?php
if(isset($_POST['email'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "blaker1136@gmail.com";



    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }


    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['website']) ||
        !isset($_POST['subject']) ||
        !isset($_POST['message'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }



    $name = $_POST['name']; // required
    $email = $_POST['email']; // required
    $website = $_POST['website']; // required
    $subject = $_POST['subject']; // required
    $message = $_POST['message']; // required


    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp,$email)) {
        $error_message .= 'The Email Address you entered does not big ol test.<br />';

    }

    $string_exp = '/^[a-zA-Z0-9 ]*$/';

    if(!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br />';
    }

    if(!preg_match($string_exp, $subject)) {
        $error_message .= 'The Subject you entered does not appear to be valid.<br />';
    }

    $string_exp = '/^(http|https):\\/\\/[a-z0-9]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i';

    if(!preg_match($string_exp, $website)) {
        $error_message .= 'The Website you entered does not appear to be valid.<br />';
    }

    if(strlen($message) < 2) {
        $error_message .= 'The Message you entered do not appear to be valid.<br />';
    }

    if(strlen($error_message) > 0) {
        died($error_message);
    }

    $email_message = "Form details below.\n\n";


    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }

    $email_subject = $subject;

    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email)."\n";
    $email_message .= "Website: ".clean_string($website)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";

// create email headers
    $headers = 'From: '.$email."\r\n".
        'Reply-To: '.$email."\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);


    setcookie("emailSuccess", "your message has been sent", 0, "/");


    header("Location: https://in-info-web4.informatics.iupui.edu/~bldrober/portfolio/contact.php");
}


?>