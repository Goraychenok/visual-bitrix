<?php

namespace Aerokod\Components\Visual;

class VisualProject
{

    private ?int $width = null;
    private ?int $height = null;
    private ?string $img = null;
    private ?array $houses = null;
    private ?string $year = null;
    private ?array $result = null;
    private ?string $title = null;


    /**
     * @param int|null $width
     * @param int|null $height
     * @param string|null $img
     */
    public function __construct(?int $width = null, ?int $height = null, ?string $img = '')
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
     * @return array|null
     */
    public function getHouses(): ?array
    {
        return $this->houses;
    }

    /**
     * @param array|null $houses
     */
    public function setHouses(?array $houses): void
    {
        $arHouse = array();

        foreach ($houses as $key => $house) {
            $arHouse[$key]['STATUS'] = $this->checkStatus($house['UF_ON_SALE_SOON'], $house['UF_YEAR'], count($house['ITEMS']));
            $arHouse[$key]['POINTS'] = $house['UF_POINTS'];
            $arHouse[$key]['YEAR'] = $house['UF_YEAR'];
            $arHouse[$key]['QUARTER'] = $house['UF_QUARTER'];
            $arHouse[$key]['PERCENT'] = $house['UF_PERCENT'];
            $arHouse[$key]['COUNT_APARTMENTS'] = count($house['ITEMS']);
            $arHouse[$key]['NAME'] = $house['NAME'];
            $arHouse[$key]['ID'] = $house['ID'];

            $arHouse[$key]['APARTMENTS'] = $this->groupApartments((count($house['ITEMS'])) ? $house['ITEMS'] : []);
        }


        $this->houses = $arHouse;
    }

    /**
     * @return string|null
     */
    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * @param string|null $year
     */
    public function setYear(?string $year): void
    {
        $this->year = $year;
    }

    private function checkYear($year): string
    {
        $thisYear = $this->getYear();

        if ($year == $thisYear) {
            return 'key';
        } elseif ($year > $thisYear) {
            return 'sale';
        }
        return '';
    }

    private function checkStatus(bool $thunder, string $year, int $count): string
    {
        if ($thunder) {
            $result = 'thunder';
        } elseif (!$count) {
            $result = 'finish';
        } else {
            $result = $this->checkYear($year);
        }
        return $result;
    }

    private function groupApartments(array $items): string
    {
        $groupApartments = array();
        foreach ($items as $item) {
            $groupApartments[$item['PROPERTY_ROOMS_VALUE']]['SQUARE'][] = $item['PROPERTY_AREA_VALUE'];
            if ($item['PROPERTY_PRICE_VALUE']) {
                $groupApartments[$item['PROPERTY_ROOMS_VALUE']]['PRICE'][] = $item['PROPERTY_PRICE_VALUE'];
            }

        }
        ksort($groupApartments);
        $sortedGroupApartments = array();
        foreach ($groupApartments as $key => $item) {
            $sortedGroupApartments[] = [
                'rooms'   => $key,
                'quarter' => min($item['SQUARE']),
                'price'   => min($item['PRICE']),
            ];
        }

        return json_encode($sortedGroupApartments);
    }

    /**
     * @return array|null
     */
    public function getResult(): ?array
    {
        return $this->result;
    }

    /**
     * @param ?int $iBlock
     * @param ?string $type
     * @param ?int $iBlockApartments
     * @param ?int $projectID
     * @return void
     */

    public function setResult(?int $iBlock, ?string $type, ?int $iBlockApartments, ?int $projectID): void
    {
        $project = array();
        if ($this->getTitle()) {
            $project['NAME'] = $this->getTitle();
        }
        $project['WIDTH'] = $this->getWidth();
        $project['HEIGHT'] = $this->getHeight();
        $project['IMG'] = $this->getImg();
        $project['IBLOCK'] = $iBlock;
        $project['TYPE'] = $type;
        $project['IBLOCK_APARTMENTS'] = $iBlockApartments;
        $project['PROJECT_ID'] = $projectID;
        $project['ITEMS'] = $this->getHouses();
        $this->result = $project;
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




}