<?php
/**
 * This file is part of the Kappa\Doctrine package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Doctrine;

/**
 * Class InvalidArgumentException
 *
 * @package Kappa\Doctrine
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class InvalidArgumentException extends \LogicException
{

}

/**
 * Class EntityNotFoundException
 *
 * @package Kappa\Doctrine
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class EntityNotFoundException extends \LogicException
{

}

/**
 * Class NotQueryBuilderException
 *
 * @package Kappa\Doctrine
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class NotQueryBuilderException extends \LogicException
{

}
