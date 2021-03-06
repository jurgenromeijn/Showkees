<?php

namespace Mooi\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Mooi\UserBundle\Entity\User;
use Mooi\UserBundle\Repository\RoleRepository;
use Mooi\WallBundle\Form\Type\ImageType;

class UserType extends AbstractType
{
    
    private $user;
    private $allowRoleChanging;
    private $allowUsernameChanging;
    private $passWordRequired;
    private $allowAvatarUploading;

    public function __construct(User $user, $allowRoleChanging = true, $allowUsernameChanging = true, $passwordRequired = true, $allowAvatarUploading = false)
    {
        $this->user                  = $user;
        $this->allowRoleChanging     = $allowRoleChanging;
        $this->allowUsernameChanging = $allowUsernameChanging;
        $this->passWordRequired      = $passwordRequired;
        $this->allowAvatarUploading  = $allowAvatarUploading;
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $user = $this->user;

        if($this->allowUsernameChanging)
        {
        
            $builder->add('username', 'text', array('label' => 'Gebruikersnaam*'));
        
        }
        $builder->add('first_name', 'text', array('label' => 'Voornaam*'));
        $builder->add('preposition', 'text', array(
            'label'    => 'Tussenvoegsel', 
            'required' => false
        ));
        $builder->add('last_name', 'text', array('label' => 'Achternaam*'));
        $builder->add('gender', 'choice', array(
            'label' => 'Geslacht*',
            'choices' => array(
                User::GENDER_MALE => User::GENDER_MALE,
                User::GENDER_FEMALE => User::GENDER_FEMALE
            ),
            'expanded' => true
        ));
                        
        if($this->allowRoleChanging && $user->getRole()->getId() <= 2)
        {
            
            $builder->add('role', 'entity', array(
                'class' => 'MooiUserBundle:Role',
                'label' => 'Account type*',
                'preferred_choices' => array(4),
                'query_builder' => function(RoleRepository $repository) use ($user) 
                {
                                
                    return $repository->createQueryBuilder('r')
                                ->where('r.id >= :role_id')
                                ->orderBy('r.id', 'DESC')
                                ->setParameter('role_id', $user->getRole()->getId());
                
                }
            ));
            
        }

        if($this->passWordRequired)
        {
            $builder->add('password', 'repeated', array (
                'required'        => true,
                'type'            => 'password',
                'first_name'      => 'Wachtwoord*',
                'second_name'     => 'Bevestig wachtwoord*',
                'invalid_message' => 'De wachtwoorden komen niet overeen!'
            ));
        }
        else
        {
            $builder->add('password', 'repeated', array (
                'required'        => false,
                'type'            => 'password',
                'first_name'      => 'Wachtwoord',
                'second_name'     => 'Bevestig wachtwoord',
                'invalid_message' => 'De wachtwoorden komen niet overeen!'
            ));
        }
        
        if($this->allowAvatarUploading)
        {
            
            $builder->add('avatar', new ImageType(), array(
                'required' => false,
                'label'    => "Avatar"
            ));
            
        }

        
    }

    public function getName()
    {
        
        return 'user';
        
    }

    public function getDefaultOptions(array $options)
    {
        
        return array(
            'data_class'      => 'Mooi\UserBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'user'
        );
        
    }
    
}

?>
