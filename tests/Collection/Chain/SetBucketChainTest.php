<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection\Chain;

use Novuso\System\Collection\Chain\SetBucketChain;
use Novuso\System\Test\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SetBucketChain::class)]
class SetBucketChainTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        $chain = new SetBucketChain();

        static::assertTrue($chain->isEmpty());
    }

    public function test_that_duplicate_items_do_not_affect_count()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->add('foo');

        static::assertSame(2, count($chain));
    }

    public function test_that_contains_returns_true_when_item_is_in_the_chain()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');

        static::assertTrue($chain->contains('bar'));
    }

    public function test_that_contains_returns_false_when_item_is_not_in_the_chain()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');

        static::assertFalse($chain->contains('baz'));
    }

    public function test_that_contains_returns_false_after_item_is_removed()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->remove('foo');

        static::assertFalse($chain->contains('foo'));
    }

    public function test_that_remove_returns_true_when_item_removed()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');

        static::assertTrue($chain->remove('foo'));
    }

    public function test_that_remove_returns_false_when_item_not_removed()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');

        static::assertFalse($chain->remove('bar'));
    }

    public function test_that_it_is_iterable_forward()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->add('baz');

        for ($chain->rewind(); $chain->valid(); $chain->next()) {
            if ($chain->key() === 1) {
                static::assertSame('bar', $chain->current());
            }
        }
    }

    public function test_that_it_is_iterable_in_reverse()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->add('baz');

        for ($chain->end(); $chain->valid(); $chain->prev()) {
            if ($chain->key() === 1) {
                static::assertSame('bar', $chain->current());
            }
        }
    }

    public function test_that_it_does_not_iterate_beyond_start()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->add('baz');

        for ($chain->end(); $chain->valid(); $chain->prev()) {
            $chain->current();
        }

        $chain->prev();

        static::assertNull($chain->current());
    }

    public function test_that_it_does_not_iterate_beyond_end()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->add('baz');

        for ($chain->rewind(); $chain->valid(); $chain->next()) {
            $chain->current();
        }

        $chain->next();

        static::assertNull($chain->current());
    }

    public function test_that_calling_key_without_valid_item_returns_null()
    {
        $chain = new SetBucketChain();

        static::assertNull($chain->key());
    }

    public function test_that_calling_current_without_valid_item_returns_null()
    {
        $chain = new SetBucketChain();

        static::assertNull($chain->current());
    }

    public function test_that_clone_include_nested_collection()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->add('baz');

        $copy = clone $chain;
        $chain->remove('foo');
        $chain->remove('bar');
        $chain->remove('baz');

        static::assertTrue(
            $copy->contains('foo')
            && $copy->contains('bar')
            && $copy->contains('baz')
        );
    }
}
