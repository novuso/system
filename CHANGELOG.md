# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0] - 2020-12-28

### Added

- Started keeping a changelog
- Added `SystemLibrary::VERSION` constant

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
[2.0.0]: https://github.com/novuso/system/compare/1.1.0...2.0.0
