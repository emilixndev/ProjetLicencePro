<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Contracts\Translation\TranslatorInterface;

class ChangePasswordFormType extends AbstractType
{
    public $translator;


    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword',PasswordType::class,[
                'label'=>'Mot de passe actuel',

            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => ['autocomplete' => 'new-password'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe.'
                        ]),
                        new Length([
                            'min' => 8,
                            'minMessage' => 'Le mot de passe doit contenir au minimum 8 caractère.',
                            'max' => 4096,
                        ]),
                        new Regex([
                            'pattern'=>"^(?=.*[A-Z])^",
                            'match'=> true,
                            'message'=> 'Le mot de passe doit contenir une majuscule.',

                        ]),
                        new Regex([
                            'pattern'=>"^(?=.*?[0-9])^",
                            'match'=> true,
                            'message'=> 'Le mot de passe doit contenir un chiffre.',

                        ]),
                        new Regex([
                            'pattern'=>"^(?=.*[@$!%*?&])^",
                            'match'=> true,
                            'message'=> 'Le mot de passe doit contenir un caractère spécial (@$!%*?&)',
                        ])
                    ],
                    'label' => 'Nouveau mot de passe',
                ],
                'second_options' => [
                    'attr' => ['autocomplete' => 'new-password'],
                    'label' => 'Confirmer le mot de passe',
                ],
                'invalid_message' =>  'Les deux mots de passe doivent être identiques.',
                'mapped' => false,
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}