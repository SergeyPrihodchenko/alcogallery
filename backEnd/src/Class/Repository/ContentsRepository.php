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

    public function getContent(): array
    {
        $contents = [];
        try {
            $statement = $this->connect->query("SELECT * FROM contents;");
            while ($result = $statement->fetch(PDO::FETCH_ASSOC)) {
                $result['img_name'] = $result['img_name'];
                $result['description'] = nl2br($result['description']);
                $contents[] = $result;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $contents;
    }
}