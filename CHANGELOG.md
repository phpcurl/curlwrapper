# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
## [3.0.0]
### Added
- php 7 type hints.
- This changelog

### Removed
- Initialization in constructors. Now `init()` has to be called explicitly.
- php 5 support.
- php 7.1 support.

### Fixed
- Incorrect handling of uninitialized pass-by-ref argument in `CurlMulti::exec()` (#8).

### Changed
- Documentation to reflect the interfaces.

## [2.1.0] - 2017-01-20
### Added
- `CurlInterface`.
- `CurlMultiInterface`.
- `CurlShareInterface`.

## [2.0.1] - 2017-01-20
### Changed
- Minor documentation improvements.

## [2.0.0] - 2017-01-20
### Added
- `Curl` object destructor to close the handler.
- `Curl::getHandle()`.
- `CurlMulti::init()`.
- `CurlShare::init()`.

### Removed
- php 5.3 and 5.4 support.
- Retry on failure feature.
- `CurlException` class.

### Changed
- `Curl::version`, `Curl::strError`, `CurlMulti::strError` are not static anymore.

## [1.0.0] - 2016-02-02
### Changed
- The library moved to "phpcurl/curlwrapper".

## [0.1.2] - 2016-02-02
### Fixed
- The `$opt` flag should not be artificially set to 0.

## [0.1.1] - 2016-01-21
### Changed
- Minor documentation improvements.

## [0.1.0] - 2016-01-21
### Added
- Documentation
- `CurlException` class.

## [0.0.2] - 2014-02-19
### Changed
- Test cleanup.

## 0.0.1 - 2014-02-17
### Added
- Initial version.

[Unreleased]: https://github.com/phpcurl/curlwrapper/compare/3.0.0...HEAD
[3.0.0]: https://github.com/phpcurl/curlwrapper/compare/2.1.0...3.0.0
[2.1.0]: https://github.com/phpcurl/curlwrapper/compare/2.0.1...2.1.0
[2.0.1]: https://github.com/phpcurl/curlwrapper/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/phpcurl/curlwrapper/compare/1.0.0...2.0.0
[1.0.0]: https://github.com/phpcurl/curlwrapper/compare/0.1.2...1.0.0
[0.1.2]: https://github.com/phpcurl/curlwrapper/compare/0.1.1...0.1.2
[0.1.1]: https://github.com/phpcurl/curlwrapper/compare/0.1.0...0.1.1
[0.1.0]: https://github.com/phpcurl/curlwrapper/compare/0.0.2...0.1.0
[0.0.2]: https://github.com/phpcurl/curlwrapper/compare/0.0.1...0.0.2
