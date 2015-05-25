<?php

namespace Site\Api;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Service\UPFile;
use Tools\MsgHelper;
use Model;
use Tools\Log4p as logger;

class TutorialStudyHistory extends AbstractCommon
{

    private function __RestController(){ }

    private function __RequestMapping($value = '/api/tutorialStudyHistory'){ }

    private function __Method($value = RequestMethod::POST){ }

    protected function __Inject($session, Model\TutorialChapter $tutorialChapter){}

    public function save_study_history()
    {
        if (!is_null($this->session->user)) {
            //查出单元id
            return $this->tutorialChapter->save_study_history($_POST['chapter_id']);
        }

    }


}
