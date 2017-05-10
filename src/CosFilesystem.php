<?php

namespace takashiki\yii2\flysystem;

use creocoder\flysystem\Filesystem;
use yii\base\InvalidConfigException;

class CosFilesystem extends Filesystem
{
    /**
     * @var string
     */
    public $version = 'v4';

    /**
     * @var string
     */
    public $protocol = 'http';

    /**
     * @var string only work for cos-v4
     */
    public $region = 'sh';

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
     * @var array
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
     * @return \Freyo\Flysystem\QcloudCOSv3\Adapter|\Freyo\Flysystem\QcloudCOSv4\Adapter
     */
    protected function prepareAdapter()
    {
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

        $adaptorClass = \Freyo\Flysystem\QcloudCOSv3\Adapter::class;
        if ($this->version === 'v4') {
            $config['region'] = $this->region;
            $adaptorClass = \Freyo\Flysystem\QcloudCOSv4\Adapter::class;
        }

        return new $adaptorClass($config);
    }
}
