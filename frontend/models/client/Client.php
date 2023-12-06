<?php

namespace frontend\models\client;

use common\models\fitnes\FitnesClub;
use common\models\client\Client as ClientCommon;

class Client extends ClientCommon
{
    public $club_ids;

    /**
     * @inheritDoc
     */
    public function afterFind(): void
    {
        parent::afterFind();
        $this->club_ids = $this->getFitnesClubs()->select('id')->column();
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->updateClubs();
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels(): array
    {
        return [
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'birth_date' => 'Birth Date',
            'club_ids' => 'Фитнес клубы',
        ];
    }

    /**
     * @return void
     */
    private function updateClubs(): void
    {
        $selectedClubIds = $this->club_ids ?: [];
        $existingClubs = $this->fitnesClubs;

        foreach ($existingClubs as $club) {
            if (!in_array($club->id, $selectedClubIds, false)) {
                $this->unlink('fitnesClubs', $club, true);
            }
        }

        if (!empty($selectedClubIds)) {
            $clubsToAdd = FitnesClub::find()
                ->where(['id' => $selectedClubIds])
                ->all();

            foreach ($clubsToAdd as $club) {
                $this->link('fitnesClubs', $club);
            }
        }
    }
}
