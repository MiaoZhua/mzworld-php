<?php

namespace Site\Api;

if (!defined('IN_PX'))
    exit;

use Phoenix\RequestMethod;
use Site\AbstractCommon;
use Tools\MsgHelper;
use Model;
use Tools\Log4p as logger;

class Avatar extends AbstractCommon {

    private function __RestController() {}

    private function __RequestMapping($value = '/api/avatar') {}

    private function __Method($value = RequestMethod::POST) {}

    protected function __Inject(Model\MaterialAvatar $materialAvatar) {}

    public function read() {
        $_rs = $this->materialAvatar->findAll();
        $_avatasList = array();
        if (count($_rs) > 0) {
            foreach ($_rs as $_ar) {
                switch ($_ar->parts) {
                    case '0' :
                        $_avatasList['body'][] = array(
                            $_ar->material_avatar_id,
                            $_ar->src_front,
                            $_ar->src_rear
                        );
                        break;
                    case '1' :
                        $_avatasList['hair'][] = array(
                            $_ar->material_avatar_id,
                            $_ar->src_front
                        );
                        break;
                    case '2' :
                        $_avatasList['face'][] = array(
                            $_ar->material_avatar_id,
                            $_ar->src_front
                        );
                        break;
                    case '3' :
                        $_avatasList['clothes'][] = array(
                            $_ar->material_avatar_id,
                            $_ar->src_front
                        );
                        break;
                }
            }
        }
        return $_avatasList;
    }
}
