<?php

namespace Helpers;

use \Core\Controller as Controller;

/**
 * Used for handling emails
 */
class EmailController extends Controller {

    /**
     * Swift Mailer controller
     *
     * @var Class
     */
    private $mailer;

    /**
     * Called on the controller creation
     *
     * @return void
     */
    public function init()
    {
        $transport = new \Swift_SmtpTransport(getenv('EMAIL_SMTP'), 25);

        $transport->setUsername(getenv('EMAIL_USER'));
        $transport->setPassword(getenv('EMAIL_PASS'));

        $this->mailer = new \Swift_Mailer($transport);
    }

    /**
     * Sends an email out
     *
     * $email_controller->send(
     *       array(
     *          'example@email.com' => 'You can send their name too',
     *          'youdontneedtothough@email.com'
     *       ),
     *       'Subject title as a string',
     *       $this->twig->render('email/example.html')
     *  );
     *
     *
     * @param array $recipients_email
     * @param string $subject
     * @param string Twig rendered template
     *
     * @return Object
     */
    public function send($recipients_email = [], $subject = '', $template)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom([getenv('EMAIL_NOREPLY') => getenv('EMAIL_NOREPLY_NAME')])
            ->setTo($recipients_email)
            ->setBody($template)
            ->setContentType("text/html");

        // Send the message
        $result = $this->mailer->send($message);

        return $result;
    }
}