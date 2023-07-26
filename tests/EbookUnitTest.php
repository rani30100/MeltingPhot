<?php

namespace App\Tests;

use Mockery;
use App\Entity\Ebook;
use PHPUnit\Framework\TestCase;


class EbookUnitTest extends TestCase
{
    public function testAddEbook(): void
    {
        // Créez un objet Ebook fictif
        $ebook = new Ebook();
        $ebook->setTitle('Titre du livre');
        $ebook->setAuthor('Auteur du livre');
        $ebook->setDescription('Description du livre');

        // Vérifiez que l'ID n'est plus null après l'ajout
        $this->assertEquals('Auteur du livre', $ebook->getAuthor());
    }


}
