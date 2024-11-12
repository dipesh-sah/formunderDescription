<?php declare(strict_types=1);

namespace FormUnderDescription\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;

/**
 * @RouteScope(scopes={"storefront"})
 */
class MailController extends AbstractController
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/send-test-email", name="frontend.mail.send_test_email", methods={"GET"})
     *
     * @throws TransportExceptionInterface
     */
    public function sendMail(): Response
    {
        $mail = (new Email())
            ->from('test@gmail.com')
            ->to('dipesh.bay20@gmail.com')
            ->subject('Test Email')
            ->text('Hello, this is a test email.');

        try {
            $this->mailer->send($mail);
            return new Response('Email sent successfully.', Response::HTTP_OK);
        } catch (TransportExceptionInterface $e) {
            return new Response('Failed to send email: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
