<?php

namespace AppBundle\Entity;

/**
 * Orders
 */
 class Orders
{
    /**
     * @var integer
     */
    private $quantity;

    /**
     * @var \AppBundle\Entity\Dishes
     */
    private $dish;

    /**
     * @var \AppBundle\Entity\Tables
     */
    private $table;


    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Orders
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set dish
     *
     * @param \AppBundle\Entity\Dishes $dish
     *
     * @return Orders
     */
    public function setDish(\AppBundle\Entity\Dishes $dish = null)
    {
        $this->dish = $dish;

        return $this;
    }

    /**
     * Get dish
     *
     * @return \AppBundle\Entity\Dishes
     */
    public function getDish()
    {
        return $this->dish;
    }

    /**
     * Set table
     *
     * @param \AppBundle\Entity\Tables $table
     *
     * @return Orders
     */
    public function setTable(\AppBundle\Entity\Tables $table = null)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return \AppBundle\Entity\Tables
     */
    public function getTable()
    {
        return $this->table;
    }
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
