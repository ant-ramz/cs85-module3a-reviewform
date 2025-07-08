<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Me</title>
    <style>

    </style>
</head>
<body>
    <?php
       
       /* validates user input, function    
        will check to see if the parameter is filled, if not, 
        a message will appear to the user, and add a tally to the errorCount variable.*/
        
        function validateInput($data, $fieldName) {
            global $errorCount;
            if (empty($data)) {
                echo "$fieldName is a required field.<br />\n";
                ++$errorCount;
                $retval = "";
        }
            else {
                //cleanups input by removing any spaces or backshlash's
                $retval = trim($data);
                $retval = stripslashes($retval);
        }

        return($retval);}

        function validateEmail($data, $fieldName) {
        global $errorCount;
    
        //checks if field is empty, will notify user and tally errorCount variable
            if (empty($data)) {
                echo "$fieldName is a required field.<br />\n";
                ++$errorCount; $retval = "";
        }
        // otherwise will sanitize data to make sure it is an email
            else {
                $retval = filter_var($data, FILTER_SANITIZE_EMAIL);
        
        //if not, alerts user
            if (!filter_var($retval,FILTER_VALIDATE_EMAIL)) {
                echo "$fieldName is not a valid e-mail address.<br />\n";
        }
    }
        return($retval);
    }
        //function to display form with textboxes 
        function displayForm($Sender, $Email, $Subject, $Message) {
            ?> <h2 style = "text-align: center">Contact Me</h2>
            <form name="contact" action="ContactForm.php" method="post">
                <p>Your Name:
                    <input type="text" name="Sender" value="<?php echo $Sender; ?>" /></p>
                <p>Your Email:
                    <input type="text" name="Email" value="<?php echo $Email; ?>" /></p>
                <p>Your Subject:
                    <input type="text" name="Subject" value="<?php echo $Subject; ?>" /></p>
                <p>Your Message:
                    <input type="text" name="Message"><?php echo $Message; ?></textarea></p>
                <p><input type="reset" value="Clear Form" />&nbsp; &nbsp;
                    <input type="submit" name="Submit" value="Send Form" /></p>
            </form>

            <?php }
        
        
        $showForm = TRUE;
        $errorCount = 0;
        $Sender = "";
        $Email = "";
        $Subject = "";
        $Message = "";

        //validating entered user data, if error count = 0, form will no longer show

        if (isset($_POST['Submit'])) {
            $Sender = validateInput($_POST['Sender'],"Your Name");
            $Email = validateEmail($_POST['Email'],"Your Email");
            $Subject = validateInput($_POST['Subject'],"Subject");
            $Message = validateInput($_POST['Message'],"Message");
            if ($errorCount==0)
                $showForm = FALSE;
            else
                $showForm = TRUE;
        }

        //If errorCount vaiable tally is more than 0, user will be notified to re-enter information

        if ($showForm == TRUE) {
            if ($errorCount>0)
            echo "<p>Please re-enter the form information below. </p>\n";
            displayForm($Sender, $Email, $Subject, $Message);
        }

        //otherwise, user will get a notice that the message was either successfull or unscuccesfull 
        else {
            $SenderAddress = "$Sender <$Email>";
            $Headers = "From: $SenderAddress\nCC: $SenderAddress\n";

            $result = mail("recipient@example.com", $Subject, $Message, $Headers);
            //$result = true;
            
            if ($result) {
                echo "<p>Your message has been sent. Thank You, " . $Sender . ".</p>\n";
            }   else {
                echo "<p>There was an error sending your message, " . $Sender . ".</p>\n"; 
            }
            }

    /*MY DEBUGGING LOG: 
   Problem 1: the $showForm variable was being entered as $ShowForm on lines 81 and 83 
   causing the the rest of the code to not display properly after succesful entry.
            Fix - Update variable name to correct lowercase start.
   Problem 2: error message: Warning: mail(): SMTP server response: 553 We do not relay non-local mail, sorry. 
   in C:\xampp\htdocs\cs85_projects\ContactForm.php on line 103 There was an error sending your message, Anthony.
            Fix - updated $result variable to equal true to simulate a successful sent message*/
    
    ?>
</body>
</html>