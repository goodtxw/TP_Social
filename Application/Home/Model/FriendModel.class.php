<?php
    namespace Home\Model;

    use Think\Model\RelationModel;

    class FriendModel extends RelationModel
    {
        protected $_link = array(
            'FriendGroup' => array(
                'mapping_type' => self::HAS_MANY,
                'mapping_name' => 'FriendGroup',
                'claa_name' => 'FriendGroup',
                'foreign_key' => 'id',
                'parent_key' => 'fg_id',
            ),
        );
    }