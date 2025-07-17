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
?>
</body>
</html>