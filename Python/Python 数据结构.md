## more lists

- list.append

    添加一个元素到list中

- list.extend(iterable)

    list转成迭代器

- list.insert(i, x)

    插入一个元素

- list.remove(x)
    
    移动一个元素

- list.pop([i])
 
    出栈

- list.clear()

    清空list

- list.count(x)

    返回列表中x元素出现的次数
    
- list.sort(key=None, reverse=False)

    列表排序
    
- list.reverse()

    列表反转
    
- list.copy()

    复制一个列表
    
    
    lists = ['a','b','c','d','e']

    lists.append('f')
    
    # 插入到第6位
    lists.insert(6,'g')
    
    lists.remove('e')
    
    print(lists.pop())
    
    print(lists.count('a'))
    
    lists.sort()
    
## 使用lists 作为栈

栈先进后出

    lists.append('h')
    
    lists.append('i')
    
    print(lists.pop()) # i
    

## 使用lists作队列

队列 先进先出

    from collections import deque

    queue = deque([])
    
    queue.append('a')
    
    queue.append('b')
    
    print(queue.popleft())
    
    

## set 集合


集合是不允许重复的数据

sets = {1,3,'a','b'}