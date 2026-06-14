# Changelog

All notable changes to this project will be documented in this file.

The format is based on Keep a Changelog.

## [1.0.0] - 2026-06-06

### Added
- Initial stable release of Argv
- CLI command parsing from `$argv`
- Options and flags support
- Positional arguments handling
- Zero dependency architecture
- PHP 8.2+ support

## [1.1.0] - 2026-06-14

### Changed
- Refactored internal argument parsing logic for improved safety and edge-case handling.
- Replaced `TokenEnum` with direct conditional validation to simplify runtime behavior.

### Fixed
- Prevented unsafe array slicing when processing CLI arguments by introducing a boundary check (`count($arguments) > 1`).