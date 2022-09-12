<?php

namespace App\Tests\Form\Type;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use Symfony\Component\Form\Test\TypeTestCase;

class CategoryTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $title = 'some category';
        $formData = [
            'title' => $title
        ];

        $model = new Category();
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(CategoryType::class, $model);

        $expected = new Category();
        $expected->setTitle($title);
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
