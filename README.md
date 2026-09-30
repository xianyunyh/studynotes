# 学习笔记

个人技术笔记知识库，收录数百篇 Markdown 学习记录。目录按主题整理，中文文件夹已统一迁移为英文名称；笔记标题与正文尽可能保留原貌。

## 本地预览

需要 Node.js 20 或更新版本：

```sh
npm ci
npm run docs:dev
```

生产构建和本地预览：

```sh
npm run docs:build
npm run docs:preview
```

## GitHub Pages 发布

仓库包含 GitHub Actions 工作流。向 `master` 或 `main` 推送后会自动构建并发布 `.vitepress/dist`。首次发布时，请在 GitHub 仓库的 **Settings → Pages → Build and deployment** 中将来源设为 **GitHub Actions**。

发布后的项目站点地址为 `https://xianyunyh.github.io/studynotes/`。本地开发使用根路径，GitHub Actions 构建时会自动应用仓库子路径。

## 内容维护

文档侧栏会在构建时按目录自动生成。新增主题时，请添加英文目录和 `index.md` 导读页；无需手动更新侧栏。个人笔记可能过时，涉及生产使用时请以对应技术的官方文档为准。
