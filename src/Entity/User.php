<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=100)
     */
    private $password;

        /**
         * ORM Column(type="string", length=25)
         */
        //private $username;

        /**
         * @ORM\Column(type="string", length=150)
         */
        private $name;

        /**
         * @ORM\Column(type="datetime")
         */
        private $createdAt;

        /**
         * @ORM\OneToMany(targetEntity="App\Entity\MemberDonation", mappedBy="registeredBy")
         */
        private $memberDonations;

        /**
         * @ORM\OneToMany(targetEntity="App\Entity\Donation", mappedBy="registeredBy")
         */
        private $donations;

        /**
         * @ORM\OneToMany(targetEntity="App\Entity\MembershipFees", mappedBy="registeredBy")
         */
        private $membershipFees;

        /**
         * @ORM\OneToMany(targetEntity="App\Entity\Member", mappedBy="registeredBy")
         */
        private $registeredMembers;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

        public function getName(): ?string
        {
            return $this->name;
        }

        public function setName(string $name): self
        {
            $this->name = $name;

            return $this;
        }

        public function getCreatedAt(): ?\DateTimeInterface
        {
            return $this->createdAt;
        }

        public function setCreatedAt(\DateTimeInterface $createdAt): self
        {
            $this->createdAt = $createdAt;

            return $this;
        }

        /**
         * @return Collection|MemberDonation[]
         */
        public function getMemberDonations(): Collection
        {
            return $this->memberDonations;
        }

        public function addMemberDonation(MemberDonation $memberDonation): self
        {
            if (!$this->memberDonations->contains($memberDonation)) {
                $this->memberDonations[] = $memberDonation;
                $memberDonation->setRegisteredBy($this);
            }

            return $this;
        }

        public function removeMemberDonation(MemberDonation $memberDonation): self
        {
            if ($this->memberDonations->contains($memberDonation)) {
                $this->memberDonations->removeElement($memberDonation);
                // set the owning side to null (unless already changed)
                if ($memberDonation->getRegisteredBy() === $this) {
                    $memberDonation->setRegisteredBy(null);
                }
            }

            return $this;
        }

        /**
         * @return Collection|Donation[]
         */
        public function getDonations(): Collection
        {
            return $this->donations;
        }

        public function addDonation(Donation $donation): self
        {
            if (!$this->donations->contains($donation)) {
                $this->donations[] = $donation;
                $donation->setRegisteredBy($this);
            }

            return $this;
        }

        public function removeDonation(Donation $donation): self
        {
            if ($this->donations->contains($donation)) {
                $this->donations->removeElement($donation);
                // set the owning side to null (unless already changed)
                if ($donation->getRegisteredBy() === $this) {
                    $donation->setRegisteredBy(null);
                }
            }

            return $this;
        }

        /**
         * @return Collection|MembershipFees[]
         */
        public function getMembershipFees(): Collection
        {
            return $this->membershipFees;
        }

        public function addMembershipFee(MembershipFees $membershipFee): self
        {
            if (!$this->membershipFees->contains($membershipFee)) {
                $this->membershipFees[] = $membershipFee;
                $membershipFee->setRegisteredBy($this);
            }

            return $this;
        }

        public function removeMembershipFee(MembershipFees $membershipFee): self
        {
            if ($this->membershipFees->contains($membershipFee)) {
                $this->membershipFees->removeElement($membershipFee);
                // set the owning side to null (unless already changed)
                if ($membershipFee->getRegisteredBy() === $this) {
                    $membershipFee->setRegisteredBy(null);
                }
            }

            return $this;
        }
}
