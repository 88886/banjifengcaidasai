#班级风采大赛投票系统
在四川理工学院黄岭学院学生工作二组2015年举办的班级风采大赛中使用，同学们通过教务系统账号登陆系统达到实名认证的目的，然后每人5票对所展示作品投票。这个作品是我的第一个应对高并发的作品。当时具体数据忘记了，当时自己不是太成熟，因为时间匆忙，无论是安全性问题还是高并发问题都没有解决，就急忙上线，导致了一些问题。但是正是因为问题的出现，才让我更快的成长。可以说这个作品具有里程碑标志。
这个系统的开发时间也只有几天，我全栈开发，前台使用的是妹子UI，后台使用的是自己写的一个很渣、很不成熟的php框架（主要是为了自己熟悉MVC）。
我是不推荐将这个系统用于生产环境。学习使用的话，请将vote.sql导入数据库，修改config.php里面的数据库配置，基本上就可以了。  
目录结构如下  
data-----------数据缓存目录  
libs-----------前台和后台的控制方法  
public---------公共资源目录里面是妹子UI  
tpl------------VIEW文件  
ueditor--------百度编辑器  
xsdhyphp-------自己写的MVC框架  
admin.php------后台入口文件  
config.php-----数据库配置文件  
index.php------前台入口文件  
set.conf-------站点配置文件  
vote.sql-------数据库语句  
code.php-------教务管理系统验证码  
curl.class.php-模拟登陆教务管理系统
