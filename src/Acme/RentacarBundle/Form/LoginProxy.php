<?php

namespace Acme\RentacarBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Acme\RentacarBundle\Entity\User;
use Acme\RentacarBundle\Entity\UserRepository;

/**
 * LoginProxy.
 *
 * @author Katsuhiro Ogawa <ko.fivestar@gmail.com>
 *
 * @Assert\Callback(methods={"authenticate"})
 */
class LoginProxy
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var User
     */
    private $user;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Authenticate.
     *
     * @param ExecutionContext $context
     */
    public function authenticate(ExecutionContext $context)
    {
        if (strlen($this->email) > 0 && strlen($this->password) > 0) {
            $user = $this->userRepository->authenticateUser($this->email, $this->password);

            if ($user) {
                $this->user = $user;
            } else {
                $context->addViolation('メールアドレスかパスワードが間違っています', array(), $this);
            }
        } else {
            $context->addViolation('メールアドレスとパスワードを入力してください', array(), $this);
        }
    }

    /**
     * Get login user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
