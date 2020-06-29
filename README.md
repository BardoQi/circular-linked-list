# Circular Linked List
# 环形链表
## 简介
本组件基于设计模式中的迭代器模式，通过代码实现，够将数组当成环形链表来使用。
因为，PHP现在增加了生成器函数Yield，因而大大方便了环形链表的开发。
也许你会问，这个库有什么用？
最常见的应用场景有：
* 地理数据中的边界多边形，如果要进行特征数据计算时，则会相当方便。
* 动态图表显示时，常常是用环形链表显示所有数据，并且动态更新开始位置，结束位置，动态用新数据覆盖旧数据。
* 其它可能需要的场景

## 特性
* 支持带接头的数组。比如地理数据多边形就有接头，最后一个元素与第一个是相同的。最后一个就是接头。
* 支持元素更新，查找，插入，移除，添加等操作。
* 支持顺序迭代 nextItems() 与逆序迭代 prevItems()，
* 支持多圈迭代 nextItemsWithCount()  prevItemsWithCout()，
* 支持任意整数的开始位置与结束位置
* 具有双向链表完全特性，可以通过，nextItem()和prevItem() 获取前一元素以下后面元素。nextKey()和prevKey() 获以前一元素和后一元素的Key
* 支持队列所需的特性，具有push,pop,shift,unshift操作，且队列也支持接头。
* 函数清单
     + getKey($key)
 + nextKey($key)
 + prevKey($key)
 + nextItems($from, $to)
 + nextItemsWithCount($from, $count)
 + prevItems($from, $to)
 + prevItemsWithCount($from, $count)
 + nextItem($key)
 + prevItem($key)
 + prevCount($from,$to)
 + nextCount($from,$to)
 + getItem($key)
 + setAt($pos,$value)
 + add($value)
 + push($value)
 + pop()
 + shift()
 + unshift($value)
 + insertAt($pos,$value)
 + removeAt($pos)
 + isNeighbours($keyA,$keyB)
 + count()
 + isEmpty()
 + size()
 + findByPos($pos)
 + find($value,$strict=false)
 + toArray()
  
## 安装
```php
$ composer require "bardoqi/circular-linked-list"
```

## 代码示例
* 参考/test中的源码

## 作者
Bardeen QI <Bardoqi@gmail.com>

## 版权
MIT

