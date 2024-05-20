<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    DevBlinders <soporte@devblinders.com>
 * @copyright Copyright (c) DevBlinders
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

include(dirname(__FILE__) . '/../../../../config/config.inc.php');
include(dirname(__FILE__) . '/../../../../init.php');

$module_name = 'dbjointpurchase';

/* //Descomentar si se quiere proteger el ajax
$token = pSQL(Tools::encrypt($module_name.'/controller/admin/ajax.php'));
$token_url = pSQL(Tools::getValue('token'));

if ($token != $token_url || !Module::isInstalled($module_name)) {
    die('ERROR, al ejecurar el ajax');
}*/

$module = Module::getInstanceByName($module_name);
$action = Tools::getValue('action');
$id_product = Tools::getValue('id_product');

/**
 * Activa la funcion que devuelve los productos que coinciden con la busqueda, 
 * luego construye la tabla con los productos encontrados.
 */
if($module->active && $action == 'getAllMatchingProducts') {
    $search = pSQL(Tools::getValue('search'));
    if ($search != '') {
        //echo json_encode($module->getAllMatchingProducts($search));
        $products = $module->getAllMatchingProducts($search);
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nombre</th>';
        echo '<th>Referencia</th>';
        echo '<th>Precio</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $currency = Currency::getCurrencyInstance((int)Context::getContext()->cookie->id_currency);
        foreach ($products as $product) {
            $image_url = _PS_BASE_URL_.'/img/p/'.implode('/', str_split($product['image_url'])).'/'.$product['image_url'].'.jpg';
            echo '<tr onclick="addProduct('.$product['id_product'].')">';
            echo '<td>'.$product['id_product'].'</td>';
            echo '<td><img src="'.$image_url.'" alt="'.$product['name'].'" width="50px" height="50px" >'.$product['name'].'</td>';
            echo '<td>'.$product['reference'].'</td>';
            $price = number_format($product['price'], 2) . ' ' . $currency->sign;
            echo '<td>'.$price.'</td>';
            echo '</tr>';
        }
        echo '</tbody>';
    }
}

/**
 * Activa la funcion que comprueba si existe productos "comprados juntos" y los devuelve,
 * luego construye la tabla con los productos encontrados.
 */
if($module->active && $action == 'getProductsPurchasedTogether') {
    $products = $module->getProductsPurchasedTogether($id_product);
    if(empty($products)) {
        echo '';
    } else {
        echo '<tbody>';
        foreach ($products as $product) {
            echo '<tr>';
            $image_url = _PS_BASE_URL_.'/img/p/'.implode('/', str_split($product['image_url'])).'/'.$product['image_url'].'.jpg';
            echo '<td><img src="'.$image_url.'" alt="'.$product['name'].'" width="50px" height="50px"></td>';
            echo '<td><p><b>'.$product['name'].'</b></p></td>';
            echo '<td><p>REF: '.$product['reference'].'</p></td>';
            echo '<td><a href="#" onclick="return deleteProduct('.$id_product.', '.$product['id_product'].');"><i class="material-icons">delete</i></a></td>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
    }
}

/**
 * Activa la funcion que elimina el producto con la id pasada por parametro de los productos "comprados juntos".
 */
if($module->active && $action == 'deleteProductPurchasedTogether') {
    $id_main_product = Tools::getValue('main_product');
    $id_delete_product = Tools::getValue('product_to_delete');
    $results = $module->removeAProductPurchasedTogether($id_main_product, $id_delete_product);
}

/**
 * Activa la funcion que añade el producto con la id pasada por parametro a los productos "comprados juntos".
 */
if($module->active && $action == 'addProductPurchasedTogether') {
    $new_product = Tools::getValue('new_product');
    $products = $module->addProductPurchasedTogether($id_product, $new_product);
}