<?php

namespace Aerokod\Components\Visual;

class VisualHouse
{
    private ?int $width = null;
    private ?int $height = null;
    private ?string $img = null;
    private ?string $title = null;
    private ?array $floors = null;
    private ?array $result = null;

    /**
     * @param int|null $width
     * @param int|null $height
     * @param string|null $img
     */
    public function __construct(?int $width = null, ?int $height = null, ?string $img = null)
    {
        $this->width = $width;
        $this->height = $height;
        $this->img = $img;
    }


    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     */
    public function setWidth(?int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     */
    public function setHeight(?int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param string|null $img
     */
    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return array|null
     */
    public function getFloors(): ?array
    {
        return $this->floors;
    }

    /**
     * @param array|null $floors
     */
    public function setFloors(?array $floors): void
    {
        $arFloors = array();
        foreach ($floors as $key => $floor) {
            if ($this->checkFloor($floor['ITEMS'])) {
                $arFloors[$key]['ITEMS'] = $this->groupItems($floor['ITEMS']);
                $arFloors[$key]['COUNT_ITEMS'] = count($floor['ITEMS']);
                $arFloors[$key]['FLOOR'] = $floor['PROPERTY_FLOOR_VALUE'];
                $arFloors[$key]['POINTS'] = $floor['PROPERTY_POINTS_VALUE'];
                $arFloors[$key]['NAME'] = $floor['NAME'];
                $arFloors[$key]['ID'] = $floor['ID'];
            }
        };
        $this->floors = $arFloors;
    }

    /**
     * @return array|null
     */
    public function getResult(): ?array
    {
        return $this->result;
    }

    /**
     * @param int|null $iBlock
     * @param string|null $type
     * @param int|null $apartmentsId
     * @param int|null $sectionId
     * @param int|null $houseID
     * @param string|null $houseName
     */
    public function setResult(?int $iBlock, ?string $type, ?int $apartmentsId, ?int $sectionId, ?int $houseID, ?string $houseName): void
    {
        $house = array();
        if ($this->getTitle()) {
            $house['TITLE'] = $this->getTitle();
        }
        $house['IBLOCK'] = $iBlock;
        $house['TYPE'] = $type;
        $house['APARTMENTS_ID'] = $apartmentsId;
        $house['PROJECT_ID'] = $sectionId;
        $house['HOUSE_ID'] = $houseID;
        $house['NAME'] = $houseName;
        $house['IMG'] = $this->getImg();
        $house['WIDTH'] = $this->getWidth();
        $house['HEIGHT'] = $this->getHeight();
        $house['ITEMS'] = $this->getFloors();

        $this->result = $house;

    }

    private function checkFloor($items): bool
    {
        if (count($items) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    private function groupItems($items): string
    {
        $arItems = array();
        foreach ($items as $key => $item) {
            if ($item['PROPERTY_PRICE_VALUE']) {
                $arItems[$item['PROPERTY_ROOMS_VALUE']]['PRICE'][] = $item['PROPERTY_PRICE_VALUE'];
            }
            if ($item['PROPERTY_AREA_VALUE']) {
                $arItems[$item['PROPERTY_ROOMS_VALUE']]['SQUARE'][] = $item['PROPERTY_AREA_VALUE'];
            }
        }
        ksort($arItems);

        $sortedGroupApartments = array();
        foreach ($arItems as $key => $item) {
            $sortedGroupApartments[] = [
                'rooms'   => $key,
                'quarter' => min($item['SQUARE']),
                'price'   => min($item['PRICE']),
            ];
        }

        return json_encode($sortedGroupApartments);

    }


}