<?php

namespace App\Tests;

use App\Entity\Message;
use PHPUnit\Framework\TestCase;

class ContactFormUnitTest extends TestCase
{
    public function testFieldEmail(): void
    {
        // Créez un objet Message fictif pour tester le formulaire
        $message = new Message();
        $message->setEmail('test@example.com');

        // Vérifiez si le champ email est valide
        $isValid = $this->isEmailValid($message->getEmail());

        // Assurez-vous que le champ email est valide
        $this->assertTrue($isValid);
    }

    private function isEmailValid(?string $email): bool
    {
        // Utilisez une validation simple pour vérifier si l'email est rempli
        // Vous pouvez implémenter une validation plus complexe si nécessaire
        return !empty($email);
    }

    public function testFieldEmailNotValid(): void
    {
        $message = new Message();
        $message->setEmail('ghh');
        
        $isNotValid = $this->isEmailNotValid($message->getEmail());
    
        // Assurez-vous que le champ email n'est pas valide
        $this->assertTrue($isNotValid);
    }
    
    
    public function isEmailNotValid(?string $email): bool
    {
        // Filtre la validation en fonction de l'email
        return !filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    
    
}
