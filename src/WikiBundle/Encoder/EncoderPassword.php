<?php
namespace WikiBundle\Encoder;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use WikiBundle\Entity\User;
/**
 * Description of EncoderPassword
 *
 * @author matthieudurand
 */
class EncoderPassword {
    
    private $pwdEncoder;
    
    public function __construct(UserPasswordEncoderInterface $pwdEncoder)
    {
        $this->pwdEncoder = $pwdEncoder;
    }
    
    public function encode(User $user)
    {
        //$encoder = $this->container->get('security.password_encoder');
            
            $encoded = $this->pwdEncoder->encodePassword(
                    $user,
                    $user->getRawPassword()
                    );
            $user->setPassword($encoded);
    }
}
