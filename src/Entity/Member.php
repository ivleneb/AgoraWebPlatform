<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $fatherLastname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $motherLastname;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $district;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $province;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $degreeOfInstruction;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $civilStatus;

    /**
     * @ORM\Column(type="integer")
     */
    private $dni;

    /**
     * @ORM\Column(type="integer")
     */
    private $cellphoneNumber;

    /**
     * @ORM\Column(type="boolean")
     */
    private $nonVirtualRegister;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="registeredMembers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $registeredBy;

    /**
     * @ORM\Column(type="date")
     */
    private $registerDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MemberDonation", mappedBy="member")
     */
    private $donations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MembershipFees", mappedBy="member")
     */
    private $membershipFees;

    public function __construct()
    {
        $this->donations = new ArrayCollection();
        $this->membershipFees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFatherLastname(): ?string
    {
        return $this->fatherLastname;
    }

    public function setFatherLastname(string $fatherLastname): self
    {
        $this->fatherLastname = $fatherLastname;

        return $this;
    }

    public function getMotherLastname(): ?string
    {
        return $this->motherLastname;
    }

    public function setMotherLastname(string $motherLastname): self
    {
        $this->motherLastname = $motherLastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(string $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getDegreeOfInstruction(): ?string
    {
        return $this->degreeOfInstruction;
    }

    public function setDegreeOfInstruction(string $degreeOfInstruction): self
    {
        $this->degreeOfInstruction = $degreeOfInstruction;

        return $this;
    }

    public function getCivilStatus(): ?string
    {
        return $this->civilStatus;
    }

    public function setCivilStatus(string $civilStatus): self
    {
        $this->civilStatus = $civilStatus;

        return $this;
    }

    public function getDni(): ?int
    {
        return $this->dni;
    }

    public function setDni(int $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getCellphoneNumber(): ?int
    {
        return $this->cellphoneNumber;
    }

    public function setCellphoneNumber(int $cellphoneNumber): self
    {
        $this->cellphoneNumber = $cellphoneNumber;

        return $this;
    }

    public function getNonVirtualRegister(): ?bool
    {
        return $this->nonVirtualRegister;
    }

    public function setNonVirtualRegister(bool $nonVirtualRegister): self
    {
        $this->nonVirtualRegister = $nonVirtualRegister;

        return $this;
    }

    public function getRegisteredBy(): ?User
    {
        return $this->registeredBy;
    }

    public function setRegisteredBy(?User $registeredBy): self
    {
        $this->registeredBy = $registeredBy;

        return $this;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(\DateTimeInterface $registerDate): self
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * @return Collection|MemberDonation[]
     */
    public function getDonations(): Collection
    {
        return $this->donations;
    }

    public function addDonation(MemberDonation $donation): self
    {
        if (!$this->donations->contains($donation)) {
            $this->donations[] = $donation;
            $donation->setMember($this);
        }

        return $this;
    }

    public function removeDonation(MemberDonation $donation): self
    {
        if ($this->donations->contains($donation)) {
            $this->donations->removeElement($donation);
            // set the owning side to null (unless already changed)
            if ($donation->getMember() === $this) {
                $donation->setMember(null);
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
            $membershipFee->setMember($this);
        }

        return $this;
    }

    public function removeMembershipFee(MembershipFees $membershipFee): self
    {
        if ($this->membershipFees->contains($membershipFee)) {
            $this->membershipFees->removeElement($membershipFee);
            // set the owning side to null (unless already changed)
            if ($membershipFee->getMember() === $this) {
                $membershipFee->setMember(null);
            }
        }

        return $this;
    }
}
