<?php

namespace App\Entity;

class Search 
{

    /**
     * @var int|null
     */
    private $maxAnnee;

    /**
     * @var int|null
     */
    private $minAnnee;

    /**
     * @var int|null
     */
    private $byMinDuree;

    /**
     * @var int|null
     */
    private $byMaxDuree;

    /**

     * @var string|null
     */
    private $byText;

    /**
     * @var boolean|null
     */
    private $byTraduitFr;

    /**
     * @var boolean|null
     */
    private $bySoustitresFr;

    /**
     * @return  int|null
     */ 
    public function getMaxAnnee()
    {
        return $this->maxAnnee;
    }

    /**
     * @param  int|null  $maxAnnee
     *
     * @return  self
     */ 
    public function setMaxAnnee($maxAnnee)
    {
        $this->maxAnnee = $maxAnnee;

        return $this;
    }

    /**
     * @return  int|null
     */ 
    public function getMinAnnee()
    {
        return $this->minAnnee;
    }

    /**
     * @param  int|null  $minAnnee
     *
     * @return  self
     */ 
    public function setMinAnnee($minAnnee)
    {
        $this->minAnnee = $minAnnee;

        return $this;
    }


    /**
     * Get the value of byMinDuree
     */ 
    public function getByMinDuree()
    {
        return $this->byMinDuree;
    }

    /**
     * Set the value of byMinDuree
     *
     * @return  self
     */ 
    public function setByMinDuree($byMinDuree)
    {
        $this->byMinDuree = $byMinDuree;

        return $this;
    }

    /**
     * Get the value of byMaxDuree
     */ 
    public function getByMaxDuree()
    {
        return $this->byMaxDuree;
    }

    /**
     * Set the value of byMaxDuree
     *
     * @return  self
     */ 
    public function setByMaxDuree($byMaxDuree)
    {
        $this->byMaxDuree = $byMaxDuree;

        return $this;
    }

    /**
     * Get the value of byText
     *
     * @return  string|null
     */ 
    public function getByText()
    {
        return $this->byText;
    }

    /**
     * Set the value of byText
     *
     * @param  string|null  $byText
     *
     * @return  self
     */ 
    public function setByText($byText)
    {
        $this->byText = $byText;

        return $this;
    }

    /**
     * Get the value of byTraduitFr
     *
     * @return  boolean|null
     */ 
    public function getByTraduitFr()
    {
        return $this->byTraduitFr;
    }

    /**
     * @param  boolean|null  $byTraduitFr
     *
     * @return  self
     */ 
    public function setByTraduitFr($byTraduitFr)
    {
        $this->byTraduitFr = $byTraduitFr;

        return $this;
    }

    /**
     * Get the value of bySoustitresFr
     *
     * @return  boolean|null
     */ 
    public function getBySoustitresFr()
    {
        return $this->bySoustitresFr;
    }

    /**
     * Set the value of bySoustitresFr
     *
     * @param  boolean|null  $bySoustitresFr
     *
     * @return  self
     */ 
    public function setBySoustitresFr($bySoustitresFr)
    {
        $this->bySoustitresFr = $bySoustitresFr;

        return $this;
    }
}