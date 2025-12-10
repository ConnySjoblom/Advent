#!/usr/bin/env python3
"""
Z3 constraint solver for button press optimization.
Reads JSON input from stdin and outputs the minimum number of button presses.
"""
import json
import sys
from z3 import *

def solve_button_presses(matrix, target):
    """
    Solve for minimum button presses to reach target values.

    Args:
        matrix: List of lists where matrix[button][counter] = 1 if button affects counter
        target: List of target values for each counter

    Returns:
        Minimum sum of button presses, or None if no solution exists
    """
    num_buttons = len(matrix)
    num_counters = len(target)

    # Create Z3 solver
    solver = Optimize()

    # Create variables for button presses (non-negative integers)
    presses = [Int(f'press_{i}') for i in range(num_buttons)]

    # Add constraint: all presses must be non-negative
    for p in presses:
        solver.add(p >= 0)

    # Add constraint: for each counter, sum of effects must equal target
    for counter_idx in range(num_counters):
        # Calculate the sum of button presses affecting this counter
        effects = []
        for button_idx in range(num_buttons):
            if matrix[button_idx][counter_idx] == 1:
                effects.append(presses[button_idx])

        # The sum of effects must equal the target value
        if effects:
            solver.add(Sum(effects) == target[counter_idx])
        else:
            # If no button affects this counter, target must be 0
            if target[counter_idx] != 0:
                return None

    # Minimize the total number of button presses
    total_presses = Sum(presses)
    solver.minimize(total_presses)

    # Check if solution exists
    if solver.check() == sat:
        model = solver.model()
        result = sum(model[p].as_long() for p in presses)
        return result
    else:
        return None

def main():
    # Read JSON input from stdin
    input_data = json.load(sys.stdin)

    matrix = input_data['matrix']
    target = input_data['target']

    # Solve
    result = solve_button_presses(matrix, target)

    if result is not None:
        print(result)
    else:
        print("NO_SOLUTION", file=sys.stderr)
        sys.exit(1)

if __name__ == '__main__':
    main()
