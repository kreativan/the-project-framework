<template id="my-template">
  <swal-icon type="info"></swal-icon>
  <swal-title>Project Settings</swal-title>
  <swal-html>
    <table class="p-table p-text-small p-text-left p-table-striped p-margin-top">
      <tbody>
        <?php foreach(the_project() as $key => $value) :?>
        <tr>
          <td><?= $key ?></td>
          <td><?= $value ?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </swal-html>
  <swal-footer>
  <a href="<?= get_admin_url() ?>options-general.php?page=project-settings" class="p-link">Change settings here</a>
  </swal-footer>
</template>

<script>
function previewSettings() {
  event.preventDefault();
  Swal.fire({
    template: '#my-template',
    width: '800px',
    customClass: 'p-margin-lg',
    //showCancelButton: true,
    //confirmText: true,
    //confirmButtonText: 'Change Settings',
  }) 
}
</script>