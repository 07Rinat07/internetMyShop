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
  token_type: string
  access_token: string
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

export type CategoryProductsPayload = {
  category: CategoryTree
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

export type OrderSummary = {
  id: number
  amount: number
  status: OrderStatus
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
}
