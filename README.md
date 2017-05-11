# yii2-cos-flysystem

Yii2 tencent-cos(v3/v4) flysystem 

## Install

```
composer require takashiki/yii2-cos-flysystem
```

## Usage

```php
'cosFs' => [
    'class' => \takashiki\yii2\flysystem\CosFilesystem::class,
    'app_id' => 'xxx',
    'secret_id' => 'xxx',
    'secret_key' => 'xxx',
    'bucket' => 'xxx',
    'domain' => 'xxx.file.myqcloud.com',
    
    // not necessarily bellow 
    'version' => 'v4',
    'protocol' => 'http',
    'region' => 'sh',
    'timeout' => 60,
],
```

More information: [https://github.com/creocoder/yii2-flysystem](https://github.com/creocoder/yii2-flysystem)
