<?php 
namespace App\Core;

// Inclusión de clases necesarias
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;


// Clase para enviar correos electrónicos
class EmailSender {

    // Propiedades de la clase 
    // Transporte de correo
    private $transport;
    
    // Instancia de la clase Mailer
    private $mailer;

    // Constructor de la clase
    function __construct() {
        // Configura el transporte de correo
        $this->transport = Transport::fromDsn($_ENV['SMTP_SERVER']);
        // $this->transport->setUsername($_ENV['SMTP_USER']);
        // $this->transport->setPassword($_ENV['SMTP_PASS']);
        $this->mailer = new Mailer($this->transport);
    }

    // Método para enviar un correo de confirmación
    public function sendConfirmationMail($name, $surname, $email, $token) {
        // Crea una instancia de la clase Email
        $email = (new Email())
            ->from('enriquemarino.j@gmail.com')
            ->to($email)
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Verificacion de creacion de personaje')
            // ->text('')
            ->html('<p>Necesitas validar tu cuenta antes de poder loguearte. ¡Tienes 24 horas para poder hacerlo!</p><br><a href="http://rolcharacter.local/verificacion/'.$token.'">VALIDA TU CORREO</a>');

        $this->mailer->send($email);
    }
}

?>