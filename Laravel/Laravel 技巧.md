在大型的项目中使用 Laravel Eloquent ORM，某些工作可能会变得重复和繁琐，所以本文为大家总结了 5 个很少人知道的小技巧，在开发过程中帮我节省了很多时间。下面就让我们开始吧。


1. 快速生成 Model & Migration

这并不是一个很多人知道的小技巧，在 Laravel 文档中也没有提到。下面我们以一个博客为简单的例子，为文章生成 Model 和 Migration。

        $ php artisan make:migration create_posts_table
        $ php artisan make:model Post
        
大部分人可能会按上面这样做，其实这两条命令可以合并为下面这一条：

        $ php artisan make:model Post -m
        
2. Eloquent 查询 Scopes

还是以前面的博客应用为例，假设我们的文章表有一个 is_published 字段，其值为 0 或 1 (表示 False 或 True )。在博客列表，我们希望用户只能看到已经发布(published)的文章，使用 Eloquent 我们如何过滤掉未发布的文章呢？答案很明显，需要在查询语句中使用 where 条件：

        Post::where('is_published', true)->get();
        
这当然可以，但如果我们想在其他地方重复使用这个代码段呢？这么重复复制当然也可以实现，但为了符合 DRY 原则( Don’t repeat yourself )，我们可以使用 Eloquent 的查询 Scope。在 Post 模型中创建 ascopePublished 方法：

        class Post extends Model
        {
            public function scopePublished($query)
            {
                return $this->where('is_published', true);
            }
        }
要获取已发布文章，我们只需简单的调用如下命令：


    Post::published()->get();
    
Eloquent 可以自己把它翻译为 scopePublished 方法。Eloquent 模型中任何以 scope 开始是方法都被当做 Eloquent scope。

值得注意的是，Eloquent scope 的返回值必须是一个查询生成器的实例，所以在 scope 中你不能调用 ->get() 或 ->paginate() 。

3. Accessors（访问器）
在很多情况下，你可能需要访问 Eloquent 模型在数据中并不存在，需要经过一定计算的属性，但很抱歉。我们来看一个例子。假设现在有一个 User 表，它包含这样两个字段：forenames和 surname 。如果你想在视图中显示用户全名的话，你不得不这么做：

{{ $user->forenames . ' ' . $user->surname }}
首先，我们的应用中可能有很多地方需要使用这段代码，一遍又一遍的输入显然很不实际。其次，呃，语法非常的丑陋且显得格格不入。下面我们来看看如何通过访问器（又称属性）使其变得更加整洁一些。我们在 User 模型中创建一个新的方法：

        class User extends Model
        {
            public function getNameAttribute()
            {
                return $this->forenames . ' ' . $this->surname;
            }
        }
同 Eloquent 识别 scope 一样，任何以 get 和 Attribute 包裹起来的方法都会当做 Eloquent accesor（访问器）。现在我们可以试着执行下面的代码段，它得到的结果和前面是相同的：

{{ $user->name }}
这不仅可以重复使用，而且更容易输入，并且更具有可读性。

4. 动态方法名称
……缺乏一个很好的术语。Eloquent 对于一些方法特别的聪明，如 where() 。看看下面的例子：

        // Post::where('published', 1)->get();
        Post::wherePublished(1)->get();
         
        // Post::where('category', null)->get();
        Post::whereNull('category')->get();
         
        // Post::where('category', '!=', null)->get();
        Post::whereNotNull('category')->get();
    
是不是更加的整洁？

5. 扩展访问器
我们来扩展一下 #3。有时候，特别是使用 API 时，当我们使用 Eloquent 从数据库获取记录时，需要对返回的结果集中添加一些访问器（或者说属性）。如果没看明白的话，看看下面这个例子。当调用 User::find(1) 的时候，返回的结果看起来可能是下面这样的：

        {
            id: 1,
            forenames: "Terry",
            surname: "Harvey",
            email: "contact@terryharvey.co.uk",
            created_at: "2016-05-02 21:27:58",
            updated_at: "2016-05-03 18:09:37",
        }
这并没有什么问题，但如果我们想在其中显示前面创建的 name 属性呢？让我们回到模型中添加 $appends 属性：

        class User extends Model
        {
            protected $appends = ['name'];
        }
        
如果再次执行前面的代码，name 属性被直接添加到了结果中。

        {
            id: 1,
            forenames: "Terry",
            surname: "Harvey",
            name: "Terry Harvey",
            email: "contact@terryharvey.co.uk",
            created_at: "2016-05-02 21:27:58",
            updated_at: "2016-05-03 18:09:37",
        }