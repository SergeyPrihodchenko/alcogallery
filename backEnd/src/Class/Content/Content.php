<?php

namespace Alco\Market\Class\Content;

class Content {

    public function __construct(
        private string $name,
        private string $description,
        private string $img_name
    )
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function img_name(): string
    {
        return $this->img_name;
    }

    public static function validator(string $str): string
    {
        $trimStr = trim($str);
        $stripStr = strip_tags($trimStr);
        $res = preg_replace('/[^ a-zа-я\d.!:!(!)]/ui', '', $stripStr);
        return $res;
    }
}