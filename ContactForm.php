<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ContactForm</title>
</head>
<body>
<?php
function validateInput($data, $fieldName) {
    global $errorCount;
    if (empty($data)) {
        echo "\"$fieldName\" is a requied field.<br />\n";
        ++$errorCount;
        $retval = "";
    } // checks if $data is empty, and if it is empty it reminds you to fill $fieldName out and increments $errorCount
    else {
        $retval = trim($data);
        $retval = stripslashes($retval);
    } // $retval is $data without whitespace and backslashes

    return($retval);
}
function validateEmail($data, $fieldName) {
    global $errorCount;

    if (empty($data)) {
        echo "\"$fieldName\" is a required field.<br />\n";
        ++$errorCount;
        $retval = "";
    } // same as the first function
    else {
        $retval = filter_var($data, FILTER_SANITIZE_EMAIL);

        if (!filter_var($retval, FILTER_SANITIZE_EMAIL)) {
            echo "\"$fieldName\" is not a valid e-mail address.<br />\n";
        }
    }// makes $retval = $data filtered and checks if $retval is a valid e-mail
return($retval);
}
function displayForm($Sender, $Email, $Subject, $Message) {
    ?> <h2 style="text-align:center">Contact Me</h2>
    <form name="contact" action="ContactForm.php" method="post">
        <p>Your Name:
            <input type="text" name="Sender" value="<?php echo $Sender; ?>" /></p>
        <p>Your E-mail:
            <input type="text" name="Email" value="<?php echo $Email; ?>" /></p>
        <p>Subject:
            <input type="text" name="Subject" value="<?php echo $Subject; ?>" /></p>
        <p>Message:
            <textarea name="Message"><?php echo $Message; ?></textarea></p>
        <p><input type="reset" value="Clear Form" />&nbsp; &nbsp;
            <input type="submit" name="Submit" value="Send Form" /> </p>
    </form>
 <?php } // function makes a form and inputs your information as variables 
 $showForm = true;
 $errorCount = 0;
 $Sender = "";
 $Email = "";
 $Subject = "";
 $Message = "";
 
 if (isset($_POST['Submit'])) {
    $Sender = validateInput($_POST['Sender'],"Your Name");
    $Email = validateEmail($_POST['Email'],"Your E-mail");
    $Subject = validateInput($_POST['Subject'],"Subject");
    $Message = validateInput($_POST['Message'],"Message");
    if ($errorCount === 0) {
        $showForm = false;
    } else {
        $showForm = true;
    }
 }
if ($showForm === true) {
    if ($errorCount > 0) {
        echo "<p>Please re-enter the form information below.</p>\n";
        displayForm($Sender, $Email, $Subject, $Message);
    } // checks if $showForm is true and if $errorCount is over 1 to display the form 
} else {
    $SenderAddress = "$Sender <$Email>";
    $Headers = "From: $SenderAddress\nCC: $SenderAddress\n";

    $result = mail("recipient@example.com", $Subject, $Message, $Headers);

    if ($result) {
        echo "<p>Your message has been sent. Thank you, " . $Sender . "</p>\n";
    } else {
        echo "<p>There was an error sending your message, " . $Sender . ".</p>\n";
    }
}// sends email to the recipients email address and runs an if statement to check if the email was sent succesfully

// Reflection:

/*
What does each function do?
- validateInput: Checks if field is empty, trims and removes slashes, counts errors
- validateEmail: Sanitizes and validates email, counts errors
- displayForm: Displays form with user’s data if there are errors

How is user input protected?
- By trimming, removing slashes, sanitizing email. Missing htmlspecialchars.

What were the most confusing parts?
- Re-checking sanitized email unnecessarily
- Using global $errorCount instead of function returns

What could be improved?
- Add htmlspecialchars to prevent XSS.
- Clean up email validation logic.
- Use structured error handling, not globals.
- Use PHPMailer instead of mail().

Why send a copy of the form to the sender?
- So they know it was sent, have a record, and trust the process.
*/
?>
</body>
</html>