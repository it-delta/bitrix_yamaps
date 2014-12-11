<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

if(!CModule::IncludeModule("iblock")) return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(Array("-"=>" "));

$arIBlocks=Array();
$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];

$arSorts = Array("ASC"=>GetMessage("T_IBLOCK_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = Array(
		"ID"=>GetMessage("T_IBLOCK_DESC_FID"),
		"NAME"=>GetMessage("T_IBLOCK_DESC_FNAME"),
		"ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT"),
		"SORT"=>GetMessage("T_IBLOCK_DESC_FSORT"),
		"TIMESTAMP_X"=>GetMessage("T_IBLOCK_DESC_FTSAMP")
	);

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S")))
	{
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arComponentParameters = array (
	"GROUPS" => array(),
	"PARAMETERS" => array (
		"TYPE_MAP" => array (
			"PARENT" => "BASE",
			"NAME" => GetMessage("ITD_YM_PARAM_TYPE_MAP_NAME"),
			"TYPE" => "LIST",
			"VALUES" => array (
				"IBLOCK" => GetMessage("ITD_YM_PARAM_TYPE_MAP_LIST_IBLOCK"),
				"COMPONENT" => GetMessage("ITD_YM_PARAM_TYPE_MAP_LIST_COMPONENT"),
			),
			"DEFAULT" => "COMPONENT",
			"REFRESH" => "Y",
		),
		"WIDTH_MAP" => array (
			"PARENT" => "BASE",
			"NAME" => GetMessage("ITD_YM_PARAM_WIDTH_MAP_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => '600px',
		),
		"HEIGHT_MAP" => array (
			"PARENT" => "BASE",
			"NAME" => GetMessage("ITD_YM_PARAM_HEIGHT_MAP_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => '400px',
		),
		"CENTER_MAP" => array (
			"PARENT" => "BASE",
			"NAME" => GetMessage("ITD_YM_PARAM_CENTER_MAP_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => 'Ростов-на-Дону',
		),
		"ZOOM_MAP" => array (
			"PARENT" => "BASE",
			"NAME" => GetMessage("ITD_YM_PARAM_ZOOM_MAP_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => '11',
		),
	),
);

if ($arCurrentValues["TYPE_MAP"] == 'IBLOCK') 
{
	$arComponentParameters["PARAMETERS"]["IBLOCK_TYPE"] = 
			array (
				"PARENT" => "BASE",
				"NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
				"TYPE" => "LIST",
				"VALUES" => $arTypesEx,
				"DEFAULT" => "",
				"REFRESH" => "Y",
			);

	$arComponentParameters["PARAMETERS"]["IBLOCK_ID"] = 
			array (
				"PARENT" => "BASE",
				"NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
				"TYPE" => "LIST",
				"VALUES" => $arIBlocks,
				"DEFAULT" => '',
				"ADDITIONAL_VALUES" => "Y",
				"REFRESH" => "Y",
			);
	
	$arComponentParameters["PARAMETERS"]["IBLOCK_PROPERTY"] = 
			array (
				"PARENT" => "BASE",
				"NAME" => GetMessage("ITD_YM_PARAM_IBLOCK_PROPERTY_NAME"),
				"TYPE" => "STRING",
				"DEFAULT" => '',
			);
}
else
{
	$arComponentParameters["PARAMETERS"]["ADRESA"] = 
			array (
				"PARENT" => "BASE",
				"NAME" => GetMessage("ITD_YM_PARAM_ADRESA_NAME"),
				"TYPE" => "LIST",
				"VALUES" => array(),
				"DEFAULT" => '',
				"ADDITIONAL_VALUES" => "Y",
				"REFRESH" => "N",
				"MULTIPLE"	 => "Y",
			);
}


?>
