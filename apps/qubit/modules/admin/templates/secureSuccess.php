<section class="admin-message" id="error-secure">

  <h2><?php echo __('Sorry, you do not have permission to access that page'); ?></h2>

  <div class="tips">
     <p><?php echo __('To request access to this resource please use the ') ?>
       <a href="https://web.library.uq.edu.au/library-services/special-collections/fryer-item-request-form"><?php echo __("Fryer item request form.") ?></a>
     </p>
     <p><a href="javascript:history.go(-1)"><?php echo __('Back to previous page'); ?></a></p>
    <p><?php echo link_to(__('Go to homepage'), '@homepage'); ?></p>
  </div>

</section>
