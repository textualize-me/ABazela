<?php
namespace App\Model;

use App\Service\Config;

class Plant
{
    private ?int $id = null;
    private ?string $type = null;
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Plant
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): Plant
    {
        $this->type = $type;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Plant
    {
        $this->content = $content;

        return $this;
    }

    public static function fromArray($array): Plant
    {
        $plant = new self();
        $plant->fill($array);

        return $plant;
    }

    public function fill($array): Plant
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['type'])) {
            $this->setType($array['type']);
        }
        if (isset($array['content'])) {
            $this->setContent($array['content']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM plant';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $plants = [];
        $plantsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($plantsArray as $plantArray) {
            $plants[] = self::fromArray($plantArray);
        }

        return $plants;
    }

    public static function find($id): ?Plant
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM plant WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $plantArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $plantArray) {
            return null;
        }
        $plant = Plant::fromArray($plantArray);

        return $plant;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getId()) {
            $sql = "INSERT INTO plant (type, content) VALUES (:type, :content)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'type' => $this->getType(),
                'content' => $this->getContent(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE plant SET type = :type, content = :content WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':type' => $this->getType(),
                ':content' => $this->getContent(),
                ':id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM plant WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setType(null);
        $this->setContent(null);
    }
}
