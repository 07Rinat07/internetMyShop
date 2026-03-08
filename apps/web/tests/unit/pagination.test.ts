import { describe, expect, it } from 'vitest'
import { normalizePositivePage } from '../../utils/pagination'

describe('pagination utils', () => {
  it('defaults invalid values to the first page', () => {
    expect(normalizePositivePage(undefined)).toBe(1)
    expect(normalizePositivePage(null)).toBe(1)
    expect(normalizePositivePage('abc')).toBe(1)
    expect(normalizePositivePage(0)).toBe(1)
    expect(normalizePositivePage(-5)).toBe(1)
  })

  it('normalizes valid values to positive integers', () => {
    expect(normalizePositivePage('3')).toBe(3)
    expect(normalizePositivePage(7.9)).toBe(7)
  })
})
