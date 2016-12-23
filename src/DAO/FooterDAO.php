<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Footer;

class FooterDAO extends DAO
{

	/**
	 * Return a list of all footers, sorted by date (most recent first).
	 *
	 * @return array A list of all footers.
	 */
	public function findAll() {
		$sql = "select * from t_footer order by footer_id desc";
		$result = $this->getDb()->fetchAll($sql);

		// Convert query result to an array of domain objects
		$footers = array();
		foreach ($result as $row) {
			$footerId = $row['footer_id'];
			$footers[$footerId] = $this->buildDomainObject($row);
		}
		return $footers;
	}

	/**
	 * Returns an Footer matching the supplied id.
	 *
	 * @param integer $id
	 *
	 * @return \PackingSheets\Domain\Footer|throws an exception if no matching footer is found
	 */
	public function find($id) {
		$sql = "select * from t_footer where footer_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row)
			return $this->buildDomainObject($row);
			else
				throw new \Exception("No footer matching id " . $id);
	}
	
	/**
	 * Saves a footer into the database.
	 *
	 * @param \PackingSheets\Domain\Footer $footer The footer to save
	 */
	public function save(Footer $footer) {
		 
		$footerData = array(
				'footer_text' => $footer->getText()
		);
		 
		if ($footer->getId()) {
			// The footer has already been saved : update it
			$this->getDb()->update('t_footer', $footerData, array('footer_id' => $footer->getId()));
		} else {
			// The article has never been saved : insert it
			$this->getDb()->insert('t_footer', $footerData);
			// Get the id of the newly created footer and set it on the entity.
			$id = $this->getDb()->lastInsertId();
			$footer->setId($id);
		}
	}
	
	/**
	 * Removes a footer from the database.
	 *
	 * @param integer $id The footer id.
	 */
	public function delete($id) {
		//Delete the footer
		$this->getDb()->delete('t_footer', array('footer_id' => $id));
	}

	/**
	 * Creates a footer object based on a DB row.
	 *
	 * @param array $row The DB row containing footer data.
	 * @return \PackingSheets\Domain\Footer
	 */
	protected function buildDomainObject($row) {
		$footer = new Footer();
		$footer->setId($row['footer_id']);
		$footer->setText($row['footer_text']);
		return $footer;
	}
}


