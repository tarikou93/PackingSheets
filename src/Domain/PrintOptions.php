<?php

namespace PackingSheets\Domain;

class PrintOptions
{
	/**
	 * PrintOptions header.
	 *
	 * @var string
	 */
	private $header;

	/**
	 * PrintOptions footer.
	 *
	 * @var string
	 */
	private $footer;

	/**
	 * PrintOptions hscodesStatus.
	 *
	 * @var boolean
	 */
	private $hscodesStatus;

	public function getHeader() {
		return $this->header;
	}

	public function setHeader($header) {
		$this->header = $header;
	}

	public function getFooter() {
		return $this->footer;
	}

	public function setFooter($footer) {
		$this->footer = $footer;
	}

	public function getHscodesStatus() {
		return $this->hscodesStatus;
	}

	public function setHscodesStatus($hscodesStatus) {
		$this->hscodesStatus = $hscodesStatus;
	}

}

