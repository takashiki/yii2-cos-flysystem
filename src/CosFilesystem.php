<?php

namespace takashiki\yii2\flysystem;

use creocoder\flysystem\Filesystem;
use Qcloud\Cos\Client;
use yii\base\InvalidConfigException;

class CosFilesystem extends Filesystem
{
    /**
     * @var string
     */
    public $version = 'v5';

    /**
     * @var string
     */
    public $protocol = 'https';

    /**
     * @var string v5:ap-shanghai / v4:sh / v3:empty
     */
    public $region = 'ap-shanghai';

    /**
     * @var string
     */
    public $domain;

    /**
     * @var string
     */
    public $app_id;

    /**
     * @var string
     */
    public $secret_id;

    /**
     * @var string
     */
    public $secret_key;

    /**
     * @var string
     */
    public $bucket;

    /**
     * @var int
     */
    public $timeout = 60;

    /**
     * @var string
     */
    public $cdn_key = '';

    /**
     * @var bool
     */
    public $read_from_cdn;

    /**
     * @var bool
     */
    public $encrypt;

    /**
     * @var bool
     */
    public $debug = YII_DEBUG;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if ($this->domain === null) {
            throw new InvalidConfigException('The "domain" property must be set.');
        }

        if ($this->app_id === null) {
            throw new InvalidConfigException('The "app_id" property must be set.');
        }

        if ($this->secret_id === null) {
            throw new InvalidConfigException('The "secret_id" property must be set.');
        }

        if ($this->secret_key === null) {
            throw new InvalidConfigException('The "secret_key" property must be set.');
        }

        if ($this->bucket === null) {
            throw new InvalidConfigException('The "bucket" property must be set.');
        }

        parent::init();
    }

    /**
     * @return Freyo\Flysystem\QcloudCOSv3\Adapter|Freyo\Flysystem\QcloudCOSv4\Adapter|Freyo\Flysystem\QcloudCOSv5\Adapter
     */
    protected function prepareAdapter()
    {
        if ($this->version === 'v5') {
            return $this->prepareAdapterV5();
        }

        $config = [
            'protocol' => $this->protocol,
            'domain' => $this->domain,
            'app_id' => $this->app_id,
            'secret_id' => $this->secret_id,
            'secret_key' => $this->secret_key,
            'timeout' => $this->timeout,
            'bucket' => $this->bucket,
            'debug' => $this->debug,
        ];

        $adaptorClass = Freyo\Flysystem\QcloudCOSv3\Adapter::class;
        if ($this->version === 'v4') {
            $config['region'] = $this->region;
            $adaptorClass = Freyo\Flysystem\QcloudCOSv4\Adapter::class;
        }

        return new $adaptorClass($config);
    }

    protected function prepareAdapterV5()
    {
        $config = [
            'region' => $this->region,
            'credentials' => [
                'appId' => $this->app_id,
                'secretId' => $this->secret_id,
                'secretKey' => $this->secret_key,
            ],
            'timeout' => $this->timeout,
            'connect_timeout' => $this->timeout,
            'bucket' => $this->bucket,
            'cdn' => $this->domain,
            'scheme' => $this->protocol,
            'read_from_cdn' => $this->read_from_cdn,
            'cdn_key' => $this->cdn_key,
            'encrypt' => $this->encrypt,
        ];

        $client = new Client($config);

        return new Freyo\Flysystem\QcloudCOSv5\Adapter($client, $config);
    }
}
