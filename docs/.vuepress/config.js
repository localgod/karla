import { viteBundler } from '@vuepress/bundler-vite'
import { defaultTheme } from '@vuepress/theme-default'
import { defineUserConfig } from 'vuepress'

export default defineUserConfig({
  bundler: viteBundler(),
  theme: defaultTheme(),
  lang: 'en-US',
  title: 'Karla',
  description: 'Php ImageMagick wrapper with method chaining',
  base: "/karla/",
})