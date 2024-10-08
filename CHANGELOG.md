# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2024-08-15

### Changed

- Name of the package from `open-southeners/laravel-helpers` to `open-southeners/extended-php` as Laravel Helpers are now located as `open-southeners/extended-laravel` ([repository here](https://github.com/open-southeners/extended-laravel)
- As package name changed we reflected the change to all namespaces, **search `OpenSoutheners/LaravelHelpers` and replace by `OpenSoutheners/ExtendedPhp`**

### Removed

- **All functions from models (moved to the extended-laravel package so replace this one with the Laravel one)**. To get this right you should **search `OpenSoutheners/LaravelHelpers/Models` and replace by `OpenSoutheners/ExtendedLaravel/Models`**

## [0.15.1] - 2024-01-22

### Fixed

- Function `short_number` stops at M (millions) preventing overflow number removals

## [0.15.0] - 2024-01-22

### Added

- Function `short_number` to convert big numbers to suffixed strings like (`1000` to `1K`, `1000000` to `1M`)

## [0.14.0] - 2023-11-17

### Changed

- Reusable `GetsAttributes::getDescription()` method (now public), backward compatible change

## [0.13.2] - 2023-10-25

### Fixed

- `OpenSoutheners\ExtendedPhp\Utils\parse_http_query` handle empty input with empty return
- `OpenSoutheners\ExtendedPhp\Utils\build_http_query` handle empty input with empty return

## [0.13.1] - 2023-10-24

### Fixed

- `OpenSoutheners\ExtendedPhp\Utils\parse_http_query` with nested modifiers under parameter keys & simple values (strings)
- `OpenSoutheners\ExtendedPhp\Utils\build_http_query` with nested modifiers under parameter keys & simple values (strings)

## [0.13.0] - 2023-10-23

### Added

- `OpenSoutheners\ExtendedPhp\Utils\parse_http_query` function for HTTP query parameters parse to multidimensional arrays
- `OpenSoutheners\ExtendedPhp\Utils\build_http_query` function for HTTP query parameters build from arrays

## [0.12.0] - 2023-10-23

### Added

- `OpenSoutheners\ExtendedPhp\Strings\is_json_structure` function that covers what `is_json` does not, will also check if the json is a structure and not cases like `0`, `"0"`, `"hello world"`... which are valid in `is_json`
- `OpenSoutheners\ExtendedPhp\Strings\is_json` fallback to PHP 8.3 `json_validate` native function with deprecation warning

### Changed

- `OpenSoutheners\ExtendedPhp\Strings\is_json` now accepts any type as input value following PHP's functions

## [0.11.0] - 2023-06-10

### Added

- `OpenSoutheners\ExtendedPhp\Enums\GetsAttributes` trait and `OpenSoutheners\ExtendedPhp\Enums\Description` attribute so enums cases can be described and used in arrays.

## [0.10.0] - 2023-02-17

### Added

- PHPUnit 10 support
- Tests for Laravel 10

### Changed

- Types to native PHP (when possible)

## [0.9.0] - 2022-12-13

### Added

- PHP 8.2 support

## [0.8.1] - 2022-07-21

### Removed

- `class_exists` function, using PHP's instead (was an anti-pattern function)

## [0.8.0] - 2022-07-20

### Changed

- Enum functions now are namespaced as `OpenSoutheners\ExtendedPhp\Enums` instead of `OpenSoutheners\ExtendedPhp`
- `has_case` enum function now throws exception when value is not an enum

### Added

- Enum functions: `enum_is_backed`, `get_enum_class`, `enum_to_array`, `enum_values`

## [0.7.0] - 2022-07-19

### Changed

- `Models\instance_from` now takes 2 more parameters (with relationships & enforce, which prevents lazyLoading when false)

## [0.6.1] - 2022-07-15

### Fixed

- Missing autoload-dev, tests were autoloaded with the released version (ouch!)

## [0.6.0] - 2022-07-11

### Removed

- Drop support for PHP 7.4
- Unused dependency `laravel/helpers`

## [0.5.1] - 2022-06-21

### Fixed

- `is_model` returns deprecation notice when sending `null` value

## [0.5.0] - 2022-04-06

### Added

- `get_email_domain` string helper to get the domain part of an email adress

### Changed

- Make `instance_from` fail-safe

## [0.4.0] - 2022-04-06

### Added

- Way to nest methods in `call` helper

### Fixed

- Minor fixes to model and class functions

## [0.3.0] - 2022-04-05

### Added

- `call` and `call_static` functions

## [0.2.0] - 2022-04-04

### Changed

- Simplify tests and functions improving coverage
- Move the repository to a new organization

## [0.1.0] - 2021-12-09

### Added

- Initial release!
