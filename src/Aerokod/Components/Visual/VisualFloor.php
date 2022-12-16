<?php

namespace Aerokod\Components\Visual;

class VisualFloor
{
    private ?string $img = null;
    private ?int $width = null;
    private ?int $height = null;
    private ?int $iBlock = null;
    private ?string $type = null;
    private ?int $projectId = null;
    private ?int $houseId = null;
    private ?int $apartmentID = null;
    private ?int $floor = null;
    private ?array $points = null;
    private ?array $items = null;
    private ?array $result = null;
    private ?string $houseName  = null;
    private ?string $floorName = null;
    private ?int $quarter = null;
    private ?int $year = null;
    private ?array $floors = null;
    private ?string $minPlan = null;
    private ?array $houseList = null;


    /**
     * @param string|null $img
     * @param int|null $width
     * @param int|null $height
     * @param int|null $iBlock
     * @param string|null $type
     * @param int|null $projectId
     * @param int|null $houseId
     */
    public function __construct(?string $img = null, ?int $width = null, ?int $height = null, ?int $iBlock = null, ?string $type = null, ?int $projectId = null, ?int $houseId = null, ?int $apartmentID = null, ?string $houseName = null, ?string $floorName = null)
    {
        $this->img = $img;
        $this->width = $width;
        $this->height = $height;
        $this->iBlock = $iBlock;
        $this->type = $type;
        $this->projectId = $projectId;
        $this->houseId = $houseId;
        $this->apartmentID = $apartmentID;
        $this->houseName = $houseName;
        $this->floorName = $floorName;
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
     * @return int|null
     */
    public function getIBlock(): ?int
    {
        return $this->iBlock;
    }

    /**
     * @param int|null $iBlock
     */
    public function setIBlock(?int $iBlock): void
    {
        $this->iBlock = $iBlock;
    }

    /**
     * @return int|null
     */
    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    /**
     * @param int|null $projectId
     */
    public function setProjectId(?int $projectId): void
    {
        $this->projectId = $projectId;
    }

    /**
     * @return int|null
     */
    public function getHouseId(): ?int
    {
        return $this->houseId;
    }

    /**
     * @param int|null $houseId
     */
    public function setHouseId(?int $houseId): void
    {
        $this->houseId = $houseId;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int|null
     */
    public function getApartmentID(): ?int
    {
        return $this->apartmentID;
    }

    /**
     * @param int|null $apartmentID
     */
    public function setApartmentID(?int $apartmentID): void
    {
        $this->apartmentID = $apartmentID;
    }

    /**
     * @return int|null
     */
    public function getFloor(): ?int
    {
        return $this->floor;
    }

    /**
     * @param int|null $floor
     */
    public function setFloor(?int $floor): void
    {

        $this->floor = $floor;
    }

    /**
     * @return array|null
     */
    public function getPoints(): ?array
    {
        return $this->points;
    }

    /**
     * @param array|null $points
     */
    public function setPoints(?array $points): void
    {
        $this->points = $points;
    }

    /**
     * @return array|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * @param array|null $items
     */
    public function setItems(?array $items): void
    {
        $refactorItems = array();

        foreach ($items as $key => $item) {
            $refactorItems[$key]['ID'] = $item['ID'];
            $refactorItems[$key]['SQUARE'] = $item['PROPERTY_AREA_VALUE'];
            $refactorItems[$key]['PRICE'] = $item['PROPERTY_PRICE_VALUE'];
            $refactorItems[$key]['ROOM'] = $item['PROPERTY_ROOMS_VALUE'];
            $refactorItems[$key]['FINISH'] = $item['PROPERTY_FINISH_VALUE'];
            $refactorItems[$key]['NUMBER'] = $item['PROPERTY_NUMBER_VALUE'];
            $refactorItems[$key]['URL'] = $item['DETAIL_PAGE_URL'];
            $refactorItems[$key]['POINT'] = $this->checkPointFloor($item['PROPERTY_RISER_VALUE']);
        }
        $this->items = $refactorItems;
    }

    private function checkPointFloor(?int $riser): string
    {

        $pointsArr = $this->getPoints();
        $key = $riser - 1;
        $point = $pointsArr[$key];
        unset($pointsArr[$key]);
        $this->setPoints($pointsArr);

        if ($point) {
            return $point;
        } else {
            return '';
        }
    }

    /**
     * @return array|null
     */
    public function getResult(): ?array
    {
        return $this->result;
    }

    /**
     * @return string|null
     */
    public function getHouseName(): ?string
    {
        return $this->houseName;
    }

    /**
     * @param string|null $houseName
     */
    public function setHouseName(?string $houseName): void
    {
        $this->houseName = $houseName;
    }

    /**
     * @return string|null
     */
    public function getFloorName(): ?string
    {
        return $this->floorName;
    }

    /**
     * @param string|null $floorName
     */
    public function setFloorName(?string $floorName): void
    {
        $this->floorName = $floorName;
    }

    /**
     * @return int|null
     */
    public function getQuarter(): ?int
    {
        return $this->quarter;
    }

    /**
     * @param int|null $quarter
     */
    public function setQuarter(?int $quarter): void
    {
        $this->quarter = $quarter;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     */
    public function setYear(?int $year): void
    {
        $this->year = $year;
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
        $this->floors = $this->reformatFloors($floors);
    }

    private function reformatFloors(?array $floors): array
    {
        $arFloors = array();
        foreach ($floors as $floor) {
            $arFloors[$floor['PROPERTY_FLOOR_VALUE']] = $floor['ID'];
        }
        return $arFloors;
    }

    /**
     * @return string|null
     */
    public function getMinPlan(): ?string
    {
        return $this->minPlan;
    }

    /**
     * @param string|null $minPlan
     */
    public function setMinPlan(?string $minPlan): void
    {
        $this->minPlan = $minPlan;
    }

    /**
     * @return array|null
     */
    public function getHouseList(): ?array
    {
        return $this->houseList;
    }

    /**
     * @param array|null $houseList
     */
    public function setHouseList(?array $houseList): void
    {

        $this->houseList = $this->refactorHouseList($houseList);
    }

    private function refactorHouseList(?array $houseList): array
    {
        $arHouseList = array();
        foreach ($houseList as $key => $house) {
            $arHouseList[$key]['ID'] =  $house['ID'];
            $arHouseList[$key]['POINTS'] = $house['UF_SMALL_POINTS'];
            $arHouseList[$key]['IMG'] = $house['PICTURE_URL'];
            //Проверка на наличие квартир у дома
            if(!$house['ITEMS']){
                $arHouseList[$key]['HIDDEN'] = true;
            }
        }
        return  $arHouseList;
    }

    public function setResult(): void
    {
        $resultArr = array(
            'IMG' => $this->getImg(),
            'WIDTH' => $this->getWidth(),
            'HEIGHT' => $this->getHeight(),
            'IBLOCK' => $this->getIBlock(),
            'TYPE' => $this->getType(),
            'PROJECT_ID' => $this->getProjectId(),
            'HOUSE_ID' => $this->getHouseId(),
            'HOUSE_NAME' => $this->getHouseName(),
            'FLOOR_NAME' => $this->getFloorName(),
            'APARTMENTS_ID' => $this->getApartmentID(),
            'FLOOR' => $this->getFloor(),
            'ITEMS' => $this->getItems(),
            'QUARTER' => $this->getQuarter(),
            'YEAR' => $this->getYear(),
            'FLOORS' => $this->getFloors(),
            'HOUSE_LIST' => $this->getHouseList(),
            'MIN_PLAN' => $this->getMinPlan(),
            'SOLD_ITEMS' => $this->getPoints()
        );


        $this->result = $resultArr;
    }

}