<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection\Chain;

use Novuso\System\Collection\Chain\TerminalBucket;
use Novuso\System\Test\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(TerminalBucket::class)]
class TerminalBucketTest extends UnitTestCase
{
    public function test_that_next_stores_bucket_instance()
    {
        $bucket = new TerminalBucket();
        $next = new TerminalBucket();
        $bucket->setNext($next);

        static::assertSame($next, $bucket->next());
    }

    public function test_that_prev_stores_bucket_instance()
    {
        $bucket = new TerminalBucket();
        $prev = new TerminalBucket();
        $bucket->setPrev($prev);

        static::assertSame($prev, $bucket->prev());
    }
}
