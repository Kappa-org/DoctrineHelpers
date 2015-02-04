<?php
/**
 * This file is part of the Kappa\Doctrine package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 *
 * @testCase
 */

namespace KappaTests\Doctrine;

use Doctrine\ORM\Tools\SchemaTool;
use Kappa\Doctrine\Forms\FormItemsCreator;
use Kappa\Doctrine\Reflections\EntityReflectionFactory;
use KappaTests\Mocks\FormItemsEntity;
use KappaTests\ORMTestCase;
use Kdyby;
use Kdyby\Doctrine\QueryObject;
use Nette\DI\Container;
use Tester\Assert;
use Tester\Environment;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Class FormItemsCreatorTest
 *
 * @package Kappa\Doctrine\Tests
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class FormItemsCreatorTest extends ORMTestCase
{
	/** @var FormItemsCreator */
	private $formItemCreator;

	protected function setUp()
	{
		parent::setUp();
		$entity1 = new FormItemsEntity("entity1 title", "entity1 name");
		$entity2 = new FormItemsEntity("entity2 title", "entity2 name");
		$classes = [
			$this->em->getClassMetadata('KappaTests\Mocks\FormItemsEntity'),
		];
		$schemaTool = new SchemaTool($this->em);
		$schemaTool->dropSchema($classes);
		$schemaTool->createSchema($classes);
		$dao = $this->em->getDao('KappaTests\Mocks\FormItemsEntity');
		$dao->save([$entity1, $entity2]);

		$this->formItemCreator = new FormItemsCreator($this->em, [
			'identifierColumn' => 'id',
			'valueColumn' => 'name'
		]);
	}

	public function testStringEntity()
	{
		$data = $this->formItemCreator->create(FormItemsEntity::getClassName(), new GetAll());
		Assert::count(2, $data);
		Assert::true(array_key_exists(1, $data));
		Assert::same('entity1 name', $data[1]);
	}

	public function testObjectEntity()
	{
		$data = $this->formItemCreator->create(new FormItemsEntity("x", "y"), new GetAll());
		Assert::count(2, $data);
		Assert::true(array_key_exists(1, $data));
		Assert::same('entity1 name', $data[1]);
	}

	public function testColumnNames()
	{
		$data = $this->formItemCreator->create(FormItemsEntity::getClassName(), new GetAll(), 'title', 'name');
		Assert::count(2, $data);
		Assert::true(array_key_exists('entity1 name', $data));
		Assert::same('entity1 title', $data['entity1 name']);
	}
}

/**
 * Class GetAll
 *
 * @package Kappa\Doctrine\Tests
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class GetAll extends QueryObject
{
	/**
	 * @param \Kdyby\Persistence\Queryable $repository
	 * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
	 */
	protected function doCreateQuery(Kdyby\Persistence\Queryable $repository)
	{
		return $repository->createQueryBuilder('r')
			->select('r');
	}
}

Environment::lock("database", dirname(TEMP_DIR));

\run(new FormItemsCreatorTest());
