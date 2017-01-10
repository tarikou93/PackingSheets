<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Content;

class ContentDAO extends DAO
{

    /**
     * Return a list of all Contents, sorted by date (most recent first).
     *
     * @return array A list of all Contents.
     */
    public function findAll() {
        $sql = "select * from t_content order by cont_label";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $contents = array();
        foreach ($result as $row) {
            $contentId = $row['cont_id'];
            $contents[$contentId] = $this->buildDomainObject($row);
        }
        return $contents;
    }

    /**
    * Returns an Content matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Content|throws an exception if no matching Content is found
    */
   public function find($id) {
       $sql = "select * from t_content where cont_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Content matching id " . $id);
   }
   
   /**
    * Saves a content into the database.
    *
    * @param \PackingSheets\Domain\Content $content The content to save
    */
   public function save(Content $content) {
   	
	   	$contentData = array(
	   			'cont_label' => $content->getLabel()
	   	);
	   
	   	if ($content->getId()) {
	   		// The content has already been saved : update it
	   		$this->getDb()->update('t_content', $contentData, array('cont_id' => $content->getId()));
	   	} else {
	   		// The article has never been saved : insert it
	   		$this->getDb()->insert('t_content', $contentData);
	   		// Get the id of the newly created content and set it on the entity.
	   		$id = $this->getDb()->lastInsertId();
	   		$content->setId($id);
   		}
   }
   
   /**
    * Removes a content from the database.
    *
    * @param integer $id The content id.
    */
   public function delete($id) {
   		//Delete the content
   		$this->getDb()->delete('t_content', array('cont_id' => $id));
   }

    /**
     * Creates a Content object based on a DB row.
     *
     * @param array $row The DB row containing Content data.
     * @return \PackingSheets\Domain\Content
     */
    protected function buildDomainObject($row) {
        $content = new Content();
        $content->setId($row['cont_id']);
        $content->setLabel($row['cont_label']);
        return $content;
    }
}
