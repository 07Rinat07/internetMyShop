export type ApiEnvelope<T> = {
  data: T
}

export type PaginatedResponse<T> = ApiEnvelope<T[]> & {
  meta: PaginationMeta
  links: PaginationLinks
}

export type PaginatedEnvelope<T> = ApiEnvelope<T> & {
  meta: PaginationMeta
  links: PaginationLinks
}

export type PaginationMeta = {
  current_page: number
  last_page: number
  per_page: number
  total: number
}

export type PaginationLinks = {
  first: string | null
  last: string | null
  prev: string | null
  next: string | null
}

export type AuthUser = {
  id: number
  name: string
  email: string
  admin: boolean
  created_at: string | null
  updated_at: string | null
}

export type AuthResponseData = {
  user: AuthUser
}

export type LoginPayload = {
  email: string
  password: string
  device_name?: string
}

export type RegisterPayload = LoginPayload & {
  name: string
  password_confirmation: string
}

export type CategoryTree = {
  id: number
  parent_id: number | null
  name: string
  slug: string
  content: string | null
  image: string | null
  children: CategoryTree[]
}

export type Brand = {
  id: number
  name: string
  slug: string
  content: string | null
  image: string | null
  products_count?: number | null
}

export type ProductReference = {
  id: number
  name: string
  slug: string
}

export type ProductListItem = {
  id: number
  name: string
  slug: string
  price: number
  image: string | null
  flags: {
    new: boolean
    hit: boolean
    sale: boolean
  }
  brand: ProductReference | null
  category: ProductReference | null
}

export type CatalogIndexPayload = {
  categories: CategoryTree[]
  brands: Brand[]
}

export type HomeEditorial = {
  eyebrow: string
  title: string
  description: string
  cta: string
  category: CategoryTree
}

export type HomePayload = {
  new: ProductListItem[]
  hit: ProductListItem[]
  sale: ProductListItem[]
  editorials: HomeEditorial[]
}

export type CategoryProductsPayload = {
  category: CategoryTree
  products: ProductListItem[]
}

export type BrandProductsPayload = {
  brand: Brand
  products: ProductListItem[]
}

export type Profile = {
  id: number
  title: string
  name: string
  email: string
  phone: string
  address: string
  comment: string | null
}

export type ProfilePayload = Omit<Profile, 'id'>

export type OrderStatus = {
  code: number
  label: string | null
}

export type PaymentStatus = {
  code: string
  label: string | null
}

export type PaymentProvider = {
  code: string
  label: string | null
}

export type PaymentMethodCode = 'online_card' | 'manager_confirmation'

export type PaymentMethod = {
  code: PaymentMethodCode
  label: string | null
}

export type OrderSummary = {
  id: number
  amount: number
  currency: string
  status: OrderStatus
  payment_method: PaymentMethod
  items_count: number
  created_at: string | null
  updated_at: string | null
}

export type OrderItem = {
  id: number
  product_id: number | null
  name: string
  price: number
  quantity: number
  cost: number
  product: {
    id: number
    slug: string
  } | null
}

export type OrderDetail = OrderSummary & {
  name: string
  email: string
  phone: string
  address: string
  comment: string | null
  items: OrderItem[]
}

export type PaymentDetail = {
  id: string
  amount: number
  currency: string
  store_amount: number
  store_currency: string
  conversion_rate: number
  checkout_flow: string
  status: PaymentStatus
  provider: PaymentProvider
  redirect_url: string | null
  failure_reason: string | null
  paid_at: string | null
  created_at: string | null
  updated_at: string | null
  order?: OrderSummary
}

export type CheckoutResponse = {
  order: OrderDetail
  payment: PaymentDetail | null
}

export type BasketItem = {
  product_id: number
  name: string
  slug: string
  price: number
  quantity: number
  cost: number
  image: string | null
  flags: {
    new: boolean
    hit: boolean
    sale: boolean
  }
  brand: ProductReference | null
  category: ProductReference | null
}

export type Basket = {
  id: number
  positions: number
  amount: number
  items: BasketItem[]
}

export type CheckoutPayload = {
  name: string
  email: string
  phone: string
  address: string
  comment: string
  payment_method: PaymentMethodCode
}

export type PaymentCheckoutConfig = {
  payment_id: string
  flow: string
  status_url: string
  provider_payment_id: string | null
  capture_url?: string
  sdk?: {
    namespace: string
    client_id: string
    client_token: string
    currency: string
    intent: string
    components: string[]
    merchant_id: string
    script_url: string
  }
  sandbox_card?: {
    number: string
    expiry: string
    cvv: string
    postal_code: string
  }
}

export type ProductDetail = ProductListItem & {
  content: string | null
}
