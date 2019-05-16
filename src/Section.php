<?php
namespace iPremium\Bitrix\iBlock;

use iPremium\Bitrix\iBlock\QueryBilder;

class Section
{
    use QueryBilder;
    /*
    use this param true if you want write in lovercase params
    and script auto transform it to BITRIX_CAPS_STYLE
     */
    protected $lovercase = false;


    protected $order = [
        "SORT" => "ASC"
    ];

    protected $defalutSelect = [
        "ID",
        "IBLOCK_ID",
        "IBLOCK_SECTION_ID",
        "NAME",
        "DESCRIPTION",
        "UF_*",
        "SECTION_PAGE_URL"
    ];

    public function __construct($id, $return)
    {
        $this->iblockId = $id;
        //to do use global settings in iBLock::instanse()->elementLoverCase();
    }


    public function get($method = null)
    {
        $sections = [];

        if ( \CModule::IncludeModule("iblock"))
        {

            $select = (is_null($this->select)) ? $this->defalutSelect : $this->select;

            //fn_print_r($this->filter);

            $dbSectionList = \CIBlockSection::GetList($this->order, $this->filter, false, $select);

            while($arSection = $dbSectionList->GetNext())
    		{
                if ( is_callable($method) )
                {
                    call_user_func_array($method, [ &$arSection ]);
                }

                if ($count == 1) {
                    return $sections = $arSection;
                }

                $sections[] = $arSection;
    		}

            return $sections;
        }
        else
        {
            return false;
        }
    }



}
