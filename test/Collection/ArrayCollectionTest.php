<?php

namespace Novuso\Test\System\Collection;

use Novuso\System\Collection\ArrayCollection;
use Novuso\Test\System\Resources\WeekDay;
use Novuso\Test\System\TestCase\UnitTestCase;

/**
 * @covers Novuso\System\Collection\ArrayCollection
 */
class ArrayCollectionTest extends UnitTestCase
{
    public function test_that_it_is_empty_by_default()
    {
        $this->assertTrue(ArrayCollection::create()->isEmpty());
    }

    public function test_that_add_append_and_push_add_items()
    {
        $this->assertCount(3, ArrayCollection::create()->add(1)->append(2)->push(3));
    }

    public function test_that_prepend_correctly_prepends_items()
    {
        $this->assertSame([0, 1, 2, 3], ArrayCollection::create([1, 2, 3])->prepend(0)->toArray());
    }

    public function test_that_set_and_put_add_items_with_keys()
    {
        $this->assertSame(
            ['foo' => 'bar', 'baz' => 'buz'],
            ArrayCollection::create()->set('foo', 'bar')->put('baz', 'buz')->toArray()
        );
    }

    public function test_that_prepend_set_correctly_prepends_items_with_keys()
    {
        $this->assertSame(
            ['foo' => 'bar', 'baz' => 'buz'],
            ArrayCollection::create()->set('baz', 'buz')->prependSet('foo', 'bar')->toArray()
        );
    }

    public function test_that_get_returns_expected_item()
    {
        $this->assertSame('bar', ArrayCollection::create(['foo' => 'bar'])->get('foo'));
    }

    public function test_that_get_returns_default_value()
    {
        $this->assertSame('default', ArrayCollection::create()->get('foo', 'default'));
    }

    public function test_that_has_returns_true_when_key_exists()
    {
        $this->assertTrue(ArrayCollection::create(['foo' => 'bar'])->has('foo'));
    }

    public function test_that_has_returns_true_when_value_is_null()
    {
        $this->assertTrue(ArrayCollection::create(['foo' => null])->has('foo'));
    }

    public function test_that_has_returns_false_when_key_does_not_exist()
    {
        $this->assertFalse(ArrayCollection::create()->has('foo'));
    }

    public function test_that_remove_correctly_removes_item()
    {
        $this->assertFalse(ArrayCollection::create(['foo' => 'bar'])->remove('foo')->has('foo'));
    }

    public function test_that_offset_set_adds_items_with_keys()
    {
        $collection = ArrayCollection::create();
        $collection['foo'] = 'bar';
        $collection['baz'] = 'buz';
        $this->assertSame(['foo' => 'bar', 'baz' => 'buz'], $collection->toArray());
    }

    public function test_that_offset_get_returns_expected_item()
    {
        $collection = ArrayCollection::create(['foo' => 'bar']);
        $this->assertSame('bar', $collection['foo']);
    }

    public function test_that_offset_get_returns_default_null()
    {
        $collection = ArrayCollection::create();
        $this->assertNull($collection['foo']);
    }

    public function test_that_offset_exists_returns_true_when_key_exists()
    {
        $collection = ArrayCollection::create(['foo' => 'bar']);
        $this->assertTrue(isset($collection['foo']));
    }

    public function test_that_offset_exists_returns_false_when_value_is_null()
    {
        $collection = ArrayCollection::create(['foo' => null]);
        $this->assertFalse(isset($collection['foo']));
    }

    public function test_that_offset_exists_returns_false_when_key_does_not_exist()
    {
        $collection = ArrayCollection::create();
        $this->assertFalse(isset($collection['foo']));
    }

    public function test_that_offset_unset_correctly_removes_item()
    {
        $collection = ArrayCollection::create(['foo' => 'bar']);
        unset($collection['foo']);
        $this->assertFalse(isset($collection['foo']));
    }

    public function test_that_pull_and_extract_remove_and_return_a_value_by_key()
    {
        $collection = ArrayCollection::create(['foo' => 'bar', 'baz' => 'buz']);
        $foo = $collection->pull('foo');
        $baz = $collection->extract('baz');
        $this->assertTrue($foo === 'bar' && $baz === 'buz' && $collection->isEmpty());
    }

    public function test_that_shift_removes_and_returns_the_first_item()
    {
        $collection = ArrayCollection::create([0, 1, 2, 3]);
        $first = $collection->shift();
        $this->assertTrue($first === 0 && [1, 2, 3] === $collection->toArray());
    }

    public function test_that_pop_removes_and_returns_the_last_item()
    {
        $collection = ArrayCollection::create([0, 1, 2, 3]);
        $last = $collection->pop();
        $this->assertTrue($last === 3 && [0, 1, 2] === $collection->toArray());
    }

    public function test_that_splice_removes_and_returns_remaining_items()
    {
        $collection = ArrayCollection::create([0, 1, 2, 3, 4, 5]);
        $splice = $collection->splice(3);
        $this->assertTrue([3, 4, 5] === $splice->toArray() && [0, 1, 2] === $collection->toArray());
    }

    public function test_that_splice_removes_and_returns_expected_items()
    {
        $collection = ArrayCollection::create([0, 1, 2, 3, 4, 5]);
        $splice = $collection->splice(2, 2);
        $this->assertTrue([2, 3] === $splice->toArray() && [0, 1, 4, 5] === $collection->toArray());
    }

    public function test_that_splice_removes_and_returns_remaining_items_with_replacement()
    {
        $collection = ArrayCollection::create([0, 1, 2, 3, 4, 5]);
        $splice = $collection->splice(3, null, [6, 7, 8]);
        $this->assertTrue([3, 4, 5] === $splice->toArray() && [0, 1, 2, 6, 7, 8] === $collection->toArray());
    }

    public function test_that_splice_removes_and_returns_expected_items_with_replacement()
    {
        $collection = ArrayCollection::create([0, 1, 2, 3, 4, 5]);
        $splice = $collection->splice(2, 2, [6, 7]);
        $this->assertTrue([2, 3] === $splice->toArray() && [0, 1, 6, 7, 4, 5] === $collection->toArray());
    }

    public function test_that_contains_returns_true_when_same_value_is_found()
    {
        $this->assertTrue(ArrayCollection::create([0, 1, 2, 3])->contains(2));
    }

    public function test_that_contains_returns_true_when_equal_value_is_found()
    {
        $this->assertTrue(ArrayCollection::create([0, 1, 2, 3])->contains('2', false));
    }

    public function test_that_contains_returns_false_when_same_value_is_not_found()
    {
        $this->assertFalse(ArrayCollection::create([0, 1, 2, 3])->contains('2'));
    }

    public function test_that_contains_returns_false_when_equal_value_is_not_found()
    {
        $this->assertFalse(ArrayCollection::create([0, 1, 2, 3])->contains('4', false));
    }

    public function test_that_search_returns_expected_key()
    {
        $this->assertSame('foo', ArrayCollection::create(['foo' => 'bar', 'baz' => 'buz'])->search('bar'));
    }

    public function test_that_all_returns_expected_value()
    {
        $data = ['foo' => 'bar', 'baz' => 'buz'];
        $this->assertSame($data, ArrayCollection::create($data)->all());
    }

    public function test_that_keys_returns_expected_value()
    {
        $data = ['foo' => 'bar', 'baz' => 'buz'];
        $this->assertSame(['foo', 'baz'], ArrayCollection::create($data)->keys()->toArray());
    }

    public function test_that_values_returns_expected_value()
    {
        $data = ['foo' => 'bar', 'baz' => 'buz'];
        $this->assertSame(['bar', 'buz'], ArrayCollection::create($data)->values()->toArray());
    }

    public function test_that_flip_returns_expected_value()
    {
        $data = ['foo' => 'bar', 'baz' => 'buz'];
        $flipped = ['bar' => 'foo', 'buz' => 'baz'];
        $this->assertSame($flipped, ArrayCollection::create($data)->flip()->toArray());
    }

    public function test_that_any_returns_true_when_any_item_matches()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertTrue(ArrayCollection::create($data)->any(function ($value) {
            return $value[0] === 'f';
        }));
    }

    public function test_that_any_returns_false_when_no_item_matches()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertFalse(ArrayCollection::create($data)->any(function ($value) {
            return $value[0] === 'a';
        }));
    }

    public function test_that_every_returns_true_when_all_items_match()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertTrue(ArrayCollection::create($data)->every(function ($value) {
            return strlen($value) === 3;
        }));
    }

    public function test_that_every_returns_false_when_all_items_do_not_match()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertFalse(ArrayCollection::create($data)->every(function ($value) {
            return $value[0] === 'b';
        }));
    }

    public function test_that_first_returns_expected_value_without_callback()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertSame('foo', ArrayCollection::create($data)->first());
    }

    public function test_that_first_returns_expected_value_with_callback()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertSame('bar', ArrayCollection::create($data)->first(function ($item) {
            return $item[0] === 'b';
        }));
    }

    public function test_that_first_returns_null_with_unmatched_predicate()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertNull(ArrayCollection::create($data)->first(function ($item) {
            return $item[0] === 'a';
        }));
    }

    public function test_that_last_returns_expected_value_without_callback()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertSame('buz', ArrayCollection::create($data)->last());
    }

    public function test_that_last_returns_expected_value_with_callback()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertSame('baz', ArrayCollection::create($data)->last(function ($item) {
            return $item[1] === 'a';
        }));
    }

    public function test_that_last_returns_null_with_unmatched_predicate()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertNull(ArrayCollection::create($data)->last(function ($item) {
            return $item[0] === 'a';
        }));
    }

    public function test_that_random_returns_a_single_item_by_default()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertTrue(in_array(ArrayCollection::create($data)->random(), $data));
    }

    public function test_that_random_returns_expected_number_of_items()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $this->assertCount(3, ArrayCollection::create($data)->random(3));
    }

    public function test_that_shuffle_does_not_affect_original_order()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        $collection = ArrayCollection::create($data);
        $shuffled = $collection->shuffle();
        $this->assertSame($data, $collection->toArray());
    }

    public function test_that_reverse_returns_expected_value()
    {
        $data = range(0, 9);
        $expected = array_reverse($data);
        $collection = ArrayCollection::create($data);
        $this->assertSame($expected, $collection->reverse()->toArray());
    }

    public function test_that_sort_returns_expected_value_without_callback()
    {
        $data = range(0, 9);
        $shuffled = $data;
        shuffle($shuffled);
        $collection = ArrayCollection::create($shuffled);
        $this->assertSame($data, $collection->sort()->values()->toArray());
    }

    public function test_that_sort_returns_expected_value_with_callback()
    {
        $data = range(0, 9);
        $shuffled = $data;
        shuffle($shuffled);
        $expected = array_reverse($data);
        $collection = ArrayCollection::create($shuffled);
        $this->assertSame($expected, $collection->sort(function ($a, $b) {
            if ($a > $b) {
                return -1;
            }
            if ($a < $b) {
                return 1;
            }

            return 0;
        })->values()->toArray());
    }

    public function test_that_sort_by_returns_expected_value()
    {
        $expected = [
            'SUNDAY',
            'MONDAY',
            'TUESDAY',
            'WEDNESDAY',
            'THURSDAY',
            'FRIDAY',
            'SATURDAY'
        ];
        $collection = ArrayCollection::create($this->getWeekDays());
        $collection = $collection->sortBy(function ($weekDay) {
            return $weekDay->ordinal();
        })->map(function ($weekDay) {
            return $weekDay->name();
        });
        $this->assertSame($expected, $collection->values()->toArray());
    }

    public function test_that_sort_by_desc_returns_expected_value()
    {
        $expected = [
            'SATURDAY',
            'FRIDAY',
            'THURSDAY',
            'WEDNESDAY',
            'TUESDAY',
            'MONDAY',
            'SUNDAY'
        ];
        $collection = ArrayCollection::create($this->getWeekDays());
        $collection = $collection->sortByDesc(function ($weekDay) {
            return $weekDay->ordinal();
        })->map(function ($weekDay) {
            return $weekDay->name();
        });
        $this->assertSame($expected, $collection->values()->toArray());
    }

    public function test_that_pipe_returns_expected_value()
    {
        $data = ['foo' => 'bar', 'baz' => 'buz'];
        $collection = ArrayCollection::create($data);
        $collection = $collection->pipe(function ($collection) {
            // allows chaining while using procedural functions
            return ArrayCollection::create(array_map(function ($value) {
                return str_replace('b', 'f', $value);
            }, $collection->toArray()));
        })->values();
        $this->assertSame(['far', 'fuz'], $collection->toArray());
    }

    public function test_that_each_calls_callback_with_each_item()
    {
        $data = ['foo' => 'bar', 'baz' => 'buz'];
        $keys = [];
        $values = [];
        $collection = ArrayCollection::create($data);
        $collection->each(function ($value, $key) use (&$keys, &$values) {
            $keys[] = $key;
            $values[] = $value;
        });
        $this->assertTrue(
            ['foo', 'baz'] === $keys
            && ['bar', 'buz'] === $values
        );
    }

    public function test_that_pluck_returns_expected_value()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Franks'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $collection = ArrayCollection::create($data);
        $expected = ['John', 'Jimmy', 'Sally', 'Leeroy'];
        $this->assertSame($expected, $collection->pluck('first_name')->toArray());
    }

    public function test_that_key_by_returns_expected_value()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Franks'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $collection = ArrayCollection::create($data);
        $expected = [
            'John Smith'     => ['first_name' => 'John', 'last_name' => 'Smith'],
            'Jimmy Franks'   => ['first_name' => 'Jimmy', 'last_name' => 'Franks'],
            'Sally Klien'    => ['first_name' => 'Sally', 'last_name' => 'Klien'],
            'Leeroy Jenkins' => ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $this->assertSame($expected, $collection->keyBy(function ($person) {
            return $person['first_name'].' '.$person['last_name'];
        })->toArray());
    }

    public function test_that_group_by_returns_expected_value()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $collection = ArrayCollection::create($data);
        $expected = [
            'Smith'   => [
                ['first_name' => 'John', 'last_name' => 'Smith'],
                ['first_name' => 'Jimmy', 'last_name' => 'Smith']
            ],
            'Klien'   => [
                ['first_name' => 'Sally', 'last_name' => 'Klien']
            ],
            'Jenkins' => [
                ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
            ]
        ];
        $this->assertSame($expected, $collection->groupBy(function ($person) {
            return $person['last_name'];
        })->toArray());
    }

    public function test_that_transpose_returns_expected_value()
    {
        $data = [
            [0, 1, 2, 3],
            [4, 5, 6, 7],
            [8, 9, 10, 11],
            [12, 13, 14, 15]
        ];
        $collection = ArrayCollection::create($data);
        $expected = [
            [0, 4, 8, 12],
            [1, 5, 9, 13],
            [2, 6, 10, 14],
            [3, 7, 11, 15]
        ];
        $this->assertSame($expected, $collection->transpose()->toArray());
    }

    public function test_that_chunk_returns_expected_value()
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $collection = ArrayCollection::create($data);
        $expected = [[1, 2, 3], [4, 5, 6], [7, 8, 9], [10, 11, 12]];
        $this->assertSame($expected, $collection->chunk(3)->toArray());
    }

    public function test_that_flatten_returns_expected_value_without_argument()
    {
        $data = [
            [
                ['first_name' => 'John', 'last_name' => 'Smith'],
                ['first_name' => 'Jimmy', 'last_name' => 'Smith']
            ],
            [
                ['first_name' => 'Sally', 'last_name' => 'Klien']
            ],
            [
                ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
            ]
        ];
        $collection = ArrayCollection::create($data);
        $expected = ['John', 'Smith', 'Jimmy', 'Smith', 'Sally', 'Klien', 'Leeroy', 'Jenkins'];
        $this->assertSame($expected, $collection->flatten()->toArray());
    }

    public function test_that_flatten_returns_expected_value_with_argument()
    {
        $data = [
            ArrayCollection::create([
                ['first_name' => 'John', 'last_name' => 'Smith'],
                ['first_name' => 'Jimmy', 'last_name' => 'Smith']
            ]),
            ArrayCollection::create([
                ['first_name' => 'Sally', 'last_name' => 'Klien']
            ]),
            ArrayCollection::create([
                ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
            ])
        ];
        $collection = ArrayCollection::create($data);
        $expected = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $this->assertSame($expected, $collection->flatten(1)->toArray());
    }

    public function test_that_flat_map_returns_expected_value()
    {
        $data = [
            [
                'first_name'    => 'John',
                'last_name'     => 'Smith',
                'phone_numbers' => [
                    '5551212',
                    '5555555'
                ]
            ],
            [
                'first_name' => 'Jimmy',
                'last_name'  => 'Smith',
                'phone_numbers' => [
                    '5551234',
                    '5556666'
                ]
            ],
            [
                'first_name' => 'Sally',
                'last_name'  => 'Klien',
                'phone_numbers' => [
                    '5111212',
                    '5551111'
                ]
            ],
            [
                'first_name' => 'Leeroy',
                'last_name'  => 'Jenkins',
                'phone_numbers' => [
                    '7755555',
                    '9755555'
                ]
            ]
        ];
        $collection = ArrayCollection::create($data);
        $expected = [
            '5551212',
            '5555555',
            '5551234',
            '5556666',
            '5111212',
            '5551111',
            '7755555',
            '9755555'
        ];
        $this->assertSame($expected, $collection->flatMap(function ($person) {
            return $person['phone_numbers'];
        })->toArray());
    }

    public function test_that_collapse_returns_expected_value()
    {
        $data = [
            ArrayCollection::create([
                ['first_name' => 'John', 'last_name' => 'Smith'],
                ['first_name' => 'Jimmy', 'last_name' => 'Smith']
            ]),
            ArrayCollection::create([
                ['first_name' => 'Sally', 'last_name' => 'Klien']
            ]),
            ArrayCollection::create([
                ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
            ]),
            'count' => 4
        ];
        $collection = ArrayCollection::create($data);
        $expected = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $this->assertSame($expected, $collection->collapse()->toArray());
    }

    public function test_that_combine_returns_expected_value()
    {
        $keys = ['zero', 'one', 'two'];
        $values = [0, 1, 2];
        $collection = ArrayCollection::create($keys);
        $expected = ['zero' => 0, 'one' => 1, 'two' => 2];
        $this->assertSame($expected, $collection->combine($values)->toArray());
    }

    public function test_that_divide_returns_expected_value()
    {
        $data = ['zero' => 0, 'one' => 1, 'two' => 2];
        $collection = ArrayCollection::create($data);
        $keys = ['zero', 'one', 'two'];
        $values = [0, 1, 2];
        $parts = $collection->divide()->toArray();
        $this->assertTrue(
            $keys === $parts[0]
            && $values === $parts[1]
        );
    }

    public function test_that_zip_returns_expected_value()
    {
        $keys = ['zero', 'one', 'two'];
        $values = [0, 1, 2];
        $collection = ArrayCollection::create($keys);
        $expected = [['zero', 0], ['one', 1], ['two', 2]];
        $this->assertSame($expected, $collection->zip($values)->toArray());
    }

    public function test_that_unique_returns_expected_value_without_argument()
    {
        $data = [6, 4, 4, 10, 10, 6, 7, 3, 5, 7];
        $collection = ArrayCollection::create($data);
        $expected = [6, 4, 10, 7, 3, 5];
        $this->assertSame($expected, $collection->unique()->values()->toArray());
    }

    public function test_that_unique_returns_expected_value_with_argument()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith']
        ];
        $collection = ArrayCollection::create($data);
        $expected = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $this->assertSame($expected, $collection->unique(function ($person) {
            return $person['first_name'].$person['last_name'];
        })->values()->toArray());
    }

    public function test_that_intersect_returns_expected_value()
    {
        $twos = ArrayCollection::create([2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30]);
        $threes = ArrayCollection::create([3, 6, 9, 12, 15, 18, 21, 24, 30]);
        $intersection = $twos->intersect($threes);
        $expected = [6, 12, 18, 24, 30];
        $this->assertSame($expected, $intersection->values()->toArray());
    }

    public function test_that_diff_returns_expected_value()
    {
        $twos = ArrayCollection::create([2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30]);
        $threes = ArrayCollection::create([3, 6, 9, 12, 15, 18, 21, 24, 30]);
        $diff = $twos->diff($threes);
        $expected = [2, 4, 8, 10, 14, 16, 20, 22, 26, 28];
        $this->assertSame($expected, $diff->values()->toArray());
    }

    public function test_that_diff_keys_returns_expected_value()
    {
        $twos = ArrayCollection::create([2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30]);
        $threes = ArrayCollection::create([3, 6, 9, 12, 15, 18, 21, 24, 30]);
        $diff = $twos->diffKeys($threes);
        $expected = [20, 22, 24, 26, 28, 30];
        $this->assertSame($expected, $diff->values()->toArray());
    }

    public function test_that_union_returns_expected_value()
    {
        $twos = ArrayCollection::create([2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30]);
        $threes = ArrayCollection::create([3, 6, 9, 12, 15, 18, 21, 24, 30]);
        $union = $twos->union($threes);
        $expected = [2, 3, 4, 6, 8, 9, 10, 12, 14, 15, 16, 18, 20, 21, 22, 24, 26, 28, 30];
        $this->assertSame($expected, $union->sort()->values()->toArray());
    }

    public function test_that_merge_returns_expected_value()
    {
        $twos = ArrayCollection::create([2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30]);
        $threes = ArrayCollection::create([3, 6, 9, 12, 15, 18, 21, 24, 30]);
        $merge = $twos->merge($threes);
        $expected = [2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, 3, 6, 9, 12, 15, 18, 21, 24, 30];
        $this->assertSame($expected, $merge->toArray());
    }

    public function test_that_filter_returns_expected_value()
    {
        $collection = ArrayCollection::create([2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30]);
        $expected = [2, 4, 8, 10, 14, 16, 20, 22, 26, 28];
        $this->assertSame($expected, $collection->filter(function ($num) {
            // keep numbers that are not a multiple of 3
            return $num % 3 !== 0;
        })->values()->toArray());
    }

    public function test_that_reject_returns_expected_value()
    {
        $collection = ArrayCollection::create([2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30]);
        $expected = [2, 4, 8, 10, 14, 16, 20, 22, 26, 28];
        $this->assertSame($expected, $collection->reject(function ($num) {
            // remove numbers that are a multiple of 3
            return $num % 3 === 0;
        })->values()->toArray());
    }

    public function test_that_where_returns_expected_value()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $collection = ArrayCollection::create($data);
        $expected = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith']
        ];
        $this->assertSame($expected, $collection->where('last_name', 'Smith')->values()->toArray());
    }

    public function test_that_where_in_returns_expected_value()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $collection = ArrayCollection::create($data);
        $expected = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $this->assertSame($expected, $collection->whereIn('last_name', ['Smith', 'Jenkins'])->values()->toArray());
    }

    public function test_that_slice_returns_expected_value()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $expected = range(2, 7);
        $this->assertSame($expected, $collection->slice(2, 6)->values()->toArray());
    }

    public function test_that_take_returns_expected_pos_values()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $expected = range(0, 2);
        $this->assertSame($expected, $collection->take(3)->values()->toArray());
    }

    public function test_that_take_returns_expected_neg_values()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $expected = range(7, 9);
        $this->assertSame($expected, $collection->take(-3)->values()->toArray());
    }

    public function test_that_skip_returns_expected_values()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $expected = [0, 2, 4, 6, 8];
        $this->assertSame($expected, $collection->skip(2)->values()->toArray());
    }

    public function test_that_even_returns_expected_values()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $expected = [0, 2, 4, 6, 8];
        $this->assertSame($expected, $collection->even()->values()->toArray());
    }

    public function test_that_odd_returns_expected_values()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $expected = [1, 3, 5, 7, 9];
        $this->assertSame($expected, $collection->odd()->values()->toArray());
    }

    public function test_that_partition_returns_expected_value()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $even = [0, 2, 4, 6, 8];
        $odd = [1, 3, 5, 7, 9];
        $parts = $collection->partition(function ($num) {
            return $num % 2 === 0;
        });
        $this->assertTrue(
            $even === $parts[0]->values()->toArray()
            && $odd === $parts[1]->values()->toArray()
        );
    }

    public function test_that_page_returns_expected_value()
    {
        $data = range(0, 99);
        $collection = ArrayCollection::create($data);
        $expected = [45, 46, 47, 48, 49];
        $this->assertSame($expected, $collection->page(10, 5)->values()->toArray());
    }

    public function test_that_implode_returns_expected_value()
    {
        $data = ['Hello', 'World'];
        $collection = ArrayCollection::create($data);
        $this->assertSame('HelloWorld', $collection->implode());
    }

    public function test_that_join_returns_expected_value()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Smith'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $collection = ArrayCollection::create($data);
        $expected = 'John & Jimmy & Sally & Leeroy';
        $this->assertSame($expected, $collection->join(' & ', function ($person) {
            return $person['first_name'];
        }));
    }

    public function test_that_reduce_returns_expected_value()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $this->assertSame(45, $collection->reduce(function ($total, $num) {
            return $total + $num;
        }));
    }

    public function test_that_sum_returns_expected_value_without_argument()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $this->assertSame(45, $collection->sum());
    }

    public function test_that_sum_returns_expected_value_with_argument()
    {
        $data = [
            ['amount' => 1],
            ['amount' => 2],
            ['amount' => 3],
            ['amount' => 4],
            ['amount' => 5],
            ['amount' => 6],
            ['amount' => 7],
            ['amount' => 8],
            ['amount' => 9]
        ];
        $collection = ArrayCollection::create($data);
        $this->assertSame(45, $collection->sum(function ($product) {
            return $product['amount'];
        }));
    }

    public function test_that_avg_returns_expected_value_without_argument()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $this->assertSame(4.5, $collection->avg());
    }

    public function test_that_avg_returns_expected_value_with_argument()
    {
        $data = [
            ['amount' => 1],
            ['amount' => 2],
            ['amount' => 3],
            ['amount' => 4],
            ['amount' => 5],
            ['amount' => 6],
            ['amount' => 7],
            ['amount' => 8],
            ['amount' => 9]
        ];
        $collection = ArrayCollection::create($data);
        $this->assertSame(5, $collection->avg(function ($product) {
            return $product['amount'];
        }));
    }

    public function test_that_average_returns_null_when_empty()
    {
        $this->assertNull(ArrayCollection::create()->average());
    }

    public function test_that_max_returns_expected_value_without_argument()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $this->assertSame(9, $collection->max());
    }

    public function test_that_max_returns_expected_value_with_argument()
    {
        $data = [
            ['amount' => 1],
            ['amount' => 2],
            ['amount' => 3],
            ['amount' => 4],
            ['amount' => 5],
            ['amount' => 6],
            ['amount' => 7],
            ['amount' => 8],
            ['amount' => 9]
        ];
        $collection = ArrayCollection::create($data);
        $this->assertSame(9, $collection->max(function ($product) {
            return $product['amount'];
        }));
    }

    public function test_that_min_returns_expected_value_without_argument()
    {
        $data = range(0, 9);
        $collection = ArrayCollection::create($data);
        $this->assertSame(0, $collection->min());
    }

    public function test_that_min_returns_expected_value_with_argument()
    {
        $data = [
            ['amount' => 1],
            ['amount' => 2],
            ['amount' => 3],
            ['amount' => 4],
            ['amount' => 5],
            ['amount' => 6],
            ['amount' => 7],
            ['amount' => 8],
            ['amount' => 9]
        ];
        $collection = ArrayCollection::create($data);
        $this->assertSame(1, $collection->min(function ($product) {
            return $product['amount'];
        }));
    }

    public function test_that_to_json_returns_expected_value()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Franks'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $collection = ArrayCollection::create($data);
        $expected = <<<JSON
[
    {
        "first_name": "John",
        "last_name": "Smith"
    },
    {
        "first_name": "Jimmy",
        "last_name": "Franks"
    },
    {
        "first_name": "Sally",
        "last_name": "Klien"
    },
    {
        "first_name": "Leeroy",
        "last_name": "Jenkins"
    }
]
JSON;
        $this->assertSame($expected, $collection->toJson(JSON_PRETTY_PRINT));
    }

    public function test_that_it_is_json_encodable()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Franks'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $collection = ArrayCollection::create($data);
        $expected = <<<JSON
[
    {
        "first_name": "John",
        "last_name": "Smith"
    },
    {
        "first_name": "Jimmy",
        "last_name": "Franks"
    },
    {
        "first_name": "Sally",
        "last_name": "Klien"
    },
    {
        "first_name": "Leeroy",
        "last_name": "Jenkins"
    }
]
JSON;
        $this->assertSame($expected, json_encode($collection, JSON_PRETTY_PRINT));
    }

    public function test_that_it_is_string_castable()
    {
        $data = [
            ['first_name' => 'John', 'last_name' => 'Smith'],
            ['first_name' => 'Jimmy', 'last_name' => 'Franks'],
            ['first_name' => 'Sally', 'last_name' => 'Klien'],
            ['first_name' => 'Leeroy', 'last_name' => 'Jenkins']
        ];
        $collection = ArrayCollection::create($data);
        $expected = '[{"first_name":"John","last_name":"Smith"},{"first_name":"Jimmy","last_name":"Franks"},'
            .'{"first_name":"Sally","last_name":"Klien"},{"first_name":"Leeroy","last_name":"Jenkins"}]';
        $this->assertSame($expected, (string) $collection);
    }

    /**
     * @expectedException \Novuso\System\Exception\DomainException
     */
    public function test_that_random_throws_exception_when_request_too_many_items()
    {
        $data = ['foo', 'bar', 'baz', 'buz'];
        ArrayCollection::create($data)->random(5);
    }

    protected function getWeekDays()
    {
        return [
            WeekDay::MONDAY(),
            WeekDay::WEDNESDAY(),
            WeekDay::FRIDAY(),
            WeekDay::TUESDAY(),
            WeekDay::THURSDAY(),
            WeekDay::SATURDAY(),
            WeekDay::SUNDAY()
        ];
    }
}
