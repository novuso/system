<?php declare(strict_types=1);

namespace Novuso\System\Collection\Tree;

use Novuso\System\Collection\Api\Queue;
use Novuso\System\Collection\LinkedQueue;
use Novuso\System\Exception\KeyException;
use Novuso\System\Exception\LookupException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Comparator;
use Novuso\System\Utility\VarPrinter;
use Traversable;

/**
 * RedBlackSearchTree is an implementation of a binary search tree
 *
 * @copyright Copyright (c) 2016, Novuso. <http://novuso.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class RedBlackSearchTree implements BinarySearchTree
{
    /**
     * Comparator
     *
     * @var Comparator
     */
    protected $comparator;

    /**
     * Root node
     *
     * @var RedBlackNode|null
     */
    protected $root;

    /**
     * Constructs RedBlackSearchTree
     *
     * @param Comparator $comparator The comparator
     */
    public function __construct(Comparator $comparator)
    {
        $this->comparator = $comparator;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return $this->root === null;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->nodeSize($this->root);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->root = $this->nodeSet($key, $value, $this->root);
        $this->root->setColor(RedBlackNode::BLACK);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        $node = $this->nodeGet($key, $this->root);

        if ($node === null) {
            $message = sprintf('Key not found: %s', VarPrinter::toString($key));
            throw new KeyException($message);
        }

        return $node->value();
    }

    /**
     * {@inheritdoc}
     */
    public function has($key): bool
    {
        return $this->nodeGet($key, $this->root) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        if (!$this->has($key)) {
            return;
        }

        if (!$this->isRed($this->root->left()) && !$this->isRed($this->root->right())) {
            $this->root->setColor(RedBlackNode::RED);
        }

        $this->root = $this->nodeRemove($key, $this->root);

        if (!$this->isEmpty()) {
            $this->root->setColor(RedBlackNode::BLACK);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function keys(): Traversable
    {
        if ($this->isEmpty()) {
            return new LinkedQueue();
        }

        return $this->rangeKeys($this->min(), $this->max());
    }

    /**
     * {@inheritdoc}
     */
    public function rangeKeys($lo, $hi): Traversable
    {
        $queue = new LinkedQueue();

        $this->fillKeys($queue, $lo, $hi, $this->root);

        return $queue;
    }

    /**
     * {@inheritdoc}
     */
    public function rangeCount($lo, $hi): int
    {
        if ($this->comparator->compare($lo, $hi) > 0) {
            return 0;
        }

        if ($this->has($hi)) {
            return $this->rank($hi) - $this->rank($lo) + 1;
        }

        return $this->rank($hi) - $this->rank($lo);
    }

    /**
     * {@inheritdoc}
     */
    public function min()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Tree underflow');
        }

        return $this->nodeMin($this->root)->key();
    }

    /**
     * {@inheritdoc}
     */
    public function max()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Tree underflow');
        }

        return $this->nodeMax($this->root)->key();
    }

    /**
     * {@inheritdoc}
     */
    public function removeMin()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Tree underflow');
        }

        if (!$this->isRed($this->root->left()) && !$this->isRed($this->root->right())) {
            $this->root->setColor(RedBlackNode::RED);
        }

        $this->root = $this->nodeRemoveMin($this->root);

        if (!$this->isEmpty()) {
            $this->root->setColor(RedBlackNode::BLACK);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeMax()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Tree underflow');
        }

        if (!$this->isRed($this->root->left()) && !$this->isRed($this->root->right())) {
            $this->root->setColor(RedBlackNode::RED);
        }

        $this->root = $this->nodeRemoveMax($this->root);

        if (!$this->isEmpty()) {
            $this->root->setColor(RedBlackNode::BLACK);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function floor($key)
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Tree underflow');
        }

        $node = $this->nodeFloor($key, $this->root);

        if ($node === null) {
            return null;
        }

        return $node->key();
    }

    /**
     * {@inheritdoc}
     */
    public function ceiling($key)
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Tree underflow');
        }

        $node = $this->nodeCeiling($key, $this->root);

        if ($node === null) {
            return null;
        }

        return $node->key();
    }

    /**
     * {@inheritdoc}
     */
    public function rank($key): int
    {
        return $this->nodeRank($key, $this->root);
    }

    /**
     * {@inheritdoc}
     */
    public function select(int $rank)
    {
        if ($rank < 0 || $rank >= $this->nodeSize($this->root)) {
            $message = sprintf('Invalid rank: %d', $rank);
            throw new LookupException($message);
        }

        return $this->nodeSelect($rank, $this->root)->key();
    }

    /**
     * Handles deep cloning
     *
     * @return void
     */
    public function __clone()
    {
        $root = clone $this->root;
        $this->root = $root;
    }

    /**
     * Checks if a node is red
     *
     * @param RedBlackNode|null $node The node
     *
     * @return bool
     */
    protected function isRed(RedBlackNode $node = null): bool
    {
        if ($node === null) {
            return false;
        }

        return $node->color() === RedBlackNode::RED;
    }

    /**
     * Retrieves the size of a subtree
     *
     * @param RedBlackNode|null $node The subtree root
     *
     * @return int
     */
    protected function nodeSize(RedBlackNode $node = null): int
    {
        if ($node === null) {
            return 0;
        }

        return $node->size();
    }

    /**
     * Inserts a key-value pair in a subtree
     *
     * @param mixed             $key   The key
     * @param mixed             $value The value
     * @param RedBlackNode|null $node  The subtree root
     *
     * @return RedBlackNode
     */
    protected function nodeSet($key, $value, RedBlackNode $node = null): RedBlackNode
    {
        if ($node === null) {
            return new RedBlackNode($key, $value, 1, RedBlackNode::RED);
        }

        $comp = $this->comparator->compare($key, $node->key());

        if ($comp < 0) {
            $node->setLeft($this->nodeSet($key, $value, $node->left()));
        } elseif ($comp > 0) {
            $node->setRight($this->nodeSet($key, $value, $node->right()));
        } else {
            $node->setValue($value);
        }

        return $this->balanceOnInsert($node);
    }

    /**
     * Retrieves a node by key and subtree
     *
     * Returns null if the node is not found.
     *
     * @param mixed             $key  The key
     * @param RedBlackNode|null $node The subtree root
     *
     * @return RedBlackNode|null
     */
    protected function nodeGet($key, RedBlackNode $node = null)
    {
        while ($node !== null) {
            $comp = $this->comparator->compare($key, $node->key());
            if ($comp < 0) {
                $node = $node->left();
            } elseif ($comp > 0) {
                $node = $node->right();
            } else {
                return $node;
            }
        }

        return null;
    }

    /**
     * Deletes a node by key and subtree
     *
     * @param mixed        $key  The key
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode|null
     */
    protected function nodeRemove($key, RedBlackNode $node)
    {
        $comp = $this->comparator->compare($key, $node->key());
        if ($comp < 0) {
            $node = $this->nodeRemoveLeft($key, $node);
        } else {
            if ($this->isRed($node->left())) {
                $node = $this->rotateRight($node);
            }
            if ($comp === 0 && $node->right() === null) {
                return null;
            }
            $node = $this->nodeRemoveRight($key, $node);
        }

        return $this->balanceOnRemove($node);
    }

    /**
     * Deletes a node to the left by key and subtree
     *
     * @internal Helper for nodeRemove()
     *
     * @param mixed        $key  The key
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode
     */
    protected function nodeRemoveLeft($key, RedBlackNode $node): RedBlackNode
    {
        if (!$this->isRed($node->left()) && !$this->isRed($node->left()->left())) {
            $node = $this->moveRedLeft($node);
        }
        $node->setLeft($this->nodeRemove($key, $node->left()));

        return $node;
    }

    /**
     * Deletes a node to the right by key and subtree
     *
     * @internal Helper for nodeRemove()
     *
     * @param mixed        $key  The key
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode
     */
    protected function nodeRemoveRight($key, RedBlackNode $node): RedBlackNode
    {
        if (!$this->isRed($node->right()) && !$this->isRed($node->right()->left())) {
            $node = $this->moveRedRight($node);
        }
        if ($this->comparator->compare($key, $node->key()) === 0) {
            $link = $this->nodeMin($node->right());
            $node->setKey($link->key());
            $node->setValue($link->value());
            $node->setRight($this->nodeRemoveMin($node->right()));
        } else {
            $node->setRight($this->nodeRemove($key, $node->right()));
        }

        return $node;
    }

    /**
     * Fills a queue with keys between lo and hi in a subtree
     *
     * @param Queue             $queue The queue
     * @param mixed             $lo    The lower bound
     * @param mixed             $hi    The upper bound
     * @param RedBlackNode|null $node  The subtree root
     *
     * @return void
     */
    protected function fillKeys(Queue $queue, $lo, $hi, RedBlackNode $node = null)
    {
        if ($node === null) {
            return;
        }

        $complo = $this->comparator->compare($lo, $node->key());
        $comphi = $this->comparator->compare($hi, $node->key());

        if ($complo < 0) {
            $this->fillKeys($queue, $lo, $hi, $node->left());
        }
        if ($complo <= 0 && $comphi >= 0) {
            $queue->enqueue($node->key());
        }
        if ($comphi > 0) {
            $this->fillKeys($queue, $lo, $hi, $node->right());
        }
    }

    /**
     * Retrieves the node with the minimum key in a subtree
     *
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode
     */
    protected function nodeMin(RedBlackNode $node): RedBlackNode
    {
        if ($node->left() === null) {
            return $node;
        }

        return $this->nodeMin($node->left());
    }

    /**
     * Retrieves the node with the maximum key in a subtree
     *
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode
     */
    protected function nodeMax(RedBlackNode $node): RedBlackNode
    {
        if ($node->right() === null) {
            return $node;
        }

        return $this->nodeMax($node->right());
    }

    /**
     * Removes the node with the minimum key in a subtree
     *
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode|null
     */
    protected function nodeRemoveMin(RedBlackNode $node)
    {
        if ($node->left() === null) {
            return null;
        }

        if (!$this->isRed($node->left()) && !$this->isRed($node->left()->left())) {
            $node = $this->moveRedLeft($node);
        }

        $node->setLeft($this->nodeRemoveMin($node->left()));

        return $this->balanceOnRemove($node);
    }

    /**
     * Removes the node with the maximum key in a subtree
     *
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode|null
     */
    protected function nodeRemoveMax(RedBlackNode $node)
    {
        if ($this->isRed($node->left())) {
            $node = $this->rotateRight($node);
        }

        if ($node->right() === null) {
            return null;
        }

        if (!$this->isRed($node->right()) && !$this->isRed($node->right()->left())) {
            $node = $this->moveRedRight($node);
        }

        $node->setRight($this->nodeRemoveMax($node->right()));

        return $this->balanceOnRemove($node);
    }

    /**
     * Retrieves the node with the largest key <= to a key in a subtree
     *
     * Returns null if there is not a key less or equal to the given key.
     *
     * @param mixed             $key  The key
     * @param RedBlackNode|null $node The subtree root
     *
     * @return RedBlackNode|null
     */
    protected function nodeFloor($key, RedBlackNode $node = null)
    {
        if ($node === null) {
            return null;
        }

        $comp = $this->comparator->compare($key, $node->key());

        if ($comp === 0) {
            return $node;
        }
        if ($comp < 0) {
            return $this->nodeFloor($key, $node->left());
        }
        $right = $this->nodeFloor($key, $node->right());
        if ($right !== null) {
            return $right;
        }

        return $node;
    }

    /**
     * Retrieves the node with the smallest key >= to a key in a subtree
     *
     * Returns null if there is not a key less or equal to the given key.
     *
     * @param mixed             $key  The key
     * @param RedBlackNode|null $node The subtree root
     *
     * @return RedBlackNode|null
     */
    protected function nodeCeiling($key, RedBlackNode $node = null)
    {
        if ($node === null) {
            return null;
        }

        $comp = $this->comparator->compare($key, $node->key());

        if ($comp === 0) {
            return $node;
        }
        if ($comp > 0) {
            return $this->nodeCeiling($key, $node->right());
        }
        $left = $this->nodeCeiling($key, $node->left());
        if ($left !== null) {
            return $left;
        }

        return $node;
    }

    /**
     * Retrieves the rank for a key in a subtree
     *
     * @param mixed             $key  The key
     * @param RedBlackNode|null $node The subtree root
     *
     * @return int
     */
    protected function nodeRank($key, RedBlackNode $node = null): int
    {
        if ($node === null) {
            return 0;
        }

        $comp = $this->comparator->compare($key, $node->key());

        if ($comp < 0) {
            return $this->nodeRank($key, $node->left());
        }
        if ($comp > 0) {
            return 1 + $this->nodeSize($node->left()) + $this->nodeRank($key, $node->right());
        }

        return $this->nodeSize($node->left());
    }

    /**
     * Retrieves the node with the key of a given rank in a subtree
     *
     * @param int          $rank The rank
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode
     */
    protected function nodeSelect(int $rank, RedBlackNode $node): RedBlackNode
    {
        $size = $this->nodeSize($node->left());

        if ($size > $rank) {
            return $this->nodeSelect($rank, $node->left());
        }
        if ($size < $rank) {
            return $this->nodeSelect($rank - $size - 1, $node->right());
        }

        return $node;
    }

    /**
     * Rotates a right-learning link to the left
     *
     * Assumes $node->right is red.
     *
     * @param RedBlackNode $node The node
     *
     * @return RedBlackNode
     */
    protected function rotateLeft(RedBlackNode $node): RedBlackNode
    {
        $link = $node->right();
        $node->setRight($link->left());
        $link->setLeft($node);
        $link->setColor($node->color());
        $node->setColor(RedBlackNode::RED);
        $link->setSize($node->size());
        $node->setSize(1 + $this->nodeSize($node->left()) + $this->nodeSize($node->right()));

        return $link;
    }

    /**
     * Rotates a left-leaning link to the right
     *
     * Assumes $node->left is red.
     *
     * @param RedBlackNode $node The node
     *
     * @return RedBlackNode
     */
    protected function rotateRight(RedBlackNode $node): RedBlackNode
    {
        $link = $node->left();
        $node->setLeft($link->right());
        $link->setRight($node);
        $link->setColor($node->color());
        $node->setColor(RedBlackNode::RED);
        $link->setSize($node->size());
        $node->setSize(1 + $this->nodeSize($node->left()) + $this->nodeSize($node->right()));

        return $link;
    }

    /**
     * Flips the colors of a node and its two children
     *
     * Used to maintain symmetric order and perfect black balance when a black
     * node has two red children.
     *
     * @param RedBlackNode $node The node
     *
     * @return void
     */
    protected function flipColors(RedBlackNode $node)
    {
        $node->setColor(!($node->color()));
        $node->left()->setColor(!($node->left()->color()));
        $node->right()->setColor(!($node->right()->color()));
    }

    /**
     * Makes a left link or child red
     *
     * Assumes red $node and $node->left and $node->left->left are black.
     *
     * @codeCoverageIgnore
     *
     * @param RedBlackNode $node The node
     *
     * @return RedBlackNode
     */
    protected function moveRedLeft(RedBlackNode $node): RedBlackNode
    {
        $this->flipColors($node);
        if ($this->isRed($node->right()->left())) {
            $node->setRight($this->rotateRight($node->right()));
            $node = $this->rotateLeft($node);
            $this->flipColors($node);
        }

        return $node;
    }

    /**
     * Makes a right link or child red
     *
     * Assumes red $node and $node->right and $node->right->left are black.
     *
     * @codeCoverageIgnore
     *
     * @param RedBlackNode $node The node
     *
     * @return RedBlackNode
     */
    protected function moveRedRight(RedBlackNode $node): RedBlackNode
    {
        $this->flipColors($node);
        if ($this->isRed($node->left()->left())) {
            $node = $this->rotateRight($node);
            $this->flipColors($node);
        }

        return $node;
    }

    /**
     * Restores red-black tree invariant on remove
     *
     * @codeCoverageIgnore
     *
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode
     */
    protected function balanceOnRemove(RedBlackNode $node): RedBlackNode
    {
        if ($this->isRed($node->right())) {
            $node = $this->rotateLeft($node);
        }
        if ($this->isRed($node->left()) && $this->isRed($node->left()->left())) {
            $node = $this->rotateRight($node);
        }
        if ($this->isRed($node->left()) && $this->isRed($node->right())) {
            $this->flipColors($node);
        }
        $node->setSize(1 + $this->nodeSize($node->left()) + $this->nodeSize($node->right()));

        return $node;
    }

    /**
     * Restores red-black tree invariant on insert
     *
     * @codeCoverageIgnore
     *
     * @param RedBlackNode $node The subtree root
     *
     * @return RedBlackNode
     */
    protected function balanceOnInsert(RedBlackNode $node): RedBlackNode
    {
        if ($this->isRed($node->right()) && !$this->isRed($node->left())) {
            $node = $this->rotateLeft($node);
        }
        if ($this->isRed($node->left()) && $this->isRed($node->left()->left())) {
            $node = $this->rotateRight($node);
        }
        if ($this->isRed($node->left()) && $this->isRed($node->right())) {
            $this->flipColors($node);
        }
        $node->setSize(1 + $this->nodeSize($node->left()) + $this->nodeSize($node->right()));

        return $node;
    }
}
