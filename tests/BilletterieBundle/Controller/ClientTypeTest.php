<?php
/**
 * Created by PhpStorm.
 * User: Julien
 * Date: 18/01/2018
 * Time: 20:47
 */

namespace Billetterie\BilletterieBundle\Tests\Controller;

use Billetterie\BilletterieBundle\Entity\Client;
use Billetterie\BilletterieBundle\Form\ClientType;
use Symfony\Component\Form\Test\TypeTestCase;

class ClientTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'nom' => 'Boulnois',
            'prenom' => 'Julien',
            'pays' => 'France',
            'dateNaissance' => '19-07-1993',
            'tarifReduit' => '0'
        );

        $form = $this->factory->create(ClientType::class);

        $object = new Client();
        $object->setNom('Boulnois');
        $object->setPrenom('Julien');
        $object->setPays('France');
        $object->setDateNaissance(\DateTime::createFromFormat('d-m-Y h:i', '19-07-1993 00:00', new \DateTimeZone("UTC")));
        $object->setTarifReduit("0");

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
