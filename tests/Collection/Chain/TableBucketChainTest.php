<?php declare(strict_types=1);

namespace Novuso\System\Test\Collection\Chain;

use Novuso\System\Collection\Chain\TableBucketChain;
use Novuso\System\Exception\KeyException;
use Novuso\System\Test\TestCase\UnitTestCase;

/**
 * @covers \Novuso\System\Collection\Chain\TableBucketChain
 */
class TableBucketChainTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        $chain = new TableBucketChain();
        $this->assertTrue($chain->isEmpty());
    }

    public function test_that_duplicate_keys_do_not_affect_count()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $chain->set('baz', 'buz');
        $chain->set('foo', 'bar');
        $this->assertSame(2, count($chain));
    }

    public function test_that_get_returns_expected_value_for_key()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $chain->set('baz', 'buz');
        $this->assertSame('bar', $chain->get('foo'));
    }

    public function test_that_has_returns_true_when_key_is_in_the_chain()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $this->assertTrue($chain->has('foo'));
    }

    public function test_that_has_returns_false_when_key_is_not_in_the_chain()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $this->assertFalse($chain->has('baz'));
    }

    public function test_that_has_returns_false_after_key_is_removed()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $chain->remove('foo');
        $this->assertFalse($chain->has('foo'));
    }

    public function test_that_remove_returns_true_when_key_removed()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $this->assertTrue($chain->remove('foo'));
    }

    public function test_that_remove_returns_false_when_key_not_removed()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $this->assertFalse($chain->remove('bar'));
    }

    public function test_that_it_is_iterable_forward()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $chain->set('baz', 'buz');
        $chain->set('boz', 'foz');
        for ($chain->rewind(); $chain->valid(); $chain->next()) {
            if ($chain->key() === 'baz') {
                $this->assertSame('buz', $chain->current());
            }
        }
    }

    public function test_that_it_is_iterable_in_reverse()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $chain->set('baz', 'buz');
        $chain->set('boz', 'foz');
        for ($chain->end(); $chain->valid(); $chain->prev()) {
            if ($chain->key() === 'baz') {
                $this->assertSame('buz', $chain->current());
            }
        }
    }

    public function test_that_it_does_not_iterate_beyond_start()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $chain->set('baz', 'buz');
        $chain->set('boz', 'foz');
        for ($chain->end(); $chain->valid(); $chain->prev()) {
            $chain->current();
        }
        $chain->prev();
        $this->assertNull($chain->current());
    }

    public function test_that_it_does_not_iterate_beyond_end()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $chain->set('baz', 'buz');
        $chain->set('boz', 'foz');
        for ($chain->rewind(); $chain->valid(); $chain->next()) {
            $chain->current();
        }
        $chain->next();
        $this->assertNull($chain->current());
    }

    public function test_that_calling_key_without_valid_item_returns_null()
    {
        $chain = new TableBucketChain();
        $this->assertNull($chain->key());
    }

    public function test_that_calling_current_without_valid_item_returns_null()
    {
        $chain = new TableBucketChain();
        $this->assertNull($chain->current());
    }

    public function test_that_clone_include_nested_collection()
    {
        $chain = new TableBucketChain();
        $chain->set('foo', 'bar');
        $chain->set('baz', 'buz');
        $chain->set('boz', 'foz');
        $copy = clone $chain;
        $chain->remove('foo');
        $chain->remove('baz');
        $chain->remove('boz');
        $this->assertTrue(
            $copy->has('foo')
            && $copy->has('baz')
            && $copy->has('boz')
        );
    }

    public function test_that_get_throws_exception_for_key_not_found()
    {
        $this->expectException(KeyException::class);
        $chain = new TableBucketChain();
        $chain->get('foo');
    }
}
