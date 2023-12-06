<?php

namespace frontend\models\search;

use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use frontend\models\fitnes\FitnesClub;
use kartik\daterange\DateRangeBehavior;

class FitnesClubSearch extends FitnesClub
{
    public $is_archive;

    public $created_range;
    public $created_start;
    public $created_end;

    /**
     * @inheritDoc
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'created_range',
                'dateFormat' => false,
                'dateStartAttribute' => 'created_start',
                'dateEndAttribute' => 'created_end',
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
            'name' => 'Name',
            'is_archive' => 'Archive',
            'created_range' => 'Create date',
            'is_published' => 'Status',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
        ];
    }

    /**
     * @inheritDoc
     * @return bool
     */
    public function beforeValidate(): bool
    {
        $this->name = trim($this->name);

        return parent::beforeValidate();
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function rules(): array
    {
        return [
            ['created_range', 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['is_archive'], 'boolean'],
            [['name', 'address'], 'string'],
            [
                [
                    'created_start',
                    'created_end',
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            $this->applyPublishedFilter($query);
            return $dataProvider;
        }

        $this->applyNameFilter($query);
        $this->applyDateFilter($query);
        $this->applyArchiveFilter($query);

        return $dataProvider;
    }

    private function applyPublishedFilter(ActiveQuery $query): void
    {
        $query->published();
    }

    private function applyNameFilter(ActiveQuery $query): void
    {
        $query->andFilterWhere(['LIKE', 'fitnes_club.name', $this->name]);
    }

    private function applyArchiveFilter(ActiveQuery $query): void
    {
        if (!empty($this->is_archive)) {
            $query->andWhere(['fitnes_club.is_published' => FitnesClub::IS_NOT_PUBLISHED]);
        } else {
            $this->applyPublishedFilter($query);
        }
    }

    private function applyDateFilter(ActiveQuery $query): void
    {
        if (!empty($this->created_start) && !empty($this->created_end)) {
            $created_start = $this->created_start . ' 00:00:00';
            $created_end = $this->created_end . ' 23:59:59';

            $query->andFilterWhere(['BETWEEN', 'fitnes_club.created_at', $created_start, $created_end]);
        }
    }
}
