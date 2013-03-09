<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * A user management entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="user_profile")
 * @property string $first_name
 * @property string $last_name
 * @property int $id
 */
class UserProfile extends EntityAbstract 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer");
     */
    protected $user_id;    
    
    /**
     * @ORM\Column(type="string")
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string")
     */
    protected $last_name;
    
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="userProfile", cascade="persist")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;
    
    public function setUser(User $user)
    {
        $this->user = $user;
    }    
}