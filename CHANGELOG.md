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

## [1.2.0] - 2026-06-20

### Changed

* Refactored the lexer and parser architecture to use semantic token types for options, flags, and arguments.
* Simplified tokenization and parsing workflows by moving command-line structure classification into the lexer.
* Reduced parser complexity by consuming pre-classified tokens directly instead of validating low-level token sequences.
* Updated the test suite to reflect the new tokenization and parsing behavior.

### Removed

* Removed legacy token types (`T_DASH`, `T_EQUAL`, `T_LITERAL_0`, `T_LITERAL_1`) from the parsing workflow.