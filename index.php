<?php
    error_reporting(E_ALL^E_NOTICE);
    
    $config = require_once('config.php');
    $data = $_POST['Message'];
    
    if($_POST && $_POST['Mwessage']) {
        $data = $_POST['Message'];
        require_once 'vendors/swift/lib/swift_required.php';
        $transport = Swift_SmtpTransport::newInstance($config['host'], $config['port'], "ssl");
        $transport->setUsername($config['username']);
        $transport->setPassword($config['password']);
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance($data['subject']);
        $message->setFrom(array($data['from'] => $data['from']));
        $message->setTo(array($data['to']));
        $message->setBody($data['body']);        
        $result = $mailer->send($message); 
    }    
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <?=$result?>
    <form action="" method="post">
    <table>
        <tr>
            <td>From: </td>
            <td><input type="email" name="Message[from]" value="<?=$data['from']?>"/></td>
        </tr>
        <tr>
            <td>To: </td>
            <td><input type="email" name="Message[to]"  value="<?=$data['to']?>"/></td>
        </tr>
        <tr>
            <td>Subject: </td>
            <td><input type="text" name="Message[subject]"  value="<?=$data['subject']?>"/></td>
        </tr>
        <tr>
            <td>Body</td>
            <td><textarea name="Message[body]" id="" cols="30" rows="10"> <?=$data['body']?></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Send"/></td>
        </tr>
    </table>        
    </form>
</body>
</html>