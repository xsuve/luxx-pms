<!-- Sidebar -->
<?php
  $modules_model = $this->loadModel('ModulesModel');
  $pinned_modules = $modules_model->getPinnedInstalledModules($account->id);
?>

<div class="sidebar b-white">
  <div class="sidebar-logo text-center">
    <div class="v-middle">
      <img src="<?php echo URL; ?>public/img/luxx-logo.svg">
      <span class="c-title">luxx</span>
    </div>
  </div>
  <div class="sidebar-links">
    <a href="<?php echo URL; ?>dashboard" id="dashboardLink">
      <div class="text c-gray">
        <i class="fe fe-tiled"></i>
        <span>DASHBOARD</span>
      </div>
    </a>
    <a href="<?php echo URL; ?>contacts" id="contactsLink">
      <div class="text c-gray">
        <i class="fe fe-user"></i>
        <span>CONTACTS</span>
      </div>
    </a>
    <a href="<?php echo URL; ?>projects" id="projectsLink">
      <div class="text c-gray">
        <i class="fe fe-layer"></i>
        <span>PROJECTS</span>
      </div>
    </a>
    <a href="<?php echo URL; ?>invoices" id="invoicesLink">
      <div class="text c-gray">
        <i class="fe fe-document"></i>
        <span>INVOICES</span>
      </div>
    </a>
    <a href="<?php echo URL; ?>modules" id="modulesLink">
      <div class="text c-gray">
        <i class="fe fe-difference"></i>
        <span>MODULES</span>
      </div>
    </a>
    <a href="<?php echo URL; ?>categories" id="categoriesLink">
      <div class="text c-gray">
        <i class="fe fe-tag"></i>
        <span>CATEGORIES</span>
      </div>
    </a>
    <a href="<?php echo URL; ?>logout">
      <div class="text c-gray">
        <i class="fe fe-logout"></i>
        <span>LOG OUT</span>
      </div>
    </a>
  </div>
  <?php if(count($pinned_modules) > 0): ?>
    <div class="line-divider sidebar-line"></div>
    <div class="sidebar-links">
      <?php $i = 1; ?>
      <?php foreach($pinned_modules as $pinned_module): ?>
        <?php if($i <= 3): ?>
          <?php $pinned_module_name = basename($pinned_module); ?>
          <a href="<?php echo URL; ?>modules/view/<?php echo $pinned_module_name; ?>" id="<?php echo $pinned_module_name; ?>Link">
            <div class="text c-gray">
              <i class="fe fe-difference"></i>
              <span><?php echo strtoupper($pinned_module_name); ?></span>
            </div>
          </a>
        <?php endif; ?>
        <?php $i++; ?>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>