<?php

namespace app\models;

use Yii;
use yii\helpers\Html; 

/**
 * This is the model class for table "map_warp_weaver_inventory".
 *
 * @property int $id
 * @property int $date
 * @property int $warp_weaver_id
 * @property int|null $from_warp_weaver_id
 * @property int|null $given_yarn_quantity
 * @property float|null $given_yarn_weight
 * @property int|null $return_yarn_quantity
 * @property float|null $return_yarn_weight
 * @property int|null $given_jarigai_quantity
 * @property float|null $given_jarigai_weight
 * @property int|null $return_jarigai_quantity
 * @property float|null $return_jarigai_weight
 * @property int|null $produced_sarees
 * @property int|null $production_return_sarees
 * @property float|null $actual_amount
 * @property float|null $given_amount
 * @property float|null $advance_amount
 * @property float|null $mistake_amount
 * @property int|null $payment_mode
 * @property float|null $given_net_transfer_amount
 *
 * @property MapWarpWeaver $fromWarpWeaver
 * @property MapWarpWeaver $warpWeaver
 */
class MapWarpWeaverInventory extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'map_warp_weaver_inventory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'warp_weaver_id'], 'required'],
            [['date', 'warp_weaver_id', 'from_warp_weaver_id', 'given_yarn_quantity', 'return_yarn_quantity', 'given_jarigai_quantity', 'return_jarigai_quantity', 'produced_sarees', 'production_return_sarees', 'payment_mode'], 'integer'],
            [['given_yarn_weight', 'return_yarn_weight', 'given_jarigai_weight', 'return_jarigai_weight', 'actual_amount', 'given_amount', 'given_net_transfer_amount', 'advance_amount', 'mistake_amount'], 'number'],
            [['from_warp_weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapWarpWeaver::className(), 'targetAttribute' => ['from_warp_weaver_id' => 'id']],
            [['warp_weaver_id'], 'exist', 'skipOnError' => true, 'targetClass' => MapWarpWeaver::className(), 'targetAttribute' => ['warp_weaver_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
            'warp_weaver_id' => Yii::t('app', 'Warp Weaver'),
            'from_warp_weaver_id' => Yii::t('app', 'From Warp Weaver'),
            'given_yarn_quantity' => Yii::t('app', 'Given Yarn Quantity'),
            'given_yarn_weight' => Yii::t('app', 'Given Yarn Weight (kgs)'),
            'return_yarn_quantity' => Yii::t('app', 'Return Yarn Quantity'),
            'return_yarn_weight' => Yii::t('app', 'Return Yarn Weight (kgs)'),
            'given_jarigai_quantity' => Yii::t('app', 'Given Jarigai Kattai'),
            'given_jarigai_weight' => Yii::t('app', 'Given Jarigai Weight (kgs)'),
            'return_jarigai_quantity' => Yii::t('app', 'Return Jarigai Katti'),
            'return_jarigai_weight' => Yii::t('app', 'Return Jarigai Weight (kgs)'),
            'produced_sarees' => Yii::t('app', 'Produced Sarees'),
            'production_return_sarees' => Yii::t('app', 'Mistake Sarees'),
            'actual_amount' => Yii::t('app', 'Actual Amount'),
            'given_amount' => Yii::t('app', 'Given Cash Amount'),
            'given_net_transfer_amount' => Yii::t('app', 'Given Net Transfer Amount'),
            'advance_amount' => Yii::t('app', 'Advance Amount'),
            'mistake_amount' => Yii::t('app', 'Mistake Amount'),
            'payment_mode' => Yii::t('app', 'Payment Mode'),
        ];
    }

    /**
     * Gets query for [[FromWarpWeaver]].
     *
     * @return \yii\db\ActiveQuery|MapWarpWeaverQuery
     */
    public function getFromWarpWeaver()
    {
        return $this->hasOne(MapWarpWeaver::className(), ['id' => 'from_warp_weaver_id']);
    }

    /**
     * Gets query for [[WarpWeaver]].
     *
     * @return \yii\db\ActiveQuery|MapWarpWeaverQuery
     */
    public function getWarpWeaver()
    {
        return $this->hasOne(MapWarpWeaver::className(), ['id' => 'warp_weaver_id']);
    }

    /**
     * {@inheritdoc}
     * @return MapWarpWeaverInventoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MapWarpWeaverInventoryQuery(get_called_class());
    }

    public function gridAction()
    {
        $gridAction = parent::gridAction();

        $gridAction['template'] = '{View} {Update} {Delete} {Print}';
        $gridAction['buttons']['Print'] = function ($url, $model) {
            return Html::a(
                '<i class="fa fa-print gridActionIcon"></i>', 
                'javascript:;', 
                [
                    'title' => 'Print',
                    'class' => 'printWarpWeaverInventory'
                ]
            );
        };

        return $gridAction;
    }

    public function beforeValidate()
    {
        if (!empty($this->date) && ($convertedDate = strtotime($this->date))) {
            $this->date = $convertedDate;
        } 
        if (!empty($this->given_amount) || !empty($this->given_net_transfer_amount)) {
            if ($this->given_amount > 0 && $this->given_net_transfer_amount > 0) {
                $this->payment_mode = 3;
            } elseif ($this->given_amount > 0) {
                $this->payment_mode = 1;
            } elseif ($this->given_net_transfer_amount > 0) {
                $this->payment_mode = 2;
            }
        }
        return parent::beforeValidate();
    }

    public function getWeaverLoomAndSareeTypeDetails($warpWeaverId)
    {
        $sql = 'SELECT
                    st.*,
                    st.name as saree_type_name,
                    u1.name as weaver_name,
                    u.name as warp_provider_name,
                    ww.name as warp_name,
                    ww.left_pettu_yelai,
                    ww.body_yelai,
                    ww.right_pettu_yelai,
                    ww.body_colour,
                    ww.pettu_colour,
                    ww.minimum_sarees,
                    ww.warp_roller_name,
                    wl.loom_name,
                    ww.status as warp_status
                FROM
                    map_warp_weaver ww
                    JOIN map_weaver_loom wl ON wl.id = ww.weaver_loom_id
                    JOIN saree_type st ON ww.saree_type_id = st.id
                    JOIN user u ON ww.warp_provider_id = u.id
                    JOIN user u1 ON wl.weaver_id = u1.id
                WHERE
                    ww.id =:warpWeaverId';
        $sqlQuery = Yii::$app->getDb()->createCommand($sql, [':warpWeaverId' => $warpWeaverId]);

        return $sqlQuery->queryOne();
    }

    public function getWarpWeaverInventoryData($warpWeaverId)
    {
        $mapWarpWeaverInventoryData = [
            'all_inventory_records' => [], 
            'manipulated_business_data' => [
                'sareeCountCalculation' => [
                    'saree_type_name' => ' -- ',
                    'warp_name' => ' -- ',
                    'weaver_name' => ' -- ',
                    'loom_name' => ' -- ',
                    'warp_provider_name' => ' -- ',
                    'warp_roller_name' => ' -- ',
                    'warp_status' => null, 
                    'left_pettu_yelai' => ' -- ',
                    'body_yelai' => ' -- ',
                    'right_pettu_yelai' => ' -- ',
                    'body_colour' => ' -- ',
                    'pettu_colour' => ' -- ',
                    'minimum_sarees' => ' -- ', 
                    'required_yarn_weight' => ' -- ', 
                    'required_jarigai_weight' => ' -- ', 
                    'required_babeen_meter' => ' -- ', 
                    'total_sarees_weaver_produced' => ' -- ', 
                    'total_mistake_sarees_weaver_produced' => ' -- ', 
                    'given_yarn_weight' => ' -- ', 
                    'given_jarigai_weight' => ' -- ', 
                    'given_babeen_meter' => ' -- ', 
                    'needed_minimum_sarees' => ' -- ', 
                    'needed_yarn_weight' => ' -- ', 
                    'needed_jarigai_weight' => ' -- ', 
                    'needed_babeen_meter' => ' -- ', 
                    'total_weaver_advance_fee_inhand' => ' -- ', 
                    'needed_jarigai_quantity_to_return' => ' -- ',
                    'saree_out_weaver_fees' => 0,
                    'expected_sarees_produced' => ' -- '
                ],
                'manipulativeData' => [],
                'warpBabeenDetails' => []
            ]
        ];
        if ($warpWeaverId > 0) {
            $manipulativeData = $warpBabeenDetails = []; 
            $sareeCountCalculation = $mapWarpWeaverInventoryData['manipulated_business_data']['sareeCountCalculation'];
            $sareesTypeDetails = $this->getWeaverLoomAndSareeTypeDetails($warpWeaverId);

            $warpCopyFields = [
                'saree_type_name', 'warp_name', 'weaver_name', 'loom_name', 'warp_provider_name', 'warp_roller_name', 
                'warp_status', 'left_pettu_yelai', 'body_yelai', 'right_pettu_yelai', 'body_colour', 
                'pettu_colour'
            ];
            foreach ($warpCopyFields as $fieldName) {
                $sareeCountCalculation[$fieldName] = $sareesTypeDetails[$fieldName];
            }
            /** Required Inventory */
            $sareeCountCalculation['minimum_sarees'] = $sareesTypeDetails['minimum_sarees'];
            $sareeCountCalculation['saree_out_weaver_fees'] = $sareesTypeDetails['out_weaver_fee'];
            $sareeCountCalculation['required_yarn_weight'] = $sareesTypeDetails['minimum_sarees']*$sareesTypeDetails['yarn_weight'];
            $sareeCountCalculation['required_jarigai_weight'] = $sareesTypeDetails['minimum_sarees']*$sareesTypeDetails['jarigai_weight'];

            /** Need to give inventory */
            $sareeCountCalculation['needed_minimum_sarees'] = $sareeCountCalculation['minimum_sarees'];
            $sareeCountCalculation['needed_yarn_weight'] = $sareeCountCalculation['required_yarn_weight'];
            $sareeCountCalculation['needed_jarigai_weight'] = $sareeCountCalculation['required_jarigai_weight'];
            
            if (in_array($sareesTypeDetails['pettu_type'], [1, 2])) {
                $sareeCountCalculation['required_babeen_meter'] = ($sareesTypeDetails['minimum_sarees']*$sareesTypeDetails['babeen_meter'])*$sareesTypeDetails['pettu_type'];
                $warpBabeenDetails = (new MapWarpBabeenWeaver())->getwarpBabeenDetails($warpWeaverId);
                $sareeCountCalculation['given_babeen_meter'] = 0;
                if (!empty($warpBabeenDetails)) {
                    $sareeCountCalculation['given_babeen_meter'] = array_sum(array_column($warpBabeenDetails, 'consolidated_given_babeen_length'));
                }
                $sareeCountCalculation['needed_babeen_meter'] = $sareeCountCalculation['required_babeen_meter'] - $sareeCountCalculation['given_babeen_meter'];
            }

            $tempData = MapWarpWeaverInventorySearch::find()->where(['warp_weaver_id' => $warpWeaverId])->asArray()->all(); 
            if (!empty($tempData)) {
                $totalNotToManipulate = ['id', 'date', 'warp_weaver_id', 'from_warp_weaver_id', 'payment_mode'];
                foreach ($tempData as $index => $eachRecord) {
                    foreach ($eachRecord as $key => $value) {
                        $value = $value == 0 || $value == null ? '' : $value;
                        $tempData[$index][$key] = $value;

                        if (in_array($key, $totalNotToManipulate) == false) {
                            if (array_key_exists($key, $manipulativeData) == false) {
                                $manipulativeData[$key] = 0;
                            } 
                            $manipulativeData[$key] += $value == '' ? 0 : $value;
                        }
                    }
                }
                $mapWarpWeaverInventoryData['all_inventory_records'] = $tempData;

                /** Given and used inventory */
                $totalProducedSarees = $manipulativeData['produced_sarees'];
                $totalUsedYarn = ($manipulativeData['given_yarn_weight']-$manipulativeData['return_yarn_weight']);
                $totalUsedJarigai = ($manipulativeData['given_jarigai_weight']-$manipulativeData['return_jarigai_weight']);
                
                $sareeCountCalculation['total_sarees_weaver_produced'] = $totalProducedSarees;
                $sareeCountCalculation['total_mistake_sarees_weaver_produced'] = $manipulativeData['production_return_sarees'];
                $sareeCountCalculation['given_yarn_weight'] = $totalUsedYarn;
                $sareeCountCalculation['given_jarigai_weight'] = $totalUsedJarigai;
                $sareeCountCalculation['given_jarigai_quantity'] = $manipulativeData['given_jarigai_quantity'];
                $sareeCountCalculation['return_jarigai_quantity'] = $manipulativeData['return_jarigai_quantity'];
                
                $requiredWeaverFee = ($totalProducedSarees*$sareesTypeDetails['out_weaver_fee']) - $manipulativeData['mistake_amount'];
                $totalWeaverFee = ($manipulativeData['given_amount']+$manipulativeData['advance_amount']+$manipulativeData['given_net_transfer_amount']);
                $sareeCountCalculation['required_weaver_fee_with_mistake_deduction'] = $requiredWeaverFee;
                $sareeCountCalculation['total_weaver_fee_with_mistake_deduction'] = $totalWeaverFee;
                $sareeCountCalculation['total_weaver_mistake_deduction_fee'] = $manipulativeData['mistake_amount'];
                $sareeCountCalculation['total_weaver_advance_fee_inhand'] = $totalWeaverFee - $requiredWeaverFee;
                
                /** Need to give inventory */
                $sareeCountCalculation['needed_minimum_sarees'] = $sareeCountCalculation['minimum_sarees'] - $sareeCountCalculation['total_sarees_weaver_produced'];
                $sareeCountCalculation['needed_yarn_weight'] = $sareeCountCalculation['required_yarn_weight'] - $totalUsedYarn;
                $sareeCountCalculation['needed_jarigai_weight'] = $sareeCountCalculation['required_jarigai_weight'] - $totalUsedJarigai;
                $sareeCountCalculation['needed_jarigai_quantity_to_return'] = $sareeCountCalculation['given_jarigai_quantity'] - $sareeCountCalculation['return_jarigai_quantity'];

                $expectedSarees = [
                    $totalUsedYarn > 0 ? floor($totalUsedYarn/$sareesTypeDetails['yarn_weight']) : 0,
                    $totalUsedJarigai > 0? floor($totalUsedJarigai/$sareesTypeDetails['jarigai_weight']) : 0
                ];
                if (in_array($sareesTypeDetails['pettu_type'], [1, 2])) {
                    $totalUsedBabeen = ($totalProducedSarees*$sareesTypeDetails['babeen_meter'])*$sareesTypeDetails['pettu_type'];
                    $neededBabeenForRemaingSarees = ($sareeCountCalculation['required_babeen_meter'] - $totalUsedBabeen);
                    $sareeCountCalculation['used_babeen_meter'] = $totalUsedBabeen;
                    
                    $expectedSarees[] = intval($sareeCountCalculation['given_babeen_meter']/($sareesTypeDetails['babeen_meter']*$sareesTypeDetails['pettu_type']));
                }

                $sareeCountCalculation['expected_sarees_produced'] = min($expectedSarees);
            }
            $mapWarpWeaverInventoryData['manipulated_business_data'] = [
                'sareeCountCalculation' => $sareeCountCalculation,
                'manipulativeData' => $manipulativeData,
                'warpBabeenDetails' => $warpBabeenDetails
            ];
        }

        return $mapWarpWeaverInventoryData;
    }
}
