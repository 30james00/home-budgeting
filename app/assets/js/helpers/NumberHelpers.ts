/**
 * Prepare value from API for display assuming 100 multiplier
 * @param a value from API (100 times multiplied
 * @return string String with 2 places after the decimal point ready for display
 */
export function normalizeFloat(a: number): string {
    return (a / 100).toFixed(2);
}

/**
 * Convert value from form to API value with 100 multiplier
 * @param s Value from form
 */
export function normalizeFormValue(s: string): string {
    return (parseFloat(s) * 100).toString()
}