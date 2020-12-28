<?php declare(strict_types=1);

namespace Novuso\System\Collection\Tree;

use Novuso\System\Collection\ArrayList;
use Novuso\System\Collection\Type\ItemList;
use Novuso\System\Exception\AssertionException;
use Novuso\System\Exception\LookupException;
use Novuso\System\Exception\UnderflowException;
use Novuso\System\Type\Comparator;
use Novuso\System\Exception\KeyException;
use Novuso\System\Utility\VarPrinter;

/**
 * Class RedBlackSearchTree
 */
final class RedBlackSearchTree implements BinarySearchTree
{
    protected ?RedBlackNode $root = null;

    /**
     * Constructs RedBlackSearchTree
     */
    public function __construct(protected Comparator $comparator) {}

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return $this->root === null;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->nodeSize($this->root);
    }

    /**
     * @inheritDoc
     */
    public function set(mixed $key, mixed $value): void
    {
        $this->root = $this->nodeSet($key, $value, $this->root);
        $this->root->setColor(RedBlackNode::BLACK);
    }

    /**
     * @inheritDoc
     */
    public function get(mixed $key): mixed
    {
        $node = $this->nodeGet($key, $this->root);

        if ($node === null) {
            $message = sprintf('Key not found: %s', VarPrinter::toString($key));
            throw new KeyException($message);
        }

        return $node->value();
    }

    /**
     * @inheritDoc
     */
    public function has(mixed $key): bool
    {
        return $this->nodeGet($key, $this->root) !== null;
    }

    /**
     * @inheritDoc
     */
    public function remove(mixed $key): void
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
     * @inheritDoc
     */
    public function keys(): iterable
    {
        if ($this->isEmpty()) {
            return new ArrayList();
        }

        return $this->rangeKeys($this->min(), $this->max());
    }

    /**
     * @inheritDoc
     */
    public function rangeKeys(mixed $lo, mixed $hi): iterable
    {
        $list = new ArrayList();

        $this->fillKeys($list, $lo, $hi, $this->root);

        return $list;
    }

    /**
     * @inheritDoc
     */
    public function rangeCount(mixed $lo, mixed $hi): int
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
     * @inheritDoc
     */
    public function min(): mixed
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Tree underflow');
        }

        return $this->nodeMin($this->root)->key();
    }

    /**
     * @inheritDoc
     */
    public function max(): mixed
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Tree underflow');
        }

        return $this->nodeMax($this->root)->key();
    }

    /**
     * @inheritDoc
     */
    public function removeMin(): void
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
     * @inheritDoc
     */
    public function removeMax(): void
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
     * @inheritDoc
     */
    public function floor(mixed $key): mixed
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
     * @inheritDoc
     */
    public function ceiling(mixed $key): mixed
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
     * @inheritDoc
     */
    public function rank(mixed $key): int
    {
        return $this->nodeRank($key, $this->root);
    }

    /**
     * @inheritDoc
     */
    public function select(int $rank): mixed
    {
        if ($rank < 0 || $rank >= $this->nodeSize($this->root)) {
            $message = sprintf('Invalid rank: %d', $rank);
            throw new LookupException($message);
        }

        return $this->nodeSelect($rank, $this->root)->key();
    }

    /**
     * Handles deep cloning
     */
    public function __clone(): void
    {
        $root = clone $this->root;
        $this->root = $root;
    }

    /**
     * Checks if a node is red
     */
    protected function isRed(?RedBlackNode $node): bool
    {
        if ($node === null) {
            return false;
        }

        return $node->color() === RedBlackNode::RED;
    }

    /**
     * Retrieves the size of a subtree
     */
    protected function nodeSize(?RedBlackNode $node): int
    {
        if ($node === null) {
            return 0;
        }

        return $node->size();
    }

    /**
     * Inserts a key-value pair in a subtree
     *
     * @throws AssertionException When the keys are not compatible
     */
    protected function nodeSet(mixed $key, mixed $value, ?RedBlackNode $node): RedBlackNode
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
     * @throws AssertionException When the keys are not compatible
     */
    protected function nodeGet(mixed $key, ?RedBlackNode $node): ?RedBlackNode
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
     * @throws AssertionException When the keys are not compatible
     */
    protected function nodeRemove(mixed $key, RedBlackNode $node): ?RedBlackNode
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
     * @throws AssertionException When the keys are not compatible
     */
    protected function nodeRemoveLeft(mixed $key, RedBlackNode $node): RedBlackNode
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
     * @throws AssertionException When the keys are not compatible
     */
    protected function nodeRemoveRight(mixed $key, RedBlackNode $node): RedBlackNode
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
     * @throws AssertionException When the keys are not compatible
     */
    protected function fillKeys(ItemList $list, mixed $lo, mixed $hi, ?RedBlackNode $node): void
    {
        if ($node === null) {
            return;
        }

        $compLo = $this->comparator->compare($lo, $node->key());
        $compHi = $this->comparator->compare($hi, $node->key());

        if ($compLo < 0) {
            $this->fillKeys($list, $lo, $hi, $node->left());
        }
        if ($compLo <= 0 && $compHi >= 0) {
            $list->add($node->key());
        }
        if ($compHi > 0) {
            $this->fillKeys($list, $lo, $hi, $node->right());
        }
    }

    /**
     * Retrieves the node with the minimum key in a subtree
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
     */
    protected function nodeRemoveMin(RedBlackNode $node): ?RedBlackNode
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
     */
    protected function nodeRemoveMax(RedBlackNode $node): ?RedBlackNode
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
     * @throws AssertionException When the keys are not compatible
     */
    protected function nodeFloor(mixed $key, ?RedBlackNode $node): ?RedBlackNode
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
     * @throws AssertionException When the keys are not compatible
     */
    protected function nodeCeiling(mixed $key, ?RedBlackNode $node): ?RedBlackNode
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
     * @throws AssertionException When the keys are not compatible
     */
    protected function nodeRank(mixed $key, ?RedBlackNode $node): int
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
     */
    protected function flipColors(RedBlackNode $node): void
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
