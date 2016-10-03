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
        $sql = "select * from t_content order by cont_id desc";
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
