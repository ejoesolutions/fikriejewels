<nav class="topnav navbar navbar-light">
  <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
    <i class="fe fe-menu navbar-toggler-icon"></i>
  </button>
  <ul class="nav">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-secondary pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php if ($user_profile['user_group'] == 1): ?>
          <span class="username"><?= $user_profile['username'].' [ ADMIN ] '; ?> </span><?php
          endif;
          if ($user_profile['user_group'] == 0): ?>
            <span class="username"><?= $user_profile['username'].' [ ADMIN ] '; ?> </span><?php
          endif;
          if ($user_profile['user_group'] == 2): ?>
            <span class="username"><?= $user_profile['username'].' [ STAF ]'; ?> </span><?php
          endif;
          if ($user_profile['user_group'] == 3): ?>
            <span class="username"><?= $user_profile['username'].' [ PENGURUS ] '; ?> </span><?php
          endif;
        ?>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="<?php echo base_url('user/detail_user/'.$user_profile["id"]); ?>"><i class="fe fe-edit-3 fe-16 mr-2"></i> Profil</a>
        <a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>"><i class="fe fe-log-out fe-16 mr-2"></i> Log Keluar</a>
      </div>
    </li>
  </ul>
</nav>