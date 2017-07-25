---
currentMenu: collection
---

# ArrayCollection

## Methods

#### create

```php
echo ArrayCollection::create(['foo' => 'bar'])->toJson();
// {"foo":"bar"}
```

#### array access

```php
$collection = new ArrayCollection();
$collection['foo'] = 'bar';
echo $collection['foo'];
// bar
unset($collection['foo']);
if (!isset($collection['foo'])) {
    echo 'removed';
}
// removed
```

#### add / append / push

```php
$collection = new ArrayCollection();
$collection->add('foo');
$collection->append('bar');
$collection->push('baz');
echo $collection->toJson();
// ["foo","bar","baz"]
```

#### get

```php
$collection = new ArrayCollection();
$collection->set('foo', 'bar');
echo $collection->get('foo');
// bar
echo $collection->get('baz', 'default');
// default
```

#### has

```php
$collection = new ArrayCollection();
$collection->set('foo', 'bar');
if ($collection->has('foo')) {
    echo $collection->get('foo');
}
// bar
```

#### pop

```php
$collection = new ArrayCollection();
$collection->add('foo');
$collection->add('bar');
$collection->add('baz');
echo $collection->pop();
// baz
echo $collection->toJson();
// ["foo","bar"]
```

#### prepend

```php
$collection = new ArrayCollection();
$collection->prepend('foo');
$collection->prepend('bar');
echo $collection->toJson();
// ["bar","foo"]
```

#### prependSet

```php
$collection = new ArrayCollection();
$collection->prependSet('foo', 'bar');
$collection->prependSet('baz', 'buz');
echo $collection->toJson();
// {"baz":"buz","foo":"bar"}
```

#### pull / extract

```php
$collection = new ArrayCollection();
$collection->set('foo', 'bar');
$collection->set('baz', 'buz');
echo $collection->pull('foo');
// bar
echo $collection->extract('baz');
// buz
if ($collection->isEmpty()) {
    echo 'empty';
}
// empty
```

#### remove

```php
$collection = new ArrayCollection();
$collection->set('foo', 'bar');
$collection->remove('foo');
if (!$collection->has('foo')) {
    echo 'removed';
}
// removed
```

#### set / put

```php
$collection = new ArrayCollection();
$collection->set('foo', 'bar');
$collection->put('baz', 'buz');
echo $collection->toJson();
// {"foo":"bar","baz":"buz"}
```

#### shift

```php
$collection = new ArrayCollection();
$collection->add('foo');
$collection->add('bar');
$collection->add('baz');
echo $collection->shift();
// foo
echo $collection->toJson();
// ["bar","baz"]
```
