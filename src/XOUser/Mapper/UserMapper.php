<?php 
namespace XOUser\Mapper;

class UserMapper extends AbstractMapper implements UserMapperInterface
{
	/**
     * {@inheritDoc} 
	 */
	public function getById($id) 
	{
		$where = ['id' => (int) $id];
		$entity = $this->select($where)->current();
		return $entity;
	}

	/**
     * {@inheritDoc} 
	 */
	public function getByEmail($email) 
	{		
		$where = array('email' => (string) $email);
		$entity = $this->select($where)->current();
		return $entity;
	}

	/**
     * {@inheritDoc} 
	 */
	public function getByUsername($username) 
	{		
		$where = array('username' => (string) $username);
		$entity = $this->select($where)->current();
		return $entity;
	}

	/**
     * {@inheritDoc} 
	 */	
	public function getUser($where)
	{
		$entities = $this->select($where)->current();
		return $entities;
	}

	/**
     * {@inheritDoc} 
	 */	
	public function getAll()
	{
		$entities = $this->select();
		return $entities;
	}	

	/**
     * {@inheritDoc} 
	 */	
	public function insert($data)
	{
		$result = parent::insert($data);
		return $result->getGeneratedValue();
	}

	/**
     * {@inheritDoc} 
	 */	
	public function update($data, $where)
	{
		$result = parent::update($data, $where);
		return $result->getAffectedRows() > 0 ? true : false;
	}

	/**
     * {@inheritDoc} 
	 */	
	public function delete($where)
	{
		$result = parent::delete($where);
		return $result->getAffectedRows() > 0 ? true : false;
	}		
}