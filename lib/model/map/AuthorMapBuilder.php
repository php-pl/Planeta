<?php



class AuthorMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.AuthorMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('author');
		$tMap->setPhpName('Author');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('BLOG_ID', 'BlogId', 'int', CreoleTypes::INTEGER, 'blog', 'ID', false, null);

		$tMap->addColumn('LOGIN', 'Login', 'string', CreoleTypes::VARCHAR, false, 16);

		$tMap->addColumn('PASSWORD', 'Password', 'string', CreoleTypes::VARCHAR, false, 32);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 64);

		$tMap->addColumn('EMAIL', 'Email', 'string', CreoleTypes::VARCHAR, false, 128);

		$tMap->addColumn('VERIFIED', 'Verified', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('FILE', 'File', 'string', CreoleTypes::VARCHAR, false, 16);

	} 
} 