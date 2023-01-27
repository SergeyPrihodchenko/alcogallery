<?php

namespace Alco\Market\Class\Repository;

use Alco\Market\Class\Content\Content;
use Exception;
use PDO;

class ContentsRepository {

    public function __construct(
        private PDO $connect
    )
    {
    }

    public function save(Content $content): void 
    {
        $query = <<<SQL
            INSERT INTO contents
                (name, description, img_name)
            VALUES
                (:name, :description, :img_name)
        SQL;

        try {
            $statement = $this->connect->prepare($query);
        $statement->execute([
            ':name' => $content->name(),
            ':description' => $content->description(),
            ':img_name' => $content->img_name()
        ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}