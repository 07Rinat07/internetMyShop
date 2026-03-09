import { expect, test } from '@playwright/test'

test('user can login, add product to basket and checkout', async ({ page }) => {
  await page.goto('/login')

  await page.getByLabel('Email').fill('buyer@example.test')
  await page.getByLabel('Password').fill('Password123!')
  await page.getByTestId('auth-submit').click()

  await expect(page).toHaveURL(/\/profile$/)

  await page.goto('/products/e2e-backpack')
  await expect(page.locator('h1')).toContainText('E2E Backpack')

  await page.getByTestId('product-detail-add-button').click()
  await expect(page.getByText(/Added to basket\./)).toBeVisible()

  await page.goto('/basket')
  await expect(page.getByTestId('basket-item')).toContainText('E2E Backpack')

  await page.getByTestId('basket-checkout-link').click()
  await expect(page).toHaveURL(/\/checkout$/)

  await page.getByTestId('saved-profile-use').first().click()
  await page.getByTestId('checkout-submit').click()
  await page.getByTestId('checkout-card-submit').click()

  await expect(page).toHaveURL(/\/payments\//)
  await expect(page.getByTestId('payment-status-card')).toContainText('Payment received successfully')

  await page.getByRole('link', { name: 'My orders' }).click()
  await expect(page).toHaveURL(/\/orders$/)
  await expect(page.getByTestId('order-list-item')).toHaveCount(1)

  await page.getByTestId('order-view-details').click()
  await expect(page.getByTestId('order-detail')).toContainText('E2E Backpack')
})
