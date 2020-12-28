# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/).

## [Unreleased]

### Added

- Started keeping a changelog

### Changed

- Requires PHP 8
- Updated code style
- Renamed `Sequence` interface to `ItemList`
- Renamed `SortedItemCollection` interface to `OrderedItemCollection`
- Renamed `SortedKeyCollection` interface to `OrderedKeyValueCollection`
- Renamed `Novuso\System\Collection\Mixin` namespace to `Novuso\System\Collection\Traits`

### Removed

- Removed `Merge` sort, as stable sorting is available in PHP 8

[Unreleased]: https://github.com/novuso/system/compare/master...develop
