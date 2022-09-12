<?php
/**
 * Bug type.
 */

namespace App\Form\Type;

use App\Entity\Bug;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BugType.
 */
class BugType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param array<string, mixed> $options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'Tytuł',
                'required' => true,
                'attr' => ['max_length' => 64],
            ]);
        $builder->add(
            'description',
            TextType::class,
            [
                'label' => 'Opis',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]);

        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category): string {
                    return $category->getTitle();
                },
                'label' => 'Kategoria',
                'placeholder' => 'label.none',
                'required' => true,
            ]);
        $builder->add(
          'status',
          CheckboxType::class,
          [
              'label' => 'Status',
              'required' => false,
          ]);
    }

    /**
     * Configures the options for this type.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Bug::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     */
    public function getBlockPrefix(): string
    {
        return 'bug';
    }
}
