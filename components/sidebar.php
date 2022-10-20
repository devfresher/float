<div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                                data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button"
                            class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                        <?php $standAloneMenu = $pages->getStandAloneMenu();
                            foreach($standAloneMenu as $index => $menu) {
                                $menuIcon = $menu['icon'];
                                $menuName = $menu['title'];
                                $slug = $menu['slug'];?>
                            
                            <li class="mt-3">
                                <a href="<?php echo BASE_URL.$slug ?>">
                                    <i class="<?php echo $menuIcon; ?>"></i>
                                    <?php echo $menuName ?>
                                </a>
                            </li>
                        <?php } ?>

                        <?php $parentMenus = $pages->getParentMenus();
                        foreach($parentMenus as $index => $parentMenu) {
                            $parentMenuName = $parentMenu['parent_menu'];
                            $menuIcon = $parentMenu['icon'];

                            $subMenus = $pages->getSubMenu($parentMenuName);?>

                            <li class="mt-3 <?php echo (!isset($subMenus['slug']) OR empty($subMenus['slug'])) ? 'd-none':'' ?>">
                                <a href="#">
                                    <i class="<?php echo $menuIcon; ?>"></i>
                                    <?php echo $parentMenuName ?>
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <?php foreach($subMenus['slug'] as $slugIndex => $slug) { ?>
                                        <li class="mt-1">
                                            <a href="<?php echo BASE_URL.$slug;?>" class="fo">
                                                <i class="metismenu-icon"></i> <?php echo $subMenus['title'][$slugIndex];?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>