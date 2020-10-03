<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;
    public $otp;
    public $linkMail;
    public $nombreCompleto;
    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($otp)
     {
       $this->otp = $otp;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->getNombreCompleto();
        $this->linkMail = "http://localhost:4200/activar?otp=".$this->otp->otp;
        return $this->view('mails.activar');
    }

    public function getNombreCompleto(){
      $this->nombreCompleto = $this->otp->nombre;

      if(property_exists($this->otp, "apellidoPaterno")){
        $this->nombreCompleto = $this->nombreCompleto." ".$this->otp->apellidoPaterno;
      }
      if(property_exists($this->otp, "apellidoMaterno")){
        $this->nombreCompleto = $this->nombreCompleto." ".$this->otp->apellidoMaterno;
      }
    }
}
