<?php declare(strict_types=1);

namespace Novuso\System\Exception;

/**
 * ImmutableException is thrown when attempting to mutate an immutable value
 *
 * @copyright Copyright (c) 2017, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class ImmutableException extends OperationException
{
}
