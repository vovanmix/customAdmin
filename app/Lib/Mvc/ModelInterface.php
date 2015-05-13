<?php

namespace Vovanmix\CustomAdmin\Lib\Mvc;

interface ModelInterface{

    public function compactData();

    public function fillData($data);

    public function save();

    public function update();

    public function delete();

}