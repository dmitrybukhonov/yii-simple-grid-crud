<?php

namespace common\models;

use yii\db\ActiveRecord as ActiveRecordVendor;

class ActiveRecord extends ActiveRecordVendor
{
    const IS_NOT_PUBLISHED = 0;
    const IS_PUBLISHED = 1;

    const IS_DELETED = 1;
    const IS_NOT_DELETED = 0;
}
