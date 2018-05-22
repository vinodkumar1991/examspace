<?php
namespace frontend\modules\customer\models;

use yii\db\ActiveRecord;
use Yii;
use yii\db\Query;

class Tokens extends ActiveRecord
{

    public static function tableName()
    {
        return 'tokens';
    }

    public static function create($arrInputs)
    {
        $intInsert = Yii::$app->db->createCommand()
            ->batchInsert('tokens', [
            'category_type',
            'customer_id',
            'token',
            'created_date'
        ], $arrInputs)
            ->execute();
        return $intInsert;
    }

    public static function getTokens($arrInputs = [])
    {
        $objQuery = new Query();
        $objQuery->select([
            'id',
            'category_type',
            'customer_id',
            'token'
        ]);
        $objQuery->from('tokens as t');
        // Customer Id
        if (isset($arrInputs['customer_id']) && ! empty($arrInputs['customer_id'])) {
            $objQuery = $objQuery->andWhere('t.customer_id=:customerId', [
                ':customerId' => $arrInputs['customer_id']
            ]);
        }
        // Token
        if (isset($arrInputs['token']) && ! empty($arrInputs['token'])) {
            $objQuery = $objQuery->andWhere('t.token=:Token', [
                ':Token' => $arrInputs['token']
            ]);
        }
        $arrResponse = $objQuery->all();
        return $arrResponse;
    }
}
 