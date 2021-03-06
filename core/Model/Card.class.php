<?php

namespace Model;

if (!defined('IN_PX'))
    exit;
use Tools\MsgHelper;
use Tools\Log4p as logger;

class Card {

    private function __Model() {}

    private function __Inject($db) {}

    public function save($cardPost)
    {
        //新增
        //  $this->db->debug();
        //查看收藏过就不可再收藏
        if ($this->db->table('`#@__@user_card`')->where('`user_id` = ? AND `tutorial_chapter_id` = ?')
            ->bind(array(
                $cardPost['user_id'], $_POST['tutorial_chapter_id']
            ))->exists()
        ) {
            return MsgHelper::aryJson('EXISTS_CARD');
        }
        $_row = array(
            'card_id' => '?',
            'user_id' => '?',
            'tutorial_chapter_id' => '?',
            'add_date' => '?'
        );
        $_insert = $this->db->table('`#@__@user_card`')
            ->row($_row)
            ->bind($cardPost)
            ->save();
        if ($_insert > 0) {
            return MsgHelper::aryJson('SUCCESS');
        }

    }
    public function find_user_cards($start = 5,$user_id=0, $end = null)
    {    // $this->db->debug();
        //user_card,tutorial单元表，tutorial_chapter单元章节表（card_front,card_back）

        return $this->db->select('c.*,tc.`card_front`,tc.`card_back`,tc.`tutorial_chapter_id`,tc.`chapter_name`,t.`title`')
            ->table('`#@__@user_card` c')
            ->inner('`#@__@tutorial_chapter` tc', 'c.`tutorial_chapter_id` = tc.`tutorial_chapter_id`')
            ->left('`#@__@tutorial` t', 't.`tutorial_id` = tc.`tutorial_id`')
            ->where('c.`user_id`= ? ')
            ->order('c.`add_date`',"ASC")
            ->bind(array($user_id))->findAll();


    }


}
