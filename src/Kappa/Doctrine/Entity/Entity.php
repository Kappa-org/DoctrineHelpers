<?php
/**
 * This file is part of the Kappa/Doctrine package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Doctrine\Entity;

use Kappa\Doctrine\InvalidPropertyNameException;
use Kdyby\Doctrine\Entities\BaseEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Entity
 * @package Kappa\Doctrine
 */
abstract class Entity extends BaseEntity
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var int
	 */
	protected $id;

	/**
	 * @param array $data
	 * @throws \Kappa\Doctrine\InvalidPropertyNameException
	 */
	public function __construct(array $data = array())
	{
		$properties = get_object_vars($this);
		foreach ($data as $key => $value) {
			if (!array_key_exists($key, $properties)) {
				throw new InvalidPropertyNameException("Unknown property '{$key}'");
			}
			$this->$key = $value;
		}
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return array
	 */
	public function __toArray()
	{
		return array_merge(array('id' => $this->getId()), get_object_vars($this));
	}
}