<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$APPLICATION->AddHeadScript('http://api-maps.yandex.ru/2.1/?lang=ru_RU');

$arResult['WIDTH_MAP']	 = !empty($arParams['WIDTH_MAP'])  ? $arParams['WIDTH_MAP']  : '600px';
$arResult['HEIGHT_MAP']	 = !empty($arParams['HEIGHT_MAP']) ? $arParams['HEIGHT_MAP'] : '400px';
$arResult['CENTER_MAP']	 = !empty($arParams['CENTER_MAP']) ? $arParams['CENTER_MAP'] : 'Россия';
$arResult['ZOOM_MAP']	 = !empty($arParams['ZOOM_MAP'])   ? (int) $arParams['ZOOM_MAP']   : 11;
$arResult['ITEMS']		 = array();

if ( $arParams['TYPE_MAP'] == 'IBLOCK' )
{
	\Bitrix\Main\Loader::includeModule("iblock");
	
	$arFilter = array(
		"IBLOCK_ID"			 => $arParams["IBLOCK_ID"],
		"IBLOCK_LID"		 => SITE_ID,
		"IBLOCK_ACTIVE"		 => "Y",
		"ACTIVE_DATE"		 => "Y",
		"ACTIVE"			 => "Y",
		"CHECK_PERMISSIONS"	 => "Y",
		"MIN_PERMISSION"	 => "R",
	);
	
	$prop		 = 'PROPERTY_' . $arParams['IBLOCK_PROPERTY'];
	$prop_val	 = 'PROPERTY_' . $arParams['IBLOCK_PROPERTY'] . '_VALUE';
	
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		$prop
	);
	
	$rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	while($ob = $rsElements->GetNextElement())
	{
		$arItem	= $ob->GetFields();
		
		if ( !empty($arItem[$prop_val]) ) $arResult['ITEMS'][] = $arItem[$prop_val];
	}
}
else
{
	$arResult['ITEMS'] = array_filter($arParams['ADRESA']);
}

$this->IncludeComponentTemplate();
?>
