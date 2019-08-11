<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MembershipFeesRepository")
 */
class MembershipFees
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="membershipFees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="membershipFees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $registeredBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registerDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $month;

    /**
     * @ORM\Column(type="smallint")
     */
    private $year;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

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

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }
}
