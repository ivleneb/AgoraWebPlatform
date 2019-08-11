<?php

namespace App\Entity;

class SearchMember
{
    private $type;

    private $dni;

    private $name;

    private $fatherLastname;

    private $motherLastname;

    /**
     * Get the value of Dni
     *
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set the value of Dni
     *
     * @param mixed dni
     *
     * @return self
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get the value of Name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Father Last Name
     *
     * @return mixed
     */
    public function getFatherLastname()
    {
        return $this->fatherLastname;
    }

    /**
     * Set the value of Father Last Name
     *
     * @param mixed fatherLastname
     *
     * @return self
     */
    public function setFatherLastname($fatherLastname)
    {
        $this->fatherLastname = $fatherLastname;

        return $this;
    }

    /**
     * Get the value of Mother Last Name
     *
     * @return mixed
     */
    public function getMotherLastname()
    {
        return $this->motherLastname;
    }

    /**
     * Set the value of Mother Last Name
     *
     * @param mixed motherLastname
     *
     * @return self
     */
    public function setMotherLastname($motherLastname)
    {
        $this->motherLastname = $motherLastname;

        return $this;
    }

    /**
     * Get the value of Type
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of Type
     *
     * @param mixed type
     *
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

}
