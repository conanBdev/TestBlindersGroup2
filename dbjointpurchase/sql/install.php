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

/**
 * Sentencia sql para crear la tabla de productos relacionados.
 */
$sql = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dbjoinpurchase_products_related` (
    `id_product` int(11) NOT NULL AUTO_INCREMENT,
    `id_first_product_related` int(11) DEFAULT NULL,
    `id_second_product_related` int(11) DEFAULT NULL,
    `id_third_product_related` int(11) DEFAULT NULL,
    PRIMARY KEY (`id_product`)
) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';


if (Db::getInstance()->execute($sql) == false) {
    return false;
}
