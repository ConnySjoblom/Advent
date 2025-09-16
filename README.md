# Advent of Code Solutions

A Laravel Zero CLI application for managing and running Advent of Code puzzle solutions.

## About

This project provides a command-line interface for solving Advent of Code puzzles. It's built on top of Laravel Zero, offering an elegant and powerful framework for console applications.

**Author:** Conny Sjöblom (conny@sjoblom.io)

## Features

- 🎯 **Automatic puzzle preparation** - Download input files and generate solution templates
- ⚡ **Solution runner** - Execute solutions with timing information
- 📤 **Answer submission** - Submit answers directly to Advent of Code
- 🧪 **Test generation** - Create test files for your solutions
- 📊 **Performance tracking** - Monitor solve and execution times

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up your Advent of Code session cookie in the configuration

## Usage

### Preparing a Puzzle

Generate solution template and download input data:

```bash
./advent prepare {day} [--year=YYYY] [--test] [--force]
```

**Examples:**
```bash
./advent prepare 1                    # Prepare day 1 for current year
./advent prepare 5 --year=2023       # Prepare day 5 for 2023
./advent prepare 3 --test            # Prepare day 3 with test file
./advent prepare 1 --force           # Force prepare (overwrite existing)
```

### Running Solutions

Execute your puzzle solutions:

```bash
./advent run {day} {part} [--year=YYYY] [--time] [--submit]
```

**Examples:**
```bash
./advent run 1 1                     # Run day 1, part 1
./advent run 5 2 --year=2023        # Run day 5, part 2 for 2023
./advent run 3 1 --time             # Run with timing information
./advent run 7 2 --submit           # Run and submit answer
```

## Project Structure

```
app/
├── Commands/           # CLI commands
│   ├── PrepareCommand.php
│   └── RunCommand.php
├── Solutions/          # Puzzle solutions organized by year
│   ├── Year2015/
│   ├── Year2017/
│   ├── Year2018/
│   ├── Year2019/
│   ├── Year2020/
│   ├── Year2021/
│   ├── Year2024/
│   └── Solution.php    # Base solution class
└── Support/           # Helper classes

storage/input/         # Downloaded puzzle inputs
stubs/                 # Templates for new solutions
tests/                 # Test files
```

## Configuration

1. Obtain your session cookie from adventofcode.com
2. Configure it in your application settings
3. The session cookie is required for downloading inputs and submitting answers

## Requirements

- PHP ^8.4.0
- Composer
- GMP extension

## Development

### Running Tests

```bash
./vendor/bin/pest
```

### Code Style

```bash
./vendor/bin/pint
```

### Static Analysis

```bash
./vendor/bin/phpstan
```

## License

This project is open-source software licensed under the [MIT license](LICENSE).

## Advent of Code

[Advent of Code](https://adventofcode.com/) is an annual coding challenge created by Eric Wastl. Please respect the creator's work and the community guidelines when using this tool.