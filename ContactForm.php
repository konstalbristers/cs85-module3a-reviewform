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
        echo "\"$fieldName\" is a requied field.<br />\n";
        ++$errorCount;
        $retval = "";
    } // same as the first function
    else {
        $retval = filter_var($data, FILTER_SANITIZE_EMAIL);

        IF (!filter_var($retval, FILTER_SANITIZE_EMAIL)) {
            echo "\"$fieldName\" is not a valid e-mail address.<br />\n";
        }
    }// makes $retval = $data filtered amd checks if $retval is a valid e-mail
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
?>
</body>
</html>