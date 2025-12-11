# Advent of Code Solutions

My personal toolkit for tackling Advent of Code puzzles. Built with Laravel Zero to handle the repetitive parts - downloading inputs, generating solution templates, timing execution, and submitting answers - so I can focus on the actual problem-solving.

**Author:** Conny Sjöblom (conny@sjoblom.io)

## What It Does

- 🎯 **Automatic puzzle prep** - Downloads input files and creates solution templates
- ⚡ **Solution runner** - Executes solutions with timing information
- 📤 **Answer submission** - Submit answers directly without leaving the terminal
- 🧪 **Test support** - Generate test files for working through examples

## Setup

1. Clone and install dependencies:
   ```bash
   composer install
   ```

2. Get your session cookie from adventofcode.com (check browser dev tools while logged in)

3. Configure it in the application - this lets the CLI download your personalized inputs and submit answers

## My Workflow

### Starting a New Puzzle

```bash
./advent prepare {day} [--year=YYYY] [--test]
```

This creates a solution class and downloads my input file. I usually add `--test` to also generate a test file for the example input.

**Examples:**
```bash
./advent prepare 1                    # Today's year, day 1
./advent prepare 5 --year=2023       # Go back to 2023
./advent prepare 3 --test            # Include test file
./advent prepare 1 --force           # Overwrite existing solution
```

### Running Solutions

```bash
./advent run {day} {part} [--year=YYYY] [--time] [--submit]
```

I typically run with `--time` first to see performance, then add `--submit` once I'm confident in the answer.

**Examples:**
```bash
./advent run 1 1                     # Run day 1, part 1
./advent run 5 2 --year=2023        # Specific year
./advent run 3 1 --time             # Show execution time
./advent run 7 2 --submit           # Run and submit answer
```

## Development Tools

Keep code clean and tested:

```bash
./vendor/bin/pest                    # Run tests
./vendor/bin/pint                    # Fix code style
./vendor/bin/phpstan                 # Static analysis
```

## Technical Notes

- Built on Laravel Zero for a solid CLI foundation
- Solutions organized by year in `app/Solutions/`
- Inputs stored in `storage/input/`
- Requires PHP ^8.4.0 and GMP extension

## About Advent of Code

[Advent of Code](https://adventofcode.com/) is an annual coding challenge created by Eric Wastl. It runs every December with daily programming puzzles. Please respect the creator's work and the community guidelines when using automation tools.

## License

Open-source under the MIT license.
