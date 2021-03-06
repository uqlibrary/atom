<?php decorate_with('layout_1col') ?>
<?php use_helper('Date') ?>
<?php use_helper('Text') ?>

<?php slot('title') ?>

  <div class="multiline-header">
    <?php echo image_tag('/images/icons-large/icon-new.png', array('width' => '42', 'height' => '42', 'alt' => '')) ?>
    <h1 aria-describedby="results-label">
      <?php if (isset($pager) && $pager->getNbResults()): ?>
        <?php echo __('Showing %1% results', array('%1%' => $pager->getNbResults())) ?>
      <?php else: ?>
        <?php echo __('No results') ?>
      <?php endif; ?>
    </h1>
    <?php if (isset($pager) && $pager->getNbResults()): ?>
      <span class="sub" id="results-label"><?php echo __('Newest additions') ?></span>
    <?php endif; ?>
  </div>

<?php end_slot() ?>

<?php slot('content') ?>

  <?php echo get_partial('search/updatesSearch', array(
    'form'         => $form,
    'show'         => $showForm,
    'user'         => $user)) ?>

  <?php if ('QubitInformationObject' == $className && sfConfig::get('app_audit_log_enabled', false)): ?>

    <table class="table table-bordered table-striped sticky-enabled" id="clipboardButtonNode">
      <thead>
        <tr>
          <th>
            <?php echo __('Title') ?>
          </th>
          <th>
            <?php echo __('Repository') ?>
          </th>
          <?php if ('CREATED_AT' != $form->getValue('dateOf')): ?>
            <th style="width: 110px"><?php echo __('Updated'); ?></th>
          <?php else: ?>
            <th style="width: 110px"><?php echo __('Created'); ?></th>
          <?php endif; ?>
            <th style="width: 110px">
              <a href="#" class="all">All</a>
              <div class="separator" style="display: inline;">/</div>
              <a href="#" class="none">None</a>
            </th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($pager->getResults() as $result): ?>
        <?php $io = QubitInformationObject::getById($result->objectId) ?>
        <tr>
          <td>
            <?php echo link_to(render_title($io), array('slug' => $io->slug, 'module' => 'informationobject')) ?>
          </td>
          <td>
            <?php if (!empty($io->repository)): ?>
              <?php echo link_to(render_title($io->repository->authorizedFormOfName), array('slug' => $io->repository->slug, 'module' => 'repository')) ?>
            <?php endif; ?>
          </td>
          <td>
            <?php echo format_date($result->createdAt, 'f') ?>
          </td>
          <td>
            <?php echo get_component('object', 'clipboardButton', array('slug' => $io->slug, 'wide' => true)) ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

  <?php else: ?>
    <?php if (isset($pager) && $pager->getNbResults()): ?>

      <table class="table table-bordered table-striped sticky-enabled" id="clipboardButtonNode">
        <thead>
          <tr>
            <th><?php echo __($nameColumnDisplay); ?></th>
            <?php if ('QubitInformationObject' == $className && 0 < sfConfig::get('app_multi_repository')): ?>
              <th><?php echo __('Repository') ?></th>
            <?php elseif ('QubitTerm' == $className): ?>
              <th><?php echo __('Taxonomy'); ?></th>
            <?php endif; ?>
            <?php if ('CREATED_AT' != $form->getValue('dateOf')): ?>
              <th style="width: 110px"><?php echo __('Updated'); ?></th>
            <?php else: ?>
              <th style="width: 110px"><?php echo __('Created'); ?></th>
            <?php endif; ?>
            <?php if ('QubitInformationObject' == $className || 'QubitActor' == $className || 'QubitRepository' == $className): ?>
              <th style="width: 110px">
                <a href="#" class="all">All</a>
                <div class="separator" style="display: inline;">/</div>
                <a href="#" class="none">None</a>
              </th>
            <?php endif; ?>
          </tr>
        </thead><tbody>
        <?php foreach ($pager->getResults() as $result): ?>

          <?php $doc = $result->getData() ?>

          <tr>

            <td>

              <?php if ('QubitInformationObject' == $className): ?>

                <?php echo link_to(render_title(get_search_i18n($doc, 'title', array('allowEmpty' => false))), array('slug' => $doc['slug'], 'module' => 'informationobject')) ?>
                <?php $status = (isset($doc['publicationStatusId'])) ? QubitTerm::getById($doc['publicationStatusId']) : null ?>
                <?php if (isset($status) && $status->id == QubitTerm::PUBLICATION_STATUS_DRAFT_ID): ?><span class="note2"><?php echo ' ('.render_value_inline($status).')' ?></span><?php endif; ?>

              <?php elseif ('QubitActor' == $className): ?>

                <?php $name = render_title(get_search_i18n($doc, 'authorizedFormOfName', array('allowEmpty' => false))) ?>
                <?php echo link_to($name, array('slug' => $doc['slug'], 'module' => 'actor')) ?>

              <?php elseif ('QubitFunction' == $className): ?>

                <?php $name = render_title(get_search_i18n($doc, 'authorizedFormOfName', array('allowEmpty' => false))) ?>
                <?php echo link_to($name, array('slug' => $doc['slug'], 'module' => 'function')) ?>

              <?php elseif ('QubitRepository' == $className): ?>

                <?php $name = render_title(get_search_i18n($doc, 'authorizedFormOfName', array('allowEmpty' => false))) ?>
                <?php echo link_to($name, array('slug' => $doc['slug'], 'module' => 'repository')) ?>

              <?php elseif ('QubitTerm' == $className): ?>

                <?php $name = render_title(get_search_i18n($doc, 'name', array('allowEmpty' => false))) ?>
                <?php echo link_to($name, array('slug' => $doc['slug'], 'module' => 'term')) ?>

              <?php endif; ?>

            </td>

            <?php if ('QubitInformationObject' == $className && 0 < sfConfig::get('app_multi_repository')): ?>
              <td>
                <?php if (null !== $repository = (isset($doc['repository'])) ? render_title(get_search_i18n($doc['repository'], 'authorizedFormOfName', array('allowEmpty' => false))) : null): ?>
                  <?php echo $repository ?>
                <?php endif; ?>
              </td>
            <?php elseif('QubitTerm' == $className): ?>
              <td><?php echo render_title(get_search_i18n($doc, 'name', array('allowEmpty' => false))) ?></td>
            <?php endif; ?>

            <td>
              <?php if ('CREATED_AT' != $form->getValue('dateOf')): ?>
                <?php echo format_date($doc['updatedAt'], 'f') ?>
              <?php else: ?>
                <?php echo format_date($doc['createdAt'], 'f') ?>
              <?php endif; ?>
            </td>

            <?php if ('QubitInformationObject' == $className || 'QubitActor' == $className || 'QubitRepository' == $className): ?>
              <td>
                <?php echo get_component('object', 'clipboardButton', array('slug' => $doc['slug'], 'wide' => true)) ?>
              </td>
            <?php endif; ?>

          </tr>

        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
  <?php endif; ?>

<?php end_slot() ?>

<?php slot('after-content') ?>
  <?php echo get_partial('default/pager', array('pager' => $pager)) ?>
<?php end_slot() ?>
