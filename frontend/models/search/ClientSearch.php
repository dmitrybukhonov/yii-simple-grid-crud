<?php

namespace frontend\models\search;

use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use frontend\models\client\Client;
use kartik\daterange\DateRangeBehavior;

class ClientSearch extends Client
{
    public $is_archive;

    public $birth_range;
    public $birth_start;
    public $birth_end;

    /**
     * @inheritDoc
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'birth_range',
                'dateFormat' => false,
                'dateStartAttribute' => 'birth_start',
                'dateEndAttribute' => 'birth_end',
                'dateStartFormat' => 'Y-m-d',
                'dateEndFormat' => 'Y-m-d',
            ]
        ];
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'first_name' => 'First name',
            'middle_name' => 'Middle name',
            'last_name' => 'Last name',
            'gender' => 'Gender',
            'birth_range' => 'Birthday',
        ];
    }

    /**
     * @inheritDoc
     * @return bool
     */
    public function beforeValidate(): bool
    {
        $this->first_name = trim($this->first_name);
        $this->middle_name = trim($this->middle_name);
        $this->last_name = trim($this->last_name);

        return parent::beforeValidate();
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function rules(): array
    {
        return [
            ['birth_range', 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['first_name', 'middle_name', 'last_name'], 'string'],
            [['gender'], 'in', 'range' => [parent::GENDER_MAN, parent::GENDER_WOMAN]],
            [
                [
                    'birth_start',
                    'birth_end',
                ],
                'safe',
            ],
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function search($params): ActiveDataProvider
    {
        $query = self::find();
        $query->with('fitnesClubs');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->applyFullNameFilter($query);
        $this->applyDateFilter($query);
        $this->applyGenderFilter($query);

        return $dataProvider;
    }

    private function applyFullNameFilter(ActiveQuery $query): void
    {
        $query->andFilterWhere(['LIKE', 'client.first_name', $this->first_name]);
        $query->andFilterWhere(['LIKE', 'client.middle_name', $this->middle_name]);
        $query->andFilterWhere(['LIKE', 'client.last_name', $this->last_name]);
    }

    private function applyDateFilter(ActiveQuery $query): void
    {
        if (!empty($this->birth_start) && !empty($this->birth_end)) {
            $birth_start = $this->birth_start . ' 00:00:00';
            $birth_end = $this->birth_end . ' 23:59:59';

            $query->andFilterWhere(['BETWEEN', 'client.birth_date', $birth_start, $birth_end]);
        }
    }

    private function applyGenderFilter(ActiveQuery $query): void
    {
        if ($this->gender === (string) parent::GENDER_MAN || $this->gender === (string) parent::GENDER_WOMAN) {
            $query->andWhere(['client.gender' => $this->gender]);
        }
    }
}
