<?php

namespace App\Tests\Form\Type;

use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $password = 'password';
        $formData = [
            'password' => $password
        ];

        $model = new User();
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(UserType::class, $model);

        $expected = new User();
        $expected->setPassword($password);
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
