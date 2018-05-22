<?php
namespace frontend\modules\home\models;

use yii\db\ActiveRecord;
use Yii;
use yii\db\Query;

class Boards extends ActiveRecord
{

    public static function tableName()
    {
        return 'boards';
    }

    public static function getDb()
    {
        return Yii::$app->db2;
    }

    public static function getBoards($arrInputs = [])
    {
        $objQuery = new Query();
        $objQuery->select([
            'b.name',
            'b.state_name',
            'b.category',
            'b.id as board_id'
        ]);
        $objQuery->from('boards as b');
        // state
        if (isset($arrInputs['state']) && ! empty($arrInputs['state'])) {
            $objQuery->andWhere('b.state_name=:stateName', [
                ':stateName' => $arrInputs['state']
            ]);
        }
        $arrResponse = $objQuery->all(self::getDb());
        return $arrResponse;
    }
}