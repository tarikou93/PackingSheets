<?php

namespace PackingSheets\Domain;

class ImageForm
{
	/**
	 * Image name.
	 *
	 * @var String
	 */
	private $img1;

	/**
	 * Image name.
	 *
	 * @var String
	 */
	private $img2;

	/**
	 * Image name.
	 *
	 * @var String
	 */
	private $img3;
	
	/**
	 * Image name.
	 *
	 * @var String
	 */
	private $img4;
	
	/**
	 * Image name.
	 *
	 * @var String
	 */
	private $img5;


	public function getImg1() {
		return $this->img1;
	}

	public function setImg1($img) {
		$this->img1 = $img;
	}

	public function getImg2() {
		return $this->img2;
	}
	
	public function setImg2($img) {
		$this->img2 = $img;
	}

	public function getImg3() {
		return $this->img3;
	}
	
	public function setImg3($img) {
		$this->img3 = $img;
	}
	
	public function getImg4() {
		return $this->img4;
	}
	
	public function setImg4($img) {
		$this->img4 = $img;
	}
	
	public function getImg5() {
		return $this->img5;
	}
	
	public function setImg5($img) {
		$this->img5 = $img;
	}

}

