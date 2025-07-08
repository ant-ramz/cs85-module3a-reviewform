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
        /*declaring function that validates user input, function    
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
    
        //alerts user if field is empty and adds tally to variable
            if (empty($data)) {
                echo "$fieldName is a required field.<br />\n";
                ++$errorCount; $retval = "";
        }
        //puts data into variable and validates it to see if it matches the filter type
            else {
                $retval = filter_var($data, FILTER_SANITIZE_EMAIL);
        
        //alerts user if they data entered is not a vailid email
            if (!filter_var($retval,FILTER_VALIDATE_EMAIL)) {
                echo "$fieldName is not a valid e-mail address.<br />\n";
        }
    }
        return($retval);
    }
        //function to display textboxes 
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

        else {
            $SenderAddress = "$Sender <$Email>";
            $Headers = "From $SenderAddress\nCC: $SenderAddress\n";

            $result = mail("recipient@example.com", $Subject, $Message, $Headers);
            //$result = true;
            
            if ($result) {
                echo "<p>Your message has been sent. Thank You, " . $Sender . ".</p>\n";
            }   else {
                echo "<p>There was an error sending your message, " . $Sender . ".</p>\n"; 
            }
            }
    
    ?>
</body>
</html>