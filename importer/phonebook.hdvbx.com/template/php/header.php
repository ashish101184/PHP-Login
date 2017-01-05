  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?php print PATH_DOMAIN ?>" class="logo dynaload">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>HD VBX</b> PhoneBook</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>HD VBX</b> PhoneBook</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="<?php print PATH_DOMAIN ?>/account/profile" class="dropdown-toggle">
              <!-- The user image in the navbar-->
              <img src="<?php print PATH_DOMAIN; ?>/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php print $_SESSION['client']['firstname'].' '.$_SESSION['client']['lastname']; ?></span>
            </a>
          </li>
          <li class="user-menu">
			<a href="<?php print PATH_DOMAIN ?>/?logout" id="signout">Sign out</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>