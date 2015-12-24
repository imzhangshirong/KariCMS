domain/
	+ api       //所有可调用的api
	+ cache      //保存通过templates生成的用于生成静态页的模板
	+ libs       //必要的库和配置文件，同时还包括api.php、index.php使用规范
	+ statics     //包含生成页面的img，css，js
	+ sys        //后台操作页面
	+ templates    //栏目和文章页模板
	 api.php     //调用api的主入口
	 index.php    //管理页面通过ajax请求此文件获取子操作页面（sys）
	 main.php     //管理页面


后台代码部分简述

listorder="0" id ASC
listorder="1" id DESC
listorder="2" listorder ASC
listorder="3" listorder DESC
listorder="4" listorder ASC,id ASC
listorder="5" listorder DESC,id DESC
listorder="6" listorder DESC,updatetime ASC
listorder="7" listorder DESC,updatetime DESC

{mc catid="1" listorder="1" return="data" num="3" page="1"}//page默认=0，如果为"1"则进行分页page()函数可以输出页码和翻页

其他请参考 templates 内文件

http://www.zhangshirong.com/2015/1107/010414.html