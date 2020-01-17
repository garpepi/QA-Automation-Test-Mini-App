<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-wrench"></i>
        </div>
        <div class="sidebar-brand-text mx-3" style="font-size: small;"><?php echo $this->config->item('siteName');?></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Home -->
      <li class="nav-item <?php if($CaseNumber['number'] == 0)echo 'active';?>">
        <a class="nav-link" href="<?php echo base_url();?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Home</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Case
      </div>

      <!-- Nav Item - Charts -->
      <li class="nav-item <?php if($CaseNumber['number'] == 1)echo 'active';?>">
        <a class="nav-link" href="<?php echo base_url();?>caseone">
          <i class="fa-stack">
              <!-- The icon that will wrap the number -->
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <!-- a strong element with the custom content, in this case a number -->
              <strong class="fa-stack-1x">
                  1    
              </strong>
          </i>
          
          <span>One</span></a>
      </li>
      <li class="nav-item <?php if($CaseNumber['number'] == 2)echo 'active';?>">
        <a class="nav-link" href="<?php echo base_url();?>casetwo">
          <i class="fa-stack">
              <!-- The icon that will wrap the number -->
              <span class="fa fa-circle-o fa-stack-2x"></span>
              <!-- a strong element with the custom content, in this case a number -->
              <strong class="fa-stack-1x">
                  2
              </strong>
          </i>
          
          <span>Two</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->