import { createApp } from 'vue'
import ProductApp from '@/front/App.vue'
import CurrencySymbol from '@/front/components/CurrencySymbol.vue'
import '@/front/product.css'

const app = createApp(ProductApp)
app.provide('setting', window.PrySetting || {} )

app.component('currency-symbol', CurrencySymbol)

app.mount('#pry')
