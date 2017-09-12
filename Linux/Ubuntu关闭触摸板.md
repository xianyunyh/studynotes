## Ubuntu关闭触摸板


有时候在笔记本使用Ubuntu，触摸板经常会碰到。所以就想关闭。以下是方法

```
#关闭触摸板： 

sudo modprobe -r psmouse 

#打开触摸板： 

sudo modprobe psmouse

```