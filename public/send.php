<?php

    header('Access-Control-Allow-Origin:*');
    header('Content-Tyle: application/json; charset=UTF-8');



    $result = [];
    $visitor_name = '';
    $visitor_email = '';
    $visitor_phone = '';
    $visitor_message = '';

    $error_found = 0;

    if (isset($_POST['name'])) {
        if (empty($_POST['name'])) {
            $error_found += 1;
        } else {
            $visitor_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        }
    }

    if (isset($_POST['email'])) {
        if (empty($_POST['email'])) {
            $error_found += 1;
        } else {
            $visitor_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        }
    }
    if (isset($_POST['phone'])) {
        if (empty($_POST['phone'])) {
            $error_found += 1;
        } else {
            $visitor_phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
        }
    }

    if (isset($_POST['question'])) {
        $visitor_message = filter_var(htmlspecialchars($_POST['question'], FILTER_SANITIZE_STRING));
    }


    $result['name'] = $visitor_name;
    $result['email'] = $visitor_email;
    $result['message'] = $visitor_message;
    $result['phone'] = $visitor_phone;

    if ($error_found === 0) {
        $email_recipient_one = 'steve@rawlingfinancial.com';
        $email_recipient_two = 'hugh@rawlingfinancial.com';

        $email_subject = 'Inquiry from Rawling Financial website';
        $email_message = sprintf('Name: %s, Email: %s, Phone: %s, Message: %s', $visitor_name, $visitor_email, $visitor_phone, $visitor_message);
        $email_headers = array(
    'From' => 'noreply@yourdomain.ca',
    'Reply-To' => $visitor_email,
);

        mail($email_recipient_one, $email_subject, $email_message, $email_headers);

        $email_result = mail($email_recipient_two, $email_subject, $email_message, $email_headers);

        if ($email_result) {
            $message= sprintf('Thank you for contacting us, %s! We will contact you shortly.', $visitor_name);
        } else {
            $message= 'We are sorry your email did not go through';
        }
        $error_found = 0;
    } else {
        $message= 'Please, fill in all the information';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css"><link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <title>Rawling Financial INC - Homepage</title>
<h2><?php echo $message;?></h2>
<a href="contact.php">Go back to the website</a>
    <section class="footerSection">
    <a href="legal.php">Legal Information</a>
    <p>2021 Rawling Financial Inc</p>
</section>

</footer>
</html>
