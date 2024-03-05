<?php

declare(strict_types=1);

namespace Novuso\System\Test\Collection\Tree;

use Novuso\System\Collection\Tree\RedBlackNode;
use Novuso\System\Test\Resources\TestWeekDay;
use Novuso\System\Test\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RedBlackNode::class)]
class RedBlackNodeTest extends UnitTestCase
{
    public function test_that_constructor_takes_key_arg()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);

        static::assertSame($monday, $node->key());
    }

    public function test_that_constructor_takes_value_arg()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);

        static::assertSame('Monday', $node->value());
    }

    public function test_that_constructor_takes_size_arg()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);

        static::assertSame(1, $node->size());
    }

    public function test_that_constructor_takes_color_arg()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);

        static::assertSame(RedBlackNode::RED, $node->color());
    }

    public function test_that_left_holds_reference_to_left_node()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $sunday = TestWeekDay::SUNDAY();
        $left = new RedBlackNode($sunday, 'Sunday', 1, RedBlackNode::RED);
        $node->setLeft($left);

        static::assertSame($left, $node->left());
    }

    public function test_that_right_holds_reference_to_right_node()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $tuesday = TestWeekDay::TUESDAY();
        $right = new RedBlackNode($tuesday, 'Tuesday', 1, RedBlackNode::RED);
        $node->setRight($right);

        static::assertSame($right, $node->right());
    }

    public function test_that_it_allows_key_replacement()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $sunday = TestWeekDay::SUNDAY();
        $node->setKey($sunday);

        static::assertSame($sunday, $node->key());
    }

    public function test_that_it_allows_value_replacement()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $node->setValue('Sunday');

        static::assertSame('Sunday', $node->value());
    }

    public function test_that_it_allows_size_replacement()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $node->setSize(2);

        static::assertSame(2, $node->size());
    }

    public function test_that_it_allows_color_replacement()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $node->setColor(RedBlackNode::BLACK);

        static::assertSame(RedBlackNode::BLACK, $node->color());
    }

    public function test_that_clone_includes_linked_nodes()
    {
        $monday = TestWeekDay::MONDAY();
        $node = new RedBlackNode($monday, 'Monday', 1, RedBlackNode::RED);
        $sunday = TestWeekDay::SUNDAY();
        $left = new RedBlackNode($sunday, 'Sunday', 1, RedBlackNode::RED);
        $node->setLeft($left);
        $tuesday = TestWeekDay::TUESDAY();
        $right = new RedBlackNode($tuesday, 'Tuesday', 1, RedBlackNode::RED);
        $node->setRight($right);
        $copy = clone $node;
        $node->setLeft(null);
        $node->setRight(null);

        static::assertTrue($copy->left()->key()->equals($sunday));
    }
}
