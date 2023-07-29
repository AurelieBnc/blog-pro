<?php

namespace App\Controllers;

use App\Entity\User;
use PHPMailer\PHPMailer\PHPMailer;

Class MailerController extends AbstractController
{

    /**
     * function to send an email
     */
    function smtpmailer(string $to, string $from, string $from_name,string $subject, string $body): void
    {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;

        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = $_ENV['USERMAILER'];
        $mail->Password = $_ENV['PASSMAILER'];
        $mail->IsHTML(true);
        $mail->From = $_ENV['USERMAILER'];
        $mail->FromName = $from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $mail->msgHTML($body);
        $mail->AddAddress($to);
        if(!$mail->Send())
        {
            $error ="Essayez plus tard, une erreur est survenue...";
            echo $error;
        }
        else
        {
            $error = "Merci, le mail a bien été envoyé!";
            echo $error;
        }
    }


    /**
     * function to confirm useraccount by his mail
     *
     *@return self|string
     */
    public function confirmMail(string $params1, string $params2)
    {
        $log = intval("$params1");
        $token = $params2;

        if (!empty($log) && !empty($token))
        {
            $model = new User;
            $confirmUser = $model->find($log);
            $userToken = $confirmUser['token'];

            if ( $token === $userToken )
            {
                $confirmUser = $model->setIs_verified(1);
                $confirmUser->update($log, $model);
                return $this->twig->display('partial/confirmMail.twig');
            } else {
                return "Votre jeton d'identification a expiré";
            }

        } else {
            return "Une erreur est survenue";
        }
    }


}
