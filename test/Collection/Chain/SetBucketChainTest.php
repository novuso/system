<?php

namespace Novuso\Test\System\Collection\Chain;

use Novuso\System\Collection\Chain\SetBucketChain;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Chain\SetBucketChain
 */
class SetBucketChainTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        $chain = new SetBucketChain();
        $this->assertTrue($chain->isEmpty());
    }

    public function test_that_duplicate_items_do_not_affect_count()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->add('foo');
        $this->assertSame(2, count($chain));
    }

    public function test_that_contains_returns_true_when_item_is_in_the_chain()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $this->assertTrue($chain->contains('bar'));
    }

    public function test_that_contains_returns_false_when_item_is_not_in_the_chain()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $this->assertFalse($chain->contains('baz'));
    }

    public function test_that_contains_returns_false_after_item_is_removed()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->remove('foo');
        $this->assertFalse($chain->contains('foo'));
    }

    public function test_that_remove_returns_true_when_item_removed()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $this->assertTrue($chain->remove('foo'));
    }

    public function test_that_remove_returns_false_when_item_not_removed()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $this->assertFalse($chain->remove('bar'));
    }

    public function test_that_it_is_iterable_forward()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->add('baz');
        for ($chain->rewind(); $chain->valid(); $chain->next()) {
            if ($chain->key() === 1) {
                $this->assertSame('bar', $chain->current());
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
                $this->assertSame('bar', $chain->current());
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
            //
        }
        $chain->prev();
        $this->assertNull($chain->current());
    }

    public function test_that_it_does_not_iterate_beyond_end()
    {
        $chain = new SetBucketChain();
        $chain->add('foo');
        $chain->add('bar');
        $chain->add('baz');
        for ($chain->rewind(); $chain->valid(); $chain->next()) {
            //
        }
        $chain->next();
        $this->assertNull($chain->current());
    }

    public function test_that_calling_key_without_valid_item_returns_null()
    {
        $chain = new SetBucketChain();
        $this->assertNull($chain->key());
    }

    public function test_that_calling_current_without_valid_item_returns_null()
    {
        $chain = new SetBucketChain();
        $this->assertNull($chain->current());
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
        $this->assertTrue(
            $copy->contains('foo')
            && $copy->contains('bar')
            && $copy->contains('baz')
        );
    }
}
