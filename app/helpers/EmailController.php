<?php

class EmailController extends Controller {

    private $mailer;

    public function init()
    {
        $transport = new Swift_SmtpTransport(getenv('EMAIL_SMTP'), 25);

        $transport->setUsername(getenv('EMAIL_USER'));
        $transport->setPassword(getenv('EMAIL_PASS'));

        $this->mailer = new Swift_Mailer($transport);
    }

    public function send($recipients_email = [], $subject = '', $template)
    {
        $message = (new Swift_Message($subject))
            ->setFrom([getenv('EMAIL_NOREPLY') => getenv('EMAIL_NOREPLY_NAME')])
            ->setTo($recipients_email)
            ->setBody($template)
            ->setContentType("text/html");

        // Send the message
        $result = $this->mailer->send($message);
    }
}