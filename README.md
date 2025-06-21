# family-album

一个适合家庭/亲友照片管理与温馨展示的开源相册项目。

---

## ✨ 项目简介

**family-album** 提供了低门槛的相册解决方案，支持通过 PHP 脚本自动扫描目录下所有照片，生成 JSON 数据，前端页面自动渲染所有照片内容，适合部署在 GitHub Pages、Vercel、服务器等多种环境。

- 前端静态页面（album.html）自动加载照片和随机“一言”
- 所有图片数据自动整理，无需手动编辑
- 随机文案（一言）支持 Markdown 多文件扩展
- 可作为家庭影集、亲友聚会、宝宝成长、老照片存档等

---

## 📦 目录结构
```

family-album/

├─ photos/       # 存放所有照片
├─ phrases/      # 存放一言的 Markdown 文件，可多个
├─ album/
├───── album.html     # 前端静态模版页面
├───── admin.html     # 后台渲染页面 
├─ gen_json.php    # PHP脚本，生成/更新 photos.json
├─ get_phrase.php   # PHP接口，随机返回一句一言
├─ photos.json     # 自动生成的相册数据
└─ README.md

```
---

## 🚀 快速开始

1. **上传照片**
    - 把你的照片批量放入 `photos/` 目录。
    - 支持 jpg/jpeg/png/gif 等常用图片格式。

2. **配置一言文案**
    - 在 `phrases/` 目录下新建任意 `.md` 文件。
    - 每行写一句家人感悟、生活趣事或有趣的话。

3. **生成相册数据**
    - 在浏览器访问 `gen_json.php`，自动生成 `photos.json`。
    - 每次有新照片、删除照片后都要执行此步骤。

4. **访问相册页面**
    - 直接打开 `album.html` 即可浏览你的家庭影集。
    - 页面顶部会自动显示一条随机“一言”。

---

## 🛠 主要功能

- **自动扫描照片**：php 脚本一键生成数据，无需繁琐维护
- **前端动态渲染**：相册页面自动加载数据与图片
- **文案灵活可配**：Markdown 文件随意写，支持多文件
- **UI 响应式**：PC/手机/大屏都友好
- **可快速扩展**：图片描述/时间/标签、分页、懒加载、播放动画等
- **极简易维护**：只需会用浏览器和简单文件操作

---

## 🤩 项目演示
本地运行：
```php
 php -S localhost:8080
```

浏览器访问 [无忧无虑-百天照](https://wuxiumu.github.io/photo/20250420%E6%97%A0%E5%BF%A7%E6%97%A0%E8%99%91-%E7%99%BE%E5%A4%A9%E7%85%A7.html) 查看我的家庭影集。

### 主页
<img src="https://archive.biliimg.com/bfs/archive/965ee82fde4427a90fd3060a840b0e113b0748f8.png" alt="主页" referrerpolicy="no-referrer">

### 生成页面
<img src="https://archive.biliimg.com/bfs/archive/132c44226f107068420b6a94af68bb1e437b37d7.png" alt="生成页面" referrerpolicy="no-referrer">

 ### 无忧无虑-百天照
<img src="https://archive.biliimg.com/bfs/archive/269811a79bb730ba78e1a7b6121f0218838d87f5.png" alt="无忧无虑-百天照" referrerpolicy="no-referrer">
 

---

## 📝 常见扩展

- **描述补充**：可为每张图片增加同名 txt/md 文件自动读取为描述
- **批量重命名/整理**：用脚本工具自动处理图片文件名
- **自动缩略图/OSS云存储**：支持静态压缩参数或用云服务存图
- **评论/点赞/家庭成员协作**：可结合后端 API 或简单本地存储实现
- **相册分组/标签/搜索**：适配更多管理场景

---

## 👨‍💻 参与贡献

欢迎 PR 新功能、bugfix、UI/动效优化、更多导入导出脚本。  
家庭的回忆，你我共同守护！

---

## 📄 License

MIT

---

> 项目由 [Aric,wuxiumu](https://github.com/wuxiumu) 构建和维护，灵感来自真实生活点滴。
