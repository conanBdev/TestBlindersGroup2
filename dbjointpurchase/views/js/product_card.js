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

$(document).ready(function () {
  //Función para mostrar los productos comprados junto con el producto actual.
  showProducts();
  //Función que actualiza el campo de búsqueda.
  updateSearchInput();

  $("#dbjoinpurchase_search").on("keyup", function () {
    searchProducts();
  });

  $('#dbjoinpurchase_search').on('blur', function() {
    var input = $(this);
    setTimeout(function() {
        input.val('');
        $("#result").html("");
    }, 1000);
  });
});

/**
 * Controla si el campo de búsqueda debe estar habilitado o no.
 */
function updateSearchInput() {
  var productSearch = $('#dbjoinpurchase_search');

  if ($("#products tbody tr").length <= 3) {
    productSearch.prop('disabled', false);
  } else {
    productSearch.prop('disabled', true);
  }
}

/**
 * Muestra los productos "comprados junto habitualmente" con el producto actual.
 */
function showProducts() {
  $.ajax({
    url: '/modules/dbjointpurchase/controller/admin/ajax.php',
    //url: url_ajax, // Ruta al archivo PHP encriptada
    type: "POST",
    data: {
      action: "getProductsPurchasedTogether", 
      id_product: id_product, 
    },
    dataType: "html",
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error: " + textStatus + ", " + errorThrown);
    },
    success: function (response) {
      $("#products").html(response);
      updateSearchInput();
    },
  });
}

/**
 * Busca los productos que coincidan con el texto introducido en el campo de búsqueda.
 */
function searchProducts() {
  var res = "";
  var productSearch = $('#dbjoinpurchase_search');

  if (productSearch.val().length >= 3) {
    $.ajax({
      url: '/modules/dbjointpurchase/controller/admin/ajax.php',
      type: "POST",
      data: {
        action: "getAllMatchingProducts",
        search: productSearch.val(), 
      },
      dataType: "html",
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error: " + textStatus + ", " + errorThrown);
      },
      success: function (response) {
        $("#result").html(response);
        updateSearchInput(); 
      },
    });
  } else {
    $("#result").html("");
  }
}

/**
 * Añade un producto a la lista de Packs de productos recomendados.
 * @param {int} id_new_product ID del producto a añadir.
 */
function addProduct(id_new_product) {  
    $.ajax({
      url: '/modules/dbjointpurchase/controller/admin/ajax.php', 
      //url: url_ajax, // Ruta al archivo PHP encriptada
      type: "POST",
      data: {
        action: "addProductPurchasedTogether",
        id_product: id_product, 
        new_product: id_new_product,
      },
      dataType: "html",
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error: " + textStatus + ", " + errorThrown);
      },
      success: function (response) {
        showProducts();
      },
    });
}

/**
 * Elimina el producto seleccionado de la lista de Packs de productos recomendados.
 * @param {int} id_main_product ID del producto principal.
 * @param {int} id_product_to_delete ID del producto a eliminar.
 */
function deleteProduct(id_main_product, id_product_to_delete) {
  id_main_product = Number.isInteger(id_main_product) ? id_main_product : parseInt(id_main_product);
  id_product_to_delete = Number.isInteger(id_product_to_delete) ? id_product_to_delete : parseInt(id_product_to_delete);  
    $.ajax({
      url: '/modules/dbjointpurchase/controller/admin/ajax.php', 
      //url: url_ajax, // Ruta al archivo PHP encriptada
      type: "POST",
      data: {
        action: "deleteProductPurchasedTogether",
        main_product: id_main_product, 
        product_to_delete: id_product_to_delete,
      },
      dataType: "html",
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error: " + textStatus + ", " + errorThrown);
      },
      success: function (response) {
        showProducts();
      },
    });  
  return false;
}
