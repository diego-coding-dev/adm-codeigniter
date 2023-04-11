<?php

namespace App\Mail;

class EmployeeMail
{
    private object $mail;

    public function __construct()
    {
        $this->mail = service('email');
    }

    /**
     * Função para enviar o email de ativação
     *
     * @param array $mailData
     * @return boolean
     */
    public function sendActivationEmail(array $mailData): bool
    {
        $this->mail->setFrom(env('email.fromEmail'), env('email.fromName'));
        $this->mail->setTo($mailData['email']);
        $this->mail->setSubject('Email de teste');

        $employeeData['token'] = $mailData['token'];
        $message = view('adm/rh/employee/components/emailActivation', $mailData);

        $this->mail->setMessage($message);

        return $this->mail->send();
    }
}
