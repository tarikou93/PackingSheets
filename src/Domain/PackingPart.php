<?php

namespace PackingSheets\Domain;

class PackingPart
{
    /**
     * PackingPart id.
     *
     * @var integer
     */
    private $id;

    /**
     * Associated Packing id.
     *
     * @var integer
     */
    private $pack_id;

    /**
     * Associated Part id.
     *
     * @var integer
     */
    private $part_id;

    /**
     * PackingPart quantity.
     *
     * @var integer
     */
    private $quantity;

    /**
     * PackingPart origin.
     *
     * @var string
     */
    private $origin;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPackid() {
        return $this->pack_id;
    }

    public function setPackid($packid) {
        $this->pack_id = $packid;
    }

    public function getPartid() {
        return $this->part_id;
    }

    public function setPartid($partid) {
        $this->part_id = $partid;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getOrigin() {
        return $this->origin;
    }

    public function setOrigin($origin) {
        $this->origin = $origin;
    }

}
