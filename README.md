# yii2-cos-flysystem

Yii2 tencent-cos(v3/v4/v5) flysystem 

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
    'version' => 'v5',
    'protocol' => 'https',
    'region' => 'ap-shanghai',
    'timeout' => 60,
    'cdn_key' => '',
    'read_from_cdn' => false,
    'encrypt' => false
],
```

More information: [https://github.com/creocoder/yii2-flysystem](https://github.com/creocoder/yii2-flysystem)
