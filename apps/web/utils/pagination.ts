export function normalizePositivePage(value: unknown): number {
  const parsed = Number(value || 1)

  if (Number.isNaN(parsed) || parsed < 1) {
    return 1
  }

  return Math.floor(parsed)
}
