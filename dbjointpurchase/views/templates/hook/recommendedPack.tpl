<div id="dbjoinpurchase_recomendedPack">
    <h2>{$title}</h2>
    <div class="row">
        <input type="text" id="dbjoinpurchase_search" class="form-control" autocomplete="off" placeholder="Buscar productos" disabled="true">
    </div>
    <table id="result" class="product-selector">
    </table>
    <div>
        <table id="products">
        </table>
    </div>
</div>

<script>
    const url_ajax = "{$url_ajax|escape:'html':'UTF-8'}";
    const id_product = {$id_product};
</script>