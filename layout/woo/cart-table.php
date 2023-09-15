<?php
$is_empty = WC()->cart->is_empty();
$cart = WC()->cart->get_cart();
?>

<?php if (!$is_empty) : ?>
  <table class="uk-table uk-table-divider uk-table-middle uk-text-small">

    <tbody>
      <?php foreach ($cart as $key => $item) :
        $product = $item['data'];
        $quantity = $item['quantity'];
        $price = WC()->cart->get_product_price($product);
      ?>
        <tr>
          <td class="uk-padding-remove-horizontal">
            <div class="uk-overflow-hidden" style="height: 70px;width:70px;">
              <?= $product->get_image('thumbnail', ['class' => 'cart-thumb']) ?>
            </div>
          </td>

          <td>
            <a href="<?= $product->get_permalink() ?>">
              <?= $product->get_title() ?>
            </a>
            <br />
            <?= $quantity ?> x <?= $price ?>
          </td>

          <td class="uk-padding-remove-horizontal uk-text-right">
            <a href="#" class="remove-from-cart uk-link-reset" onclick="woo.removeFromCart(<?= $item['product_id'] ?>, '<?= $item['key']; ?>', false)">
              <i class="toggle-icon uk-text-danger" uk-icon="trash" class="uk-text-danger"></i>
              <i class="toggle-spinner uk-hidden uk-spinner uk-text-danger" uk-spinner="ratio: 0.7;"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>

    <tfoot>
      <tr>
        <td class="uk-padding-remove-horizontal" colspan="2">
          Subtotal
        </td>
        <td class="uk-text-right">
          <h5 class="uk-text-bold uk-margin-remove">
            <?= WC()->cart->get_total() ?>
          </h5>
        </td>
      </tr>
    </tfoot>

  </table>
<?php else : ?>

  <p class="uk-text-muted">
    Cart is empty
  </p>

<?php endif; ?>