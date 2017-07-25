<?php

namespace Novuso\Test\System\Collection\Chain;

use Novuso\System\Collection\Chain\ItemBucket;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Chain\ItemBucket
 */
class ItemBucketTest extends UnitTestCase
{
    public function test_that_constructor_takes_item_argument()
    {
        $bucket = new ItemBucket('foo');
        $this->assertSame('foo', $bucket->item());
    }

    public function test_that_next_stores_bucket_instance()
    {
        $bucket = new ItemBucket('foo');
        $next = new ItemBucket('bar');
        $bucket->setNext($next);
        $this->assertSame($next, $bucket->next());
    }

    public function test_that_prev_stores_bucket_instance()
    {
        $bucket = new ItemBucket('foo');
        $prev = new ItemBucket('bar');
        $bucket->setPrev($prev);
        $this->assertSame($prev, $bucket->prev());
    }
}
