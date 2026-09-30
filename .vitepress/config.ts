import { readdirSync, readFileSync } from 'node:fs'
import { join, relative, sep } from 'node:path'
import { defineConfig } from 'vitepress'

const root = process.cwd()
const ignoredDirectories = new Set(['.git', '.vitepress', 'node_modules'])

const categoryTitles: Record<string, string> = {
  'algorithms-and-data-structures': '算法与数据结构',
  'c-language': 'C 语言',
  'design-patterns': '设计模式',
  docker: 'Docker',
  Elastic: 'Elasticsearch',
  git: 'Git',
  go: 'Go',
  Javascript: 'JavaScript',
  Laravel: 'Laravel',
  Linux: 'Linux 与命令行',
  miscellaneous: '工程实践与杂项',
  Mysql: 'MySQL',
  Nodejs: 'Node.js',
  OpenAPI: 'OpenAPI',
  'operating-systems': '操作系统',
  PHP: 'PHP',
  Python: 'Python',
  redis: 'Redis',
}

function markdownFiles(directory: string): string[] {
  return readdirSync(directory, { withFileTypes: true }).flatMap((entry) => {
    const path = join(directory, entry.name)
    if (entry.isDirectory()) {
      return ignoredDirectories.has(entry.name) ? [] : markdownFiles(path)
    }
    return entry.isFile() && entry.name.toLowerCase().endsWith('.md') ? [path] : []
  })
}

function pageTitle(path: string): string {
  const heading = readFileSync(path, 'utf8').match(/^#\s+(.+)$/m)?.[1]
  return heading?.replace(/[`*_]/g, '').trim() || path.split(sep).at(-1)!.replace(/\.md$/i, '')
}

function pageLink(path: string): string {
  const route = relative(root, path).split(sep).join('/').replace(/\.md$/i, '')
  return route.endsWith('/index') ? `/${route.slice(0, -6)}/` : `/${route}`
}

function pageItem(path: string) {
  return { text: pageTitle(path), link: pageLink(path) }
}

function folderItems(directory: string) {
  const files = readdirSync(directory, { withFileTypes: true })
  const index = files.find((entry) => entry.isFile() && entry.name.toLowerCase() === 'index.md')
  const items = index ? [{ text: '主题导读', link: pageLink(join(directory, index.name)) }] : []
  const articles = files
    .filter((entry) => entry.isFile() && entry.name.toLowerCase().endsWith('.md') && entry.name.toLowerCase() !== 'index.md')
    .map((entry) => pageItem(join(directory, entry.name)))
    .sort((left, right) => left.text.localeCompare(right.text, 'zh-CN', { numeric: true }))
  items.push(...articles)

  const subdirectories = files
    .filter((entry) => entry.isDirectory() && !ignoredDirectories.has(entry.name))
    .filter((entry) => markdownFiles(join(directory, entry.name)).length > 0)
    .map((entry) => join(directory, entry.name))
    .sort((left, right) => left.localeCompare(right, 'zh-CN', { numeric: true }))

  for (const subdirectory of subdirectories) {
    const pages = markdownFiles(subdirectory)
    const nestedItems = folderItems(subdirectory)
    if (pages.length === 1 && pages[0].toLowerCase().endsWith(`${sep}index.md`)) {
      items.push(...nestedItems)
      continue
    }
    items.push({
      text: subdirectory.split(sep).at(-1)!,
      collapsed: true,
      items: nestedItems,
    })
  }
  return items
}

const sidebar = [
  {
    text: '开始与资源',
    items: markdownFiles(root)
      .filter((path) => {
        const rootFile = path.toLowerCase()
        return relative(root, path).split(sep).length === 1
          && rootFile !== join(root, 'readme.md').toLowerCase()
          && rootFile !== join(root, 'index.md').toLowerCase()
      })
      .map(pageItem)
      .sort((left, right) => left.text.localeCompare(right.text, 'zh-CN')),
  },
  ...readdirSync(root, { withFileTypes: true })
    .filter((entry) => entry.isDirectory() && !ignoredDirectories.has(entry.name))
    .filter((entry) => markdownFiles(join(root, entry.name)).length > 0)
    .map((entry) => ({
      text: categoryTitles[entry.name] ?? entry.name,
      collapsed: true,
      items: folderItems(join(root, entry.name)),
    }))
    .sort((left, right) => left.text.localeCompare(right.text, 'zh-CN')),
]

export default defineConfig({
  lang: 'zh-CN',
  title: '学习笔记',
  description: '关于编程语言、框架、系统与工程实践的个人学习笔记。',
  base: process.env.GITHUB_ACTIONS ? '/studynotes/' : '/',
  lastUpdated: false,
  cleanUrls: true,
  themeConfig: {
    nav: [
      { text: '首页', link: '/' },
      { text: '主题总览', link: '/catalog' },
      { text: 'GitHub', link: 'https://github.com/xianyunyh/studynotes' },
    ],
    sidebar,
    search: { provider: 'local' },
    outline: { level: [2, 3], label: '本页目录' },
    docFooter: { prev: '上一篇', next: '下一篇' },
    lastUpdated: { text: '最后更新于' },
    returnToTopLabel: '返回顶部',
    sidebarMenuLabel: '笔记导航',
    darkModeSwitchLabel: '外观',
    lightModeSwitchTitle: '切换到浅色模式',
    darkModeSwitchTitle: '切换到深色模式',
    footer: {
      message: '个人学习记录，内容仅供参考；涉及生产环境时请核对官方文档。',
      copyright: 'Copyright © 2026 学习笔记',
    },
  },
})
