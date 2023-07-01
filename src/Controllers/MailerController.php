<?php

namespace App\Controllers;

use App\Entity\User;
use PHPMailer\PHPMailer\PHPMailer;

Class MailerController extends AbstractController
{
    function smtpmailer($to, $from, $from_name, $subject, $body)
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
        //$mail->msgHTML(file_get_contents(ROOT.'/src/Templates/home/contents.html'), $dataMail);
        $mail->AddAddress($to);
        //faire un try catch
        if(!$mail->Send())
        {
            $error ="Essyez plus tard, une erreur est survenue...";
            return $error;
        }
        else
        {
            $error = "Merci, le mail a bien été envoyé!";
            return $error;
        }
    }

    public function confirmMail($params1, $params2)
    {
        $log = intval("$params1");
        $token = $params2;

        if (isset($log) && isset($token) && !empty($log) && !empty($token))
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
                echo "Votre jeton d'identification a expiré";
            }

        } else {
            echo "Une erreur est survenue";
        }
    }
}