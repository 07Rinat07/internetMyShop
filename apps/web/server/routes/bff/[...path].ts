import { proxyBackendJson } from '../../utils/backend'
import { setResponseStatus } from 'h3'

type ProxyRule = {
  method: string
  pattern: RegExp
  includeAuth?: boolean
  includeBasket?: boolean
}

const proxyRules: ProxyRule[] = [
  { method: 'GET', pattern: /^catalog$/, includeAuth: false, includeBasket: false },
  { method: 'GET', pattern: /^categories\/[^/]+$/, includeAuth: false, includeBasket: false },
  { method: 'GET', pattern: /^brands\/[^/]+$/, includeAuth: false, includeBasket: false },
  { method: 'GET', pattern: /^products\/[^/]+$/, includeAuth: false, includeBasket: false },
  { method: 'GET', pattern: /^basket$/, includeBasket: true },
  { method: 'DELETE', pattern: /^basket$/, includeBasket: true },
  { method: 'POST', pattern: /^basket\/checkout$/, includeBasket: true },
  { method: 'POST', pattern: /^basket\/items$/, includeBasket: true },
  { method: 'PATCH', pattern: /^basket\/items\/\d+$/, includeBasket: true },
  { method: 'DELETE', pattern: /^basket\/items\/\d+$/, includeBasket: true },
  { method: 'GET', pattern: /^profiles$/ },
  { method: 'POST', pattern: /^profiles$/ },
  { method: 'GET', pattern: /^profiles\/\d+$/ },
  { method: 'PATCH', pattern: /^profiles\/\d+$/ },
  { method: 'PUT', pattern: /^profiles\/\d+$/ },
  { method: 'DELETE', pattern: /^profiles\/\d+$/ },
  { method: 'GET', pattern: /^orders$/ },
  { method: 'GET', pattern: /^orders\/\d+$/ },
]

export default defineEventHandler(async (event) => {
  const method = event.node.req.method || 'GET'
  const rawPath = event.context.params?.path
  const path = Array.isArray(rawPath) ? rawPath.join('/') : rawPath

  if (!path) {
    setResponseStatus(event, 404)

    return {
      message: 'Not found.',
    }
  }

  const normalizedPath = path.replace(/^\/+/, '').replace(/\/+$/, '')
  const matchedRule = proxyRules.find((rule) => rule.method === method && rule.pattern.test(normalizedPath))

  if (!matchedRule) {
    setResponseStatus(event, 404)

    return {
      message: 'Not found.',
    }
  }

  return await proxyBackendJson(event, `/${normalizedPath}`, {
    includeAuth: matchedRule.includeAuth,
    includeBasket: matchedRule.includeBasket,
  })
})
