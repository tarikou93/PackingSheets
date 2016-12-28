<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\ImageForm;
use PackingSheets\Domain\Image;

class ImageDAO extends DAO
{

	/**
	 * Return a list of all Images, sorted by date (most recent first).
	 *
	 * @return array A list of all Images.
	 */
	public function findAll() {
		$sql = "select * from t_image order by image_id desc";
		$result = $this->getDb()->fetchAll($sql);

		// Convert query result to an array of domain objects
		$images = array();
		foreach ($result as $row) {
			$imageId = $row['image_id'];
			$images[$imageId] = $this->buildDomainObject($row);
		}
		return $images;
	}
	
	/**
	 * Return a list of all Images by PackingId, sorted by date (most recent first).
	 *
	 * @return array A list of all Images for a specified Packing.
	 */
	public function findAllByPacking($packingId) {
		$sql = "select * from t_image where image_packingId = ".$packingId;
		$result = $this->getDb()->fetchAll($sql);
	
		// Convert query result to an array of domain objects
		$images = array();
		foreach ($result as $row) {
			$imageId = $row['image_id'];
			$images[$imageId] = $this->buildDomainObject($row);
		}
		return $images;
	}

	/**
	 * Returns an Image matching the supplied id.
	 *
	 * @param integer $id
	 *
	 * @return \PackingSheets\Domain\Image|throws an exception if no matching Image is found
	 */
	public function find($id) {
		$sql = "select * from t_image where image_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row)
			return $this->buildDomainObject($row);
			else
				throw new \Exception("No Image matching id " . $id);
	}
	
	/**
	 * Converts an image form file into an Image object and uploads files on server.
	 *
	 * @param \PackingSheets\Domain\ImageForm $imageFormObject The image to save, int $packingId The id of the associated Packing
	 */
	public function upload(ImageForm $imageFormObject, $packingId) {

		$images = array();
		
		for ($i = 1; $i <= 5; $i++) {
				
			$imageFile = $imageFormObject->{"getImg".$i}();
			
			if($imageFile !== null){
				
				// Generate a unique name for the file before saving it
				$fileName = md5(uniqid()).'.'.$imageFile->guessExtension();
					
				// Move the file to the directory where brochures are stored
				$imageFile->move(
					$_SERVER['DOCUMENT_ROOT']."/img/",
					$fileName
				);
				
				$image = new Image();
				$image->setName($fileName);
				$image->setPackingId($packingId);
				
				array_push($images, $image);
			}			
		}
		
		return $images;
	}
	
	/**
	 * Saves a image object into the database.
	 *
	 * @param \PackingSheets\Domain\Image $image The image to save
	 */
	public function save(array $images) {
		
		foreach($images as $image){
			
			$imageData = array(
					'image_packingId' => $image->getPackingId(),
					'image_name' => $image->getName()
			);
			
			if ($image->getId()) {
				// The image has already been saved : update it
				$this->getDb()->update('t_image', $imageData, array('image_id' => $image->getId()));
			} else {
				// The article has never been saved : insert it
				$this->getDb()->insert('t_image', $imageData);
				// Get the id of the newly created image and set it on the entity.
				$id = $this->getDb()->lastInsertId();
				$image->setId($id);
			}	
		}		
	}
	
	/**
	 * Removes a image from the database.
	 *
	 * @param integer $id The image id.
	 */
	public function delete($imageId) {
		
		//Delete the image file on server
		
		$fileName = $_SERVER['DOCUMENT_ROOT']."/img/".$this->find($imageId)->getName();
		unlink($fileName);
			
		//Delete the DB image
		
		$this->getDb()->delete('t_image', array('image_id' => $imageId));
	}
	
	/**
	 * Removes all images from the database for a specified Packing.
	 *
	 * @param integer $id The packing id.
	 */
	public function deleteAllByPacking($packingId) {
	
		foreach($this->findAllByPacking($packingId) as $image){
			$this->delete($image->getId());
		}
	}

	/**
	 * Creates a Image object based on a DB row.
	 *
	 * @param array $row The DB row containing Image data.
	 * @return \PackingSheets\Domain\Image
	 */
	protected function buildDomainObject($row) {
		$image = new Image();
		$image->setId($row['image_id']);
		$image->setPackingId($row['image_packingId']);
		$image->setName($row['image_name']);
		return $image;
	}
}

