{*
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
 *}

 <div class="content-product-related">
    <h2>Producto relacionado</h2>
    <div class="product-selector">
    <select>
        {foreach from=$all_products item=product}
            <option value="{$product.id_product}">{$product.name}</option>
        {/foreach}
    </select>
    </div>

    <div class="related-products">
    {if $related_products}
        <ul>
            {foreach from=$related_products item=product}
                <li>{$product.name}</li>
            {/foreach}
        </ul>
    {/if}
    </div>
</div>