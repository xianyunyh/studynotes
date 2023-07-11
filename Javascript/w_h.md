## JavaScript获取页面的各种宽度和高度
- window.screen.width| window.screen.height 获取屏幕的宽高
- window.innerWidth| window.innerHeight 浏览器视口(viewport)的宽和高，包括滚动条长度
- window.outWidth | window.outHeight 浏览器窗口的宽和高，包含侧边栏、边框

## 获取element的宽度和高度
- ELE.clientWidth | ELE.clientHeight   css的height+css的padding
- ELE.scrollWidth | ELE.scrollHeight 适应视口中所用内容所需的最小高度/宽度
- ELE.getBoundingClientRect() 获取dom元素距离视口的位置
