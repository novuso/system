<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection\Chain;

use Novuso\System\Collection\Chain\KeyValueBucket;
use Novuso\System\Test\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Chain\KeyValueBucket
 */
class KeyValueBucketTest extends UnitTestCase
{
    public function test_that_constructor_takes_key_argument()
    {
        $bucket = new KeyValueBucket('foo', 'bar');
        $this->assertSame('foo', $bucket->key());
    }

    public function test_that_constructor_takes_value_argument()
    {
        $bucket = new KeyValueBucket('foo', 'bar');
        $this->assertSame('bar', $bucket->value());
    }

    public function test_that_next_stores_bucket_instance()
    {
        $bucket = new KeyValueBucket('foo', 'bar');
        $next = new KeyValueBucket('baz', 'buz');
        $bucket->setNext($next);
        $this->assertSame($next, $bucket->next());
    }

    public function test_that_prev_stores_bucket_instance()
    {
        $bucket = new KeyValueBucket('foo', 'bar');
        $prev = new KeyValueBucket('baz', 'buz');
        $bucket->setPrev($prev);
        $this->assertSame($prev, $bucket->prev());
    }
}
