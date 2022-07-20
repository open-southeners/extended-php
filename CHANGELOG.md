# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Enum functions: `enum_is_backed`, `get_enum_class`, `enum_to_array`, `enum_values`

## [0.7.0] - 2022-07-15

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
