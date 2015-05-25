<?php

namespace Site;

if (!defined('IN_PX'))
    exit;

use Tools\Auxi;
use Model;
use Tools\Log4p as logger;

/**
 * Class Index
 * @package Site
 */
class Tutorial extends AbstractCommon {

    private function __Controller() {}

//    private function __Value($cfg, $setting) {}

    protected function __Inject($session, Model\Tutorial $tutorial, Model\TutorialChapter $tutorialChapter,
                                Model\TutorialStudyHistory $tutorialStudyHistory) {}

    public function tutorial() {
        $_rs = $this->tutorial->findAll();
        foreach ($_rs as $m) {
            $m->chapterList = $this->tutorialChapter->findAll($m->tutorial_id);
            //所有打开过的单元
            $m->studyHistory = $this->tutorialStudyHistory->findAll2Array($m->tutorial_id);
        }
        $this->tutorialRs = $_rs;

        $_top = null;
        $this->topTip = '继续课程';

        if (!is_null($this->session->user)) {
            $_top = $this->tutorialStudyHistory->findOne();
        }
        if (!$_top) {
            $this->topTip = '推荐课程';
            $_top = $this->tutorial->top();
        }
        $this->topRs = $_top;

        return true;
    }

    public function tutorialShow($__RequestMapping = '/tutorial/{id:\d+}',
                                 $__Inject = array('\Model\Opus' => '$opus')) {
        $this->chapterRs = $this->tutorialChapter->find($this->id);
        $this->prevTutorial = intval($this->tutorialChapter->prev($this->chapterRs->tutorial_id, $this->chapterRs->release_date));
        $this->nextTutorial = intval($this->tutorialChapter->next($this->chapterRs->tutorial_id, $this->chapterRs->release_date));

        $this->pageSeoTitle = $this->chapterRs->chapter_name;

        if ($this->chapterRs->opus_example != '') {
            $this->opusExampleRs = $this->opus->in(explode(',', $this->chapterRs->opus_example));
        }

        $this->opusQA = $this->tutorialChapter->findQA($this->id);

        return 'tutorial/weike';
    }

}
