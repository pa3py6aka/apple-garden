<?php

namespace core\Entity;

use core\Entity\query\AppleQuery;
use core\Enum\AppleStatus;
use Exception;
use Yii;
use yii\base\InvalidCallException;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string|null $color
 * @property int $birth_date
 * @property int|null $fall_date
 * @property float $size
 * @property int $status
 */
class Apple extends \yii\db\ActiveRecord
{
    public static function tableName(): string
    {
        return 'apples';
    }

    public function rules(): array
    {
        return [
            ['color', 'required'],
            ['color', 'string', 'max' => 7],
            ['color', 'match', 'pattern' => '/^#[0-9a-f]{3,6}$/i'],

            ['birth_date', 'required'],
            ['birth_date', 'integer'],

            ['fall_date', 'integer'],

            ['size', 'double', 'min' => 0, 'max' => 1],

            ['status', 'required'],
            ['status', 'in', 'range' => array_keys(AppleStatus::getArray())],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'birth_date' => 'Дата появления',
            'fall_date' => 'Дата падения',
            'size' => 'Размер',
            'status' => 'Статус',
        ];
    }

    public static function find(): AppleQuery
    {
        return new AppleQuery(static::class);
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @throws Exception
     */
    public function getBirthDate(): \DateTime
    {
        return new \DateTime($this->birth_date);
    }

    /**
     * @param int|string|\DateTime|\DateTimeInterface|null $date
     */
    public function setBirthDate($date): void
    {
        $this->birth_date = Yii::$app->formatter->asTimestamp($date);
    }

    /**
     * @throws Exception
     */
    public function getFallDate(): \DateTime
    {
        return new \DateTime($this->fall_date);
    }

    /**
     * @param int|string|\DateTime|\DateTimeInterface|null $date
     */
    public function setFallDate($date): void
    {
        $this->fall_date = Yii::$app->formatter->asTimestamp($date);
    }

    public function getSize(): float
    {
        return $this->size;
    }

    public function setSize(float $size): void
    {
        $this->size = $size;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @throws Exception
     */
    public function getStatusName(): string
    {
        return ArrayHelper::getValue(AppleStatus::getArray(), $this->getStatus());
    }

    public function canEat(): bool
    {
        return $this->getStatus() === AppleStatus::ON_GROUND;
    }

    public function eat(float $piece): void
    {
        if (!$this->canEat()) {
            throw new InvalidCallException('Нельзя съесть яблоко которое сгнило или висит на дереве.');
        }
        $newSize = $this->getSize() - $piece;
        $this->setSize($newSize < 0 ? 0 : $newSize);
    }

    public function fallFromTree(): void
    {
        if ($this->getStatus() !== AppleStatus::ON_TREE) {
            throw new InvalidCallException('Чтобы яблоко могло упасть, оно должно быть на дереве.');
        }
        $this->setStatus(AppleStatus::ON_GROUND);
        $this->setFallDate(time());
    }

    public function rot(): void
    {
        if ($this->getStatus() !== AppleStatus::ON_GROUND) {
            throw new InvalidCallException('Яблоко может сгнить только на земле.');
        }
        $this->setStatus(AppleStatus::ROTTEN);
    }
}
