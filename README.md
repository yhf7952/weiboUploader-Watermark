# 微博图床/本地图床

基于PHP的新浪微博图床批量传图工具，上传-缩放-水印-生成链接一键搞定

# 演示地址

https://bak.yantuz.cn:8000/weiboUploader-Watermark/


**以上地址仅供演示，长期使用建议自己搭建服务器。上传的所有图片不定期清理**

![演示效果](https://bak.yantuz.cn:8000/img/upload/2019/05/5cc8f9e6f23ff.jpg)

# 更新日志
2019/5/1：
增加[本地版](https://github.com/yhf7952/weiboUploader-Watermark/tree/%E6%9C%AC%E5%9C%B0%E7%89%88)
支持图片HTML/UBB/MarkDown格式自由切换
支持上传图片批量复制

# 环境要求

* PHP >= 7.0
* json 扩展
* openssl 扩展
* fileinfo扩展
* allow_url_fopen

upload文件夹为图片备份目录，需设置777权限

vendor/consatan/weibo_image_uploader/cache/为微博cookie存放目录，需777权限

# 参考资料

H5上传页：http://fex.baidu.com/webuploader/

图像处理：http://image.intervention.io/

上传微博：https://github.com/consatan/weibo_image_uploader

# 详细介绍/讨论

* https://bak.yantuz.cn:8000/376.html
* 博客：[岩兔站](https://yantuz.cn "岩兔站-关注互联网折腾服务器分享码农的日常")
* 微博：[新浪微博](https://weibo.com/yantuz "岩兔站")
