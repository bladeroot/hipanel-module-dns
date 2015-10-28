<?php

namespace hipanel\modules\dns\models;

use hipanel\base\Model;
use Yii;

class Zone extends Model
{
    use \hipanel\base\ModelTrait;

    public static function index()
    {
        return 'dnss';
    }

    public static function type()
    {
        return 'dns';
    }

    public function rules()
    {
        return [
            [['id', 'client_id', 'seller_id', 'account_id', 'server_id'], 'integer'],
            [['domain', 'client', 'seller', 'name', 'account', 'server'], 'safe'],
            [['url_fw', 'dns_on', 'is_reg_domain'], 'boolean'],
            [['nss', 'mail', 'park'], 'safe'],
        ];
    }

    public function getRecords() {
        return $this->hasMany(Record::className(), ['id' => 'hdomain_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
        ]);
    }

    /**
     * @return array
     */
    public function scenarioCommands()
    {
        return [
        ];
    }
}
